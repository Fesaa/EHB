package art.ameliah.ehb.keyveil.core.auth

import android.content.Context
import android.content.Intent
import androidx.core.net.toUri
import net.openid.appauth.*
import art.ameliah.ehb.keyveil.core.storage.SecureStorage
import kotlinx.coroutines.suspendCancellableCoroutine
import kotlin.coroutines.resume
import kotlin.coroutines.resumeWithException

class KeycloakAuthManager(private val context: Context) {

    private val secureStorage = SecureStorage(context)
    private var authService: AuthorizationService? = null
    private var authState: AuthState? = null

    companion object {
        private const val KEY_AUTH_STATE = "auth_state"
        private const val REDIRECT_URI = "art.ameliah.ehb.keyveil://oauth2redirect"
        private const val SCOPE = "openid profile email"
    }

    init {
        restoreAuthState()
    }

    fun isConfigured(): Boolean {
        val clientId = secureStorage.getValue(SecureStorage.KEY_CLIENT_ID)
        val authority = secureStorage.getValue(SecureStorage.KEY_AUTHORITY)

        return !clientId.isNullOrEmpty() && !authority.isNullOrEmpty()
    }

    fun isAuthenticated(): Boolean {
        return authState?.isAuthorized == true
    }

    fun getAccessToken(): String? {
        return authState?.accessToken
    }

    fun saveConfiguration(clientId: String, authority: String) {
        secureStorage.setValue(SecureStorage.KEY_CLIENT_ID, clientId)
        secureStorage.setValue(SecureStorage.KEY_AUTHORITY, authority)
    }

    suspend fun getServiceConfig(): AuthorizationServiceConfiguration {
        return suspendCancellableCoroutine { continuation ->
            val authority = secureStorage.getValue(SecureStorage.KEY_AUTHORITY)
                ?: throw IllegalStateException("Authority not configured")

            AuthorizationServiceConfiguration.fetchFromIssuer(
                authority.toUri()
            ) { config, ex ->
                when {
                    config != null -> continuation.resume(config)
                    ex != null -> continuation.resumeWithException(ex)
                    else -> continuation.resumeWithException(
                        IllegalStateException("Unknown error fetching service config")
                    )
                }
            }
        }
    }

    suspend fun createAuthIntent(): Intent {
        val serviceConfig = getServiceConfig()
        val authRequest = createAuthRequest(serviceConfig)
        return getAuthService().getAuthorizationRequestIntent(authRequest)
    }

    private fun createAuthRequest(
        serviceConfig: AuthorizationServiceConfiguration
    ): AuthorizationRequest {
        val clientId = secureStorage.getValue(SecureStorage.KEY_CLIENT_ID)
            ?: throw IllegalStateException("Client ID not configured")

        return AuthorizationRequest.Builder(
            serviceConfig,
            clientId,
            ResponseTypeValues.CODE,
            REDIRECT_URI.toUri()
        )
            .setScope(SCOPE)
            .build()
    }

    suspend fun handleAuthorizationResponse(intent: Intent): TokenResponse {
        val authResponse = AuthorizationResponse.fromIntent(intent)
        val authException = AuthorizationException.fromIntent(intent)

        if (authException != null) throw authException
        if (authResponse == null) throw IllegalStateException("No authorization response")

        authState = AuthState(authResponse, null)

        return performTokenRequest(authResponse)
    }

    private suspend fun performTokenRequest(
        authResponse: AuthorizationResponse
    ): TokenResponse {
        return suspendCancellableCoroutine { continuation ->
            val service = getAuthService()
            val tokenRequest = authResponse.createTokenExchangeRequest()

            service.performTokenRequest(tokenRequest) { response, ex ->
                when {
                    response != null -> {
                        authState?.update(response, ex)
                        persistAuthState()
                        continuation.resume(response)
                    }
                    ex != null -> continuation.resumeWithException(ex)
                    else -> continuation.resumeWithException(
                        IllegalStateException("Unknown error performing token request")
                    )
                }
            }
        }
    }

    suspend fun refreshTokenIfNeeded(): String? {
        val currentAuthState = authState ?: return null

        if (!currentAuthState.needsTokenRefresh) {
            return currentAuthState.accessToken
        }

        return suspendCancellableCoroutine { continuation ->
            val service = getAuthService()

            currentAuthState.performActionWithFreshTokens(service) { accessToken, _, ex ->
                when {
                    accessToken != null -> {
                        persistAuthState()
                        continuation.resume(accessToken)
                    }
                    ex != null -> continuation.resumeWithException(ex)
                    else -> continuation.resumeWithException(
                        IllegalStateException("Unknown error refreshing token")
                    )
                }
            }
        }
    }

    fun logout() {
        authState = null
        secureStorage.removeKey(KEY_AUTH_STATE)
    }

    fun reset() {
        authState = null
        secureStorage.clear()
    }

    private fun persistAuthState() {
        authState?.let {
            secureStorage.setValue(KEY_AUTH_STATE, it.jsonSerializeString())
        }
    }

    private fun restoreAuthState() {
        val json = secureStorage.getValue(KEY_AUTH_STATE)
        if (!json.isNullOrEmpty()) {
            try {
                authState = AuthState.jsonDeserialize(json)
            } catch (_: Exception) {
                secureStorage.removeKey(KEY_AUTH_STATE)
            }
        }
    }

    private fun getAuthService(): AuthorizationService {
        if (authService == null) {
            authService = AuthorizationService(context)
        }
        return authService!!
    }

    fun dispose() {
        authService?.dispose()
        authService = null
    }
}

package art.ameliah.ehb.keyveil.core.auth

import android.content.Context
import android.content.Intent
import androidx.core.net.toUri
import art.ameliah.ehb.keyveil.core.http.KeycloakApiClient
import net.openid.appauth.*
import kotlinx.coroutines.suspendCancellableCoroutine
import org.json.JSONObject
import kotlin.collections.getValue
import kotlin.coroutines.resume
import kotlin.coroutines.resumeWithException

class KeycloakAuthManager(internal val context: Context) {

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

    fun getClient(): KeycloakApiClient {
        val authority = secureStorage.getValue(SecureStorage.KEY_AUTHORITY)
            ?: throw IllegalStateException("Authority must be set")


        val baseUrl = authority.replace("/realms/", "/admin/realms/")

        return KeycloakApiClient(
            baseUrl = baseUrl,
            getAccessToken = { refreshTokenIfNeeded() }
        )
    }

    fun isConfigured(): Boolean {
        val clientId = secureStorage.getValue(SecureStorage.KEY_CLIENT_ID)
        val authority = secureStorage.getValue(SecureStorage.KEY_AUTHORITY)

        return !clientId.isNullOrEmpty() && !authority.isNullOrEmpty()
    }

    fun isAuthenticated(): Boolean {
        return authState?.isAuthorized == true && !isTokenExpired()
    }

    fun getAccessToken(): String? {
        return authState?.accessToken
    }

    fun getIdToken(): String? {
        return authState?.idToken
    }

    fun saveConfiguration(clientId: String, authority: String) {
        secureStorage.setValue(SecureStorage.KEY_CLIENT_ID, clientId)
        secureStorage.setValue(SecureStorage.KEY_AUTHORITY, authority)
    }

    /**
     * Get all claims from the ID token
     */
    fun getClaims(): Map<String, Any>? {
        val idToken = authState?.idToken ?: return null

        return try {
            parseJwtClaims(idToken)
        } catch (e: Exception) {
            null
        }
    }

    /**
     * Get a specific claim from the ID token
     */
    fun getClaim(key: String): Any? {
        return getClaims()?.get(key)
    }

    /**
     * Get username from preferred_username or sub claim
     */
    fun getUsername(): String? {
        val claims = getClaims() ?: return null
        return (claims["preferred_username"] as? String)
            ?: (claims["sub"] as? String)
    }

    /**
     * Get email from email claim
     */
    fun getEmail(): String? {
        return getClaim("email") as? String
    }

    /**
     * Get full name from name claim
     */
    fun getName(): String? {
        return getClaim("name") as? String
    }

    /**
     * Get given name (first name)
     */
    fun getGivenName(): String? {
        return getClaim("given_name") as? String
    }

    /**
     * Get family name (last name)
     */
    fun getFamilyName(): String? {
        return getClaim("family_name") as? String
    }

    /**
     * Get roles from realm_access or resource_access claims
     */
    fun getRoles(clientId: String? = null): List<String> {
        val claims = getClaims() ?: return emptyList()

        val resourceAccess = claims["resource_access"] as? Map<*, *>
        val clientAccess = resourceAccess?.get(clientId) as? Map<*, *>
        val clientRoles = (clientAccess?.get("roles") as? List<*>)?.mapNotNull { it as? String } ?: emptyList()
        val realmAccess = claims["realm_access"] as? Map<*, *>
        val realmRoles = (realmAccess?.get("roles") as? List<*>)?.mapNotNull { it as? String } ?: emptyList()

        return clientRoles.union(realmRoles).toList();
    }

    /**
     * Check if user has a specific role
     */
    fun hasRole(role: String, clientId: String? = null): Boolean {
        return getRoles(clientId).contains(role)
    }

    /**
     * Get groups from groups claim
     */
    fun getGroups(): List<String> {
        val groups = getClaim("groups")
        return when (groups) {
            is List<*> -> groups.mapNotNull { it as? String }
            else -> emptyList()
        }
    }

    /**
     * Check if token is expired
     */
    fun isTokenExpired(): Boolean {
        val claims = getClaims() ?: return true
        val exp = (claims["exp"] as? Number)?.toLong() ?: return true
        val currentTime = System.currentTimeMillis() / 1000
        return currentTime >= exp
    }

    /**
     * Get token expiration time in milliseconds
     */
    fun getTokenExpiration(): Long? {
        val claims = getClaims() ?: return null
        val exp = (claims["exp"] as? Number)?.toLong() ?: return null
        return exp * 1000 // Convert to milliseconds
    }

    /**
     * Get user info as a data class
     */
    fun getUserInfo(): UserInfo? {
        val claims = getClaims() ?: return null

        return try {
            UserInfo(
                sub = claims["sub"] as? String ?: return null,
                username = getUsername(),
                email = getEmail(),
                emailVerified = (claims["email_verified"] as? Boolean) ?: false,
                name = getName(),
                givenName = getGivenName(),
                familyName = getFamilyName(),
                picture = claims["picture"] as? String ?: return null,
                roles = getRoles(),
                groups = getGroups(),
            )
        } catch (e: Exception) {
            null
        }
    }

    private fun parseJwtClaims(jwt: String): Map<String, Any> {
        // JWT structure: header.payload.signature
        val parts = jwt.split(".")
        if (parts.size != 3) {
            throw IllegalArgumentException("Invalid JWT token")
        }

        // Decode the payload (second part)
        val payload = parts[1]
        val decodedBytes = android.util.Base64.decode(
            payload,
            android.util.Base64.URL_SAFE or android.util.Base64.NO_PADDING or android.util.Base64.NO_WRAP
        )
        val jsonString = String(decodedBytes)

        // Parse JSON to Map
        return jsonToMap(JSONObject(jsonString))
    }

    private fun jsonToMap(json: JSONObject): Map<String, Any> {
        val map = mutableMapOf<String, Any>()
        val keys = json.keys()

        while (keys.hasNext()) {
            val key = keys.next()
            val value = json.get(key)

            map[key] = when (value) {
                is JSONObject -> jsonToMap(value)
                is org.json.JSONArray -> {
                    (0 until value.length()).map { i ->
                        val item = value.get(i)
                        if (item is JSONObject) jsonToMap(item) else item
                    }
                }
                else -> value
            }
        }

        return map
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

/**
 * Data class to hold user information from claims
 */
data class UserInfo(
    val sub: String,
    val username: String?,
    val email: String?,
    val emailVerified: Boolean,
    val name: String?,
    val givenName: String?,
    val familyName: String?,
    val picture: String?,
    val roles: List<String>,
    val groups: List<String>
)
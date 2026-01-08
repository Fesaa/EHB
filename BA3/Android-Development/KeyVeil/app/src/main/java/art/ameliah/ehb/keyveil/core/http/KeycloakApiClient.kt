package art.ameliah.ehb.keyveil.core.http

import art.ameliah.ehb.keyveil.core.http.models.KeycloakClient
import art.ameliah.ehb.keyveil.core.http.models.KeycloakRole
import art.ameliah.ehb.keyveil.core.http.models.KeycloakUser
import kotlinx.serialization.json.Json
import okhttp3.HttpUrl
import okhttp3.OkHttpClient
import okhttp3.Request
import java.io.IOException
import java.net.URL
import kotlin.contracts.ExperimentalContracts
import kotlin.contracts.contract

class KeycloakApiClient {

    private val httpClient = OkHttpClient();
    private val json = Json {
        ignoreUnknownKeys = true
        isLenient = true
    }

    private val url: URL
    private val getAccessToken: suspend () -> String?

    constructor(baseUrl: String, getAccessToken: suspend () -> String?) {
        this.url = URL(baseUrl);
        this.getAccessToken = getAccessToken
    }

    suspend fun searchRoles(query: String?, offSet: Int = 0, brief: Boolean = false): List<KeycloakRole> {
        var url = prepareHttpUrl()
            .addPathSegment("roles")
            .addQueryParameter("briefRepresentation", brief.toString())

        if (query != null)
            url = url.addQueryParameter("search", query)

        return get<List<KeycloakRole>>(url.build())!!
    }

    suspend fun searchClient(query: String?, offSet: Int = 0): List<KeycloakClient> {
        var url = prepareHttpUrl()
            .addPathSegment("clients")

        if (query != null)
            url = url.addQueryParameter("search", query)

        return get<List<KeycloakClient>>(url.build())!!
    }

    suspend fun getRoleMappings(userId: String) {

    }

    suspend fun getUser(userId: String): KeycloakUser? {
        val url = prepareHttpUrl()
            .addPathSegment("users")
            .addPathSegment(userId)

        return get<KeycloakUser>(url.build(), true)
    }

    suspend fun searchUsers(query: String? = null, offSet: Int = 0): List<KeycloakUser> {
        var url = prepareHttpUrl()
            .addPathSegment("users")

        if (query != null)
            url = url.addQueryParameter("search", query)

        return get<List<KeycloakUser>>(url.build())!!
    }

    private suspend inline fun <reified T> get(url: HttpUrl, allow404: Boolean = false): T? {
        val request = prepareRequest()
            .url(url)
            .build()

        val response = httpClient.newCall(request).execute()

        if (allow404 && response.code == 404) {
            return null;
        }

        if (!response.isSuccessful) {
            throw IOException("Request failed: ${response.code} ${response.message}")
        }

        val body = response.body.string()

        return json.decodeFromString<T>(body)
    }

    private fun prepareHttpUrl(): HttpUrl.Builder {
        return HttpUrl.Builder()
            .scheme("https")
            .host(url.host)
            .addPathSegments(url.path.removePrefix("/"))
    }

    private suspend fun prepareRequest(): Request.Builder {
        val token = getAccessToken()
            ?: throw IllegalStateException("No access token available")

        return Request.Builder()
            .addHeader("Authorization", "Bearer $token")
            .addHeader("Accept", "application/json")
    }

}
package art.ameliah.ehb.keyveil.core.http

import art.ameliah.ehb.keyveil.core.http.models.KeycloakClient
import art.ameliah.ehb.keyveil.core.http.models.KeycloakRole
import art.ameliah.ehb.keyveil.core.http.models.KeycloakUser
import kotlinx.serialization.json.Json
import okhttp3.HttpUrl
import okhttp3.OkHttpClient
import okhttp3.Request
import okhttp3.RequestBody.Companion.toRequestBody
import java.io.IOException
import java.net.URL

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

    suspend fun searchClientRoles(clientId: String, offSet: Int = 0, brief: Boolean = false): List<KeycloakRole> {
        val url = prepareHttpUrl()
            .addPathSegment("clients")
            .addPathSegment(clientId)
            .addPathSegment("roles")
            .addQueryParameter("briefRepresentation", brief.toString())

        return get<List<KeycloakRole>>(url.build())!!
    }

    suspend fun searchClients(query: String?, offSet: Int = 0): List<KeycloakClient> {
        var url = prepareHttpUrl()
            .addPathSegment("clients")

        if (query != null)
            url = url.addQueryParameter("search", query)

        return get<List<KeycloakClient>>(url.build())!!
    }

    /**
     * clientId = null => get for realm
     */
    suspend fun getUserRoles(userId: String, clientId: String?): List<KeycloakRole> {
        var url = prepareHttpUrl()
            .addPathSegment("users")
            .addPathSegment(userId)
            .addPathSegment("role-mappings")

        url = if (clientId == null)
            url.addPathSegment("realm")
        else
            url.addPathSegment("clients")
                .addPathSegment(clientId)

        return get<List<KeycloakRole>>(url.build())!!
    }

    suspend fun getUser(userId: String): KeycloakUser? {
        val url = prepareHttpUrl()
            .addPathSegment("users")
            .addPathSegment(userId)

        return get<KeycloakUser>(url.build(), true)
    }

    suspend fun saveUser(user: KeycloakUser) {
        val url = prepareHttpUrl()
            .addPathSegment("users")
            .addPathSegment(user.id)

        put(url.build(), user)
    }

    suspend fun addUserClientRoles(userId: String, clientId: String, roles: List<KeycloakRole>) {
        val url = prepareHttpUrl()
            .addPathSegment("users")
            .addPathSegment(userId)
            .addPathSegment("role-mappings")
            .addPathSegment("clients")
            .addPathSegment(clientId);

        post(url.build(), roles)
    }

    suspend fun deleteUserClientRoles(userId: String, clientId: String, roles: List<KeycloakRole>) {
        val url = prepareHttpUrl()
            .addPathSegment("users")
            .addPathSegment(userId)
            .addPathSegment("role-mappings")
            .addPathSegment("clients")
            .addPathSegment(clientId);

        delete(url.build(), roles)
    }

    suspend fun searchUsers(query: String? = null, offSet: Int = 0): List<KeycloakUser> {
        var url = prepareHttpUrl()
            .addPathSegment("users")

        if (query != null)
            url = url.addQueryParameter("search", query)

        return get<List<KeycloakUser>>(url.build())!!
    }

    private suspend inline fun <reified T> delete(url: HttpUrl, body: T) {
        val requestBody = json.encodeToString(body).toRequestBody()

        val request = prepareRequest()
            .url(url)
            .delete(requestBody)
            .build()

        val response = httpClient.newCall(request).execute()

        if (!response.isSuccessful) {
            throw IOException("Request failed: ${response.code} ${response.message}")
        }
    }

    private suspend inline fun <reified T> post(url: HttpUrl, body: T) {
        val requestBody = json.encodeToString(body).toRequestBody()

        val request = prepareRequest()
            .url(url)
            .post(requestBody)
            .build()

        val response = httpClient.newCall(request).execute()

        if (!response.isSuccessful) {
            throw IOException("Request failed: ${response.code} ${response.message}")
        }
    }

    private suspend inline fun <reified T> put(url: HttpUrl, body: T) {
        val requestBody = json.encodeToString(body).toRequestBody()

        val request = prepareRequest()
            .url(url)
            .put(requestBody)
            .build()

        val response = httpClient.newCall(request).execute()

        if (!response.isSuccessful) {
            throw IOException("Request failed: ${response.code} ${response.message} ${response.body.string()}")
        }
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
package art.ameliah.ehb.keyveil.core.http

import art.ameliah.ehb.keyveil.core.http.models.KeycloakClient
import art.ameliah.ehb.keyveil.core.http.models.KeycloakUser
import kotlinx.serialization.json.Json
import okhttp3.HttpUrl
import okhttp3.OkHttpClient
import okhttp3.Request
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

    suspend fun searchClient(query: String?, offSet: Int = 0): List<KeycloakClient> {
        var url = prepareHttpUrl()
            .addPathSegment("clients")

        if (query != null)
            url = url.addQueryParameter("search", query)

        return get<List<KeycloakClient>>(url.build(), offSet)
    }

    suspend fun searchUsers(query: String? = null, offSet: Int = 0): List<KeycloakUser> {
        var url = prepareHttpUrl()
            .addPathSegment("users")

        if (query != null)
            url = url.addQueryParameter("search", query)

        return get<List<KeycloakUser>>(url.build(), offSet)
    }

    private suspend inline fun <reified T> get(url: HttpUrl, offSet: Int): T {
        val request = prepareRequest()
            .url(url)
            .build()

        val response = httpClient.newCall(request).execute()

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
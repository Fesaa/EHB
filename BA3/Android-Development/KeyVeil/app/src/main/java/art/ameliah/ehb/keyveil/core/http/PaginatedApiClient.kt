package art.ameliah.ehb.keyveil.core.api

import kotlinx.coroutines.flow.Flow
import kotlinx.coroutines.flow.flow
import kotlinx.serialization.json.Json
import okhttp3.OkHttpClient
import okhttp3.Request
import java.io.IOException

data class PagedList<T>(
    val items: List<T>,
    val currentPage: Int,
    val pageSize: Int,
    val hasMore: Boolean
)

abstract class PaginatedApiClient(
    private val baseUrl: String,
    private val getAccessToken: suspend () -> String?
) {
    private val client = OkHttpClient()
    protected val json = Json {
        ignoreUnknownKeys = true
        isLenient = true
    }

    /**
     * Fetch a single page of results
     */
    protected suspend fun <T> fetchPage(
        endpoint: String,
        first: Int,
        max: Int,
        additionalParams: Map<String, String> = emptyMap(),
        deserializer: (String) -> List<T>
    ): PagedList<T> {
        val token = getAccessToken()
            ?: throw IllegalStateException("No access token available")

        val params = buildString {
            append("first=$first&max=$max")
            additionalParams.forEach { (key, value) ->
                append("&$key=$value")
            }
        }

        val url = "$baseUrl/$endpoint?$params"

        val request = Request.Builder()
            .url(url)
            .addHeader("Authorization", "Bearer $token")
            .addHeader("Accept", "application/json")
            .build()

        val response = client.newCall(request).execute()

        if (!response.isSuccessful) {
            throw IOException("Request failed: ${response.code} ${response.message}")
        }

        val body = response.body?.string()
            ?: throw IOException("Empty response body")

        val items = deserializer(body)

        return PagedList(
            items = items,
            currentPage = first / max,
            pageSize = max,
            hasMore = items.size == max
        )
    }
}
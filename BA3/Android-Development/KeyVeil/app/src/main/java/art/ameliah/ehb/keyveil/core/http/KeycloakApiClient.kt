package art.ameliah.ehb.keyveil.core.http

import art.ameliah.ehb.keyveil.core.api.PagedList
import art.ameliah.ehb.keyveil.core.api.PaginatedApiClient
import kotlinx.serialization.Serializable

@Serializable
data class KeycloakUser(
    val id: String,
    val username: String,
    val email: String? = null,
    val firstName: String? = null,
    val lastName: String? = null,
    val enabled: Boolean = true,
    val emailVerified: Boolean = false,
    val createdTimestamp: Long? = null,
    val attributes: Map<String, List<String>>? = null,
)

class KeycloakApiClient(
    baseUrl: String,
    getAccessToken: suspend () -> String?
) : PaginatedApiClient(baseUrl, getAccessToken) {

    /**
     * Fetch a single page of users
     */
    suspend fun getUsersPage(
        first: Int = 0,
        max: Int = 11,
        briefRepresentation: Boolean = true
    ): PagedList<KeycloakUser> {
        val params = if (briefRepresentation) {
            mapOf("briefRepresentation" to "true")
        } else {
            emptyMap()
        }

        return fetchPage(
            endpoint = "ui-ext/brute-force-user",
            first = first,
            max = max,
            additionalParams = params
        ) { body ->
            json.decodeFromString<List<KeycloakUser>>(body)
        }
    }

    /**
     * Search users by username, email, firstName, or lastName
     */
    suspend fun searchUsers(
        search: String,
        first: Int = 0,
        max: Int = 20,
        briefRepresentation: Boolean = true
    ): PagedList<KeycloakUser> {
        val params = mutableMapOf(
            "q" to search
        )

        if (briefRepresentation) {
            params["briefRepresentation"] = "true"
        }

        return fetchPage(
            endpoint = "ui-ext/brute-force-user",
            first = first,
            max = max,
            additionalParams = params
        ) { body ->
            json.decodeFromString<List<KeycloakUser>>(body)
        }
    }
}
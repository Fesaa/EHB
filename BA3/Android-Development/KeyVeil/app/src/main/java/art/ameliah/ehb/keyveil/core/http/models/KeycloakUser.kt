package art.ameliah.ehb.keyveil.core.http.models

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

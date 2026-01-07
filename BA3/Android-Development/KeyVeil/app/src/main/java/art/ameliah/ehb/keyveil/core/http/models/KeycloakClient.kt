package art.ameliah.ehb.keyveil.core.http.models

import kotlinx.serialization.Serializable

@Serializable
data class KeycloakClient(
    val id: String?,
    val clientId: String?,
    val name: String?,
    val description: String? = null,
    val type: String? = null,
    val enabled: Boolean? = null,
)

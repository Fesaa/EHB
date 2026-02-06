package art.ameliah.ehb.keyveil.core.http.models

import kotlinx.serialization.Serializable

@Serializable
data class KeycloakRole(
    val id: String,
    val name: String? = null,
    val description: String? = null,
    val scopeParamRequired: Boolean? = null,
    val clientRole: Boolean? = null,
    val attributes: Map<String, List<String>>? = null,
)

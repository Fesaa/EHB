package art.ameliah.ehb.keyveil.ui.navigation

import androidx.compose.runtime.Composable
import androidx.compose.ui.graphics.vector.ImageVector
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager

/**
 * Represents a menu item in the KeyVeil navigation
 */
data class KeyVeilMenuItem(
    val id: String,
    val title: String,
    val icon: ImageVector,
    val content: @Composable (KeycloakAuthManager) -> Unit
)

/**
 * Registry for all available menu items
 */
object MenuRegistry {
    private val items = mutableListOf<KeyVeilMenuItem>()

    fun register(item: KeyVeilMenuItem) {
        items.add(item)
    }

    fun registerAll(vararg menuItems: KeyVeilMenuItem) {
        items.addAll(menuItems)
    }

    fun getAll(): List<KeyVeilMenuItem> = items.toList()

    fun getById(id: String): KeyVeilMenuItem? = items.find { it.id == id }

    fun clear() {
        items.clear()
    }
}

package art.ameliah.ehb.keyveil

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.compose.foundation.layout.*
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.Logout
import androidx.compose.material.icons.filled.Apps
import androidx.compose.material.icons.filled.Dashboard
import androidx.compose.material.icons.filled.Info
import androidx.compose.material.icons.filled.Menu
import androidx.compose.material.icons.filled.People
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager
import art.ameliah.ehb.keyveil.ui.LoginScreen
import art.ameliah.ehb.keyveil.ui.configuration.ConfigurationScreen
import art.ameliah.ehb.keyveil.ui.navigation.KeyVeilMenuItem
import art.ameliah.ehb.keyveil.ui.navigation.MenuRegistry
import art.ameliah.ehb.keyveil.ui.pages.ClientsPage
import art.ameliah.ehb.keyveil.ui.pages.DashboardPage
import art.ameliah.ehb.keyveil.ui.pages.UsersPage
import art.ameliah.ehb.keyveil.ui.theme.KeyVeilTheme
import kotlinx.coroutines.launch

class MainActivity : ComponentActivity() {

    private lateinit var authManager: KeycloakAuthManager

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        authManager = KeycloakAuthManager(this)

        // Register menu items
        setupMenuItems()

        enableEdgeToEdge()
        setContent {
            KeyVeilTheme {
                KeyVeilApp(authManager)
            }
        }
    }

    private fun setupMenuItems() {
        MenuRegistry.registerAll(
            KeyVeilMenuItem(
                id = "dashboard",
                title = "Dashboard",
                icon = Icons.Filled.Dashboard,
                content = { DashboardPage(authManager) }
            ),
            KeyVeilMenuItem(
                id = "users",
                title = "Users",
                icon = Icons.Filled.People,
                content = { UsersPage(authManager) }
            ),
            KeyVeilMenuItem(
                id = "clients",
                title = "Clients",
                icon = Icons.Filled.Apps,
                content = { ClientsPage(authManager) }
            ),
        )
    }

    override fun onDestroy() {
        super.onDestroy()
        authManager.dispose()
        MenuRegistry.clear()
    }
}

@Composable
fun KeyVeilApp(authManager: KeycloakAuthManager) {
    var isConfigured by remember { mutableStateOf(authManager.isConfigured()) }
    var isAuthenticated by remember { mutableStateOf(authManager.isAuthenticated()) }

    when {
        !isConfigured -> {
            ConfigurationScreen(
                authManager = authManager,
                onConfigurationSaved = {
                    isConfigured = true
                }
            )
        }
        !isAuthenticated -> {
            LoginScreen(
                authManager = authManager,
                onLoginSuccess = {
                    isAuthenticated = true
                },
                onReset = {
                    isAuthenticated = false
                    isConfigured = false
                }
            )
        }
        else -> {
            MainScreen(
                authManager = authManager,
                onLogout = {
                    authManager.logout()
                    isAuthenticated = false
                }
            )
        }
    }
}

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun MainScreen(
    authManager: KeycloakAuthManager,
    onLogout: () -> Unit
) {
    val menuItems = remember { MenuRegistry.getAll() }
    var selectedMenuItem by remember { mutableStateOf(menuItems.firstOrNull()) }
    val drawerState = rememberDrawerState(initialValue = DrawerValue.Closed)
    val scope = rememberCoroutineScope()

    ModalNavigationDrawer(
        drawerState = drawerState,
        drawerContent = {
            ModalDrawerSheet(
                modifier = Modifier.width(280.dp)
            ) {
                Column(
                    modifier = Modifier
                        .fillMaxSize()
                        .padding(vertical = 16.dp)
                ) {
                    Column(
                        modifier = Modifier.padding(horizontal = 16.dp, vertical = 24.dp)
                    ) {
                        Text(
                            text = "KeyVeil",
                            style = MaterialTheme.typography.headlineSmall,
                            color = MaterialTheme.colorScheme.primary
                        )
                        Text(
                            text = "Admin Console",
                            style = MaterialTheme.typography.bodySmall,
                            color = MaterialTheme.colorScheme.onSurfaceVariant
                        )
                    }

                    HorizontalDivider()

                    Spacer(modifier = Modifier.height(8.dp))

                    // Menu items
                    menuItems.forEach { item ->
                        NavigationDrawerItem(
                            icon = { Icon(item.icon, contentDescription = item.title) },
                            label = { Text(item.title) },
                            selected = selectedMenuItem?.id == item.id,
                            onClick = {
                                selectedMenuItem = item
                                scope.launch {
                                    drawerState.close()
                                }
                            },
                            modifier = Modifier.padding(horizontal = 12.dp)
                        )
                    }

                    Spacer(modifier = Modifier.weight(1f))

                    HorizontalDivider()

                    // Logout button
                    NavigationDrawerItem(
                        icon = { Icon(Icons.AutoMirrored.Filled.Logout, contentDescription = "Logout") },
                        label = { Text("Logout") },
                        selected = false,
                        onClick = {
                            scope.launch {
                                drawerState.close()
                            }
                            onLogout()
                        },
                        modifier = Modifier.padding(horizontal = 12.dp),
                        colors = NavigationDrawerItemDefaults.colors(
                            unselectedTextColor = MaterialTheme.colorScheme.error,
                            unselectedIconColor = MaterialTheme.colorScheme.error
                        )
                    )
                }
            }
        }
    ) {
        Scaffold(
            topBar = {
                TopAppBar(
                    title = { Text(selectedMenuItem?.title ?: "KeyVeil") },
                    navigationIcon = {
                        IconButton(onClick = {
                            scope.launch {
                                drawerState.open()
                            }
                        }) {
                            Icon(Icons.Filled.Menu, contentDescription = "Menu")
                        }
                    }
                )
            }
        ) { paddingValues ->
            Box(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(paddingValues)
            ) {
                selectedMenuItem?.content?.invoke(authManager)
                    ?: EmptyState()
            }
        }
    }
}

@Composable
fun EmptyState() {
    Box(
        modifier = Modifier.fillMaxSize(),
        contentAlignment = Alignment.Center
    ) {
        Column(
            horizontalAlignment = Alignment.CenterHorizontally,
            verticalArrangement = Arrangement.spacedBy(8.dp)
        ) {
            Icon(
                imageVector = Icons.Filled.Info,
                contentDescription = null,
                modifier = Modifier.size(48.dp),
                tint = MaterialTheme.colorScheme.onSurfaceVariant
            )
            Text(
                text = "No page selected",
                style = MaterialTheme.typography.bodyLarge,
                color = MaterialTheme.colorScheme.onSurfaceVariant
            )
        }
    }
}
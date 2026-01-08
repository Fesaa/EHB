package art.ameliah.ehb.keyveil

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.compose.foundation.layout.*
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
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
import androidx.navigation.compose.currentBackStackEntryAsState
import androidx.navigation.compose.rememberNavController
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager
import art.ameliah.ehb.keyveil.ui.LoginScreen
import art.ameliah.ehb.keyveil.ui.configuration.ConfigurationScreen
import art.ameliah.ehb.keyveil.ui.navigation.KeyVeilNavGraph
import art.ameliah.ehb.keyveil.ui.navigation.Screen
import art.ameliah.ehb.keyveil.ui.theme.KeyVeilTheme
import kotlinx.coroutines.launch

class MainActivity : ComponentActivity() {

    private lateinit var authManager: KeycloakAuthManager

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        authManager = KeycloakAuthManager(this)

        enableEdgeToEdge()
        setContent {
            KeyVeilTheme {
                KeyVeilApp(authManager)
            }
        }
    }

    override fun onDestroy() {
        super.onDestroy()
        authManager.dispose()
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

// Navigation drawer items
data class DrawerItem(
    val route: String,
    val title: String,
    val icon: androidx.compose.ui.graphics.vector.ImageVector
)

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun MainScreen(
    authManager: KeycloakAuthManager,
    onLogout: () -> Unit
) {
    val navController = rememberNavController()
    val drawerState = rememberDrawerState(initialValue = DrawerValue.Closed)
    val scope = rememberCoroutineScope()

    val currentBackStackEntry by navController.currentBackStackEntryAsState()
    val currentRoute = currentBackStackEntry?.destination?.route

    // Define drawer menu items
    val drawerItems = remember {
        listOf(
            DrawerItem(Screen.Dashboard.route, "Dashboard", Icons.Filled.Dashboard),
            DrawerItem(Screen.Users.route, "Users", Icons.Filled.People),
            DrawerItem(Screen.Clients.route, "Clients", Icons.Filled.Apps)
        )
    }

    // Get the title for the top bar
    val topBarTitle = drawerItems.find { currentRoute?.startsWith(it.route) == true }?.title
        ?: when {
            currentRoute?.startsWith("edit_user") == true -> "Edit User"
            else -> "KeyVeil"
        }

    // Check if we should show back button (for detail pages)
    val showBackButton = currentRoute?.startsWith("edit_user") == true

    ModalNavigationDrawer(
        drawerState = drawerState,
        // Only enable drawer on main screens, not detail pages
        gesturesEnabled = !showBackButton,
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
                    drawerItems.forEach { item ->
                        NavigationDrawerItem(
                            icon = { Icon(item.icon, contentDescription = item.title) },
                            label = { Text(item.title) },
                            selected = currentRoute?.startsWith(item.route) == true,
                            onClick = {
                                navController.navigate(item.route) {
                                    // Pop up to start destination to avoid building large back stack
                                    popUpTo(Screen.Dashboard.route) {
                                        saveState = true
                                    }
                                    // Avoid multiple copies of same destination
                                    launchSingleTop = true
                                    // Restore state when reselecting a previously selected item
                                    restoreState = true
                                }
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
                    title = { Text(topBarTitle) },
                    navigationIcon = {
                        IconButton(onClick = {
                            if (showBackButton) {
                                navController.popBackStack()
                            } else {
                                scope.launch {
                                    drawerState.open()
                                }
                            }
                        }) {
                            Icon(
                                imageVector = if (showBackButton)
                                    Icons.AutoMirrored.Filled.ArrowBack
                                else
                                    Icons.Filled.Menu,
                                contentDescription = if (showBackButton) "Back" else "Menu"
                            )
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
                KeyVeilNavGraph(
                    navController = navController,
                    authManager = authManager
                )
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
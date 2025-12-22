package art.ameliah.ehb.keyveil

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.layout.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager
import art.ameliah.ehb.keyveil.ui.LoginScreen
import art.ameliah.ehb.keyveil.ui.configuration.ConfigurationScreen
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

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun MainScreen(
    authManager: KeycloakAuthManager,
    onLogout: () -> Unit
) {
    val accessToken = authManager.getAccessToken()

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("KeyVeil") }
            )
        }
    ) { paddingValues ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(paddingValues)
                .padding(24.dp),
            horizontalAlignment = Alignment.CenterHorizontally,
            verticalArrangement = Arrangement.spacedBy(16.dp)
        ) {
            Card(
                modifier = Modifier.fillMaxWidth()
            ) {
                Column(
                    modifier = Modifier.padding(16.dp)
                ) {
                    Text(
                        text = "✓ Authenticated",
                        style = MaterialTheme.typography.headlineSmall,
                        color = MaterialTheme.colorScheme.primary,
                        modifier = Modifier.padding(bottom = 8.dp)
                    )

                    Text(
                        text = "You are successfully logged in to Keycloak",
                        style = MaterialTheme.typography.bodyMedium,
                        color = MaterialTheme.colorScheme.onSurfaceVariant
                    )

                    if (accessToken != null) {
                        Spacer(modifier = Modifier.height(16.dp))
                        Text(
                            text = "Access Token:",
                            style = MaterialTheme.typography.labelMedium,
                            modifier = Modifier.padding(bottom = 4.dp)
                        )
                        Text(
                            text = "${accessToken.take(50)}...",
                            style = MaterialTheme.typography.bodySmall,
                            fontFamily = androidx.compose.ui.text.font.FontFamily.Monospace,
                            color = MaterialTheme.colorScheme.onSurfaceVariant
                        )
                    }
                }
            }

            Spacer(modifier = Modifier.weight(1f))

            Button(
                onClick = onLogout,
                modifier = Modifier.fillMaxWidth(),
                colors = ButtonDefaults.buttonColors(
                    containerColor = MaterialTheme.colorScheme.error
                )
            ) {
                Text("Logout")
            }
        }
    }
}
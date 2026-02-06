package art.ameliah.ehb.keyveil.ui.configuration

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager

@Composable
@OptIn(ExperimentalMaterial3Api::class)
fun ConfigurationScreen(
    authManager: KeycloakAuthManager,
    onConfigurationSaved: () -> Unit
) {
    var authority by remember { mutableStateOf("https://") }
    var clientId by remember { mutableStateOf("") }

    var authorityError by remember { mutableStateOf<String?>(null) }
    var clientIdError by remember { mutableStateOf<String?>(null) }
    var clientSecretError by remember { mutableStateOf<String?>(null) }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Keycloak Configuration") }
            )
        }
    ) { paddingValues ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(paddingValues)
                .verticalScroll(rememberScrollState())
                .padding(24.dp),
            verticalArrangement = Arrangement.spacedBy(16.dp)
        ) {
            KeycloakInfoNotice()

            Spacer(modifier = Modifier.height(8.dp))

            OutlinedTextField(
                value = authority,
                onValueChange = {
                    authority = it
                    authorityError = null
                },
                label = { Text("Authority URL") },
                placeholder = { Text("https://keycloak.example.com/realms/myrealm") },
                isError = authorityError != null,
                supportingText = authorityError?.let { { Text(it) } },
                singleLine = true,
                keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Uri),
                modifier = Modifier.fillMaxWidth()
            )

            Text(
                text = "Example: https://keycloak.example.com/realms/myrealm",
                style = MaterialTheme.typography.bodySmall,
                color = MaterialTheme.colorScheme.onSurfaceVariant
            )

            Spacer(modifier = Modifier.height(4.dp))

            OutlinedTextField(
                value = clientId,
                onValueChange = {
                    clientId = it
                    clientIdError = null
                },
                label = { Text("Client ID") },
                isError = clientIdError != null,
                supportingText = clientIdError?.let { { Text(it) } },
                singleLine = true,
                modifier = Modifier.fillMaxWidth()
            )

            Spacer(modifier = Modifier.height(8.dp))

            Button(
                onClick = {
                    var hasError = false

                    if (authority.isBlank()) {
                        authorityError = "Authority URL is required"
                        hasError = true
                    } else if (!authority.startsWith("https://") && !authority.startsWith("http://")) {
                        authorityError = "Authority must be a valid URL (https://...)"
                        hasError = true
                    }

                    if (clientId.isBlank()) {
                        clientIdError = "Client ID is required"
                        hasError = true
                    }

                    if (!hasError) {
                        authManager.saveConfiguration(clientId, authority);
                        onConfigurationSaved()
                    }
                },
                modifier = Modifier.fillMaxWidth()
            ) {
                Text("Save Configuration")
            }
        }
    }
}
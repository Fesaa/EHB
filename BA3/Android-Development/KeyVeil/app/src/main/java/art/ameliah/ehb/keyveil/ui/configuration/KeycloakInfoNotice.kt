package art.ameliah.ehb.keyveil.ui.configuration

import android.widget.Toast
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.material3.AssistChip
import androidx.compose.material3.CardDefaults
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedCard
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.LocalClipboardManager
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.text.AnnotatedString
import androidx.compose.ui.text.font.FontFamily
import androidx.compose.ui.unit.dp

@Composable
fun KeycloakInfoNotice() {
    val redirectUri = "art.ameliah.ehb.keyveil://oauth2redirect"
    val clipboardManager = LocalClipboardManager.current
    val context = LocalContext.current

    OutlinedCard(
        colors = CardDefaults.outlinedCardColors(
            containerColor = MaterialTheme.colorScheme.surface
        ),
        modifier = Modifier.fillMaxWidth()
    ) {
        Column(
            modifier = Modifier.padding(16.dp),
            verticalArrangement = Arrangement.spacedBy(12.dp)
        ) {

            Text(
                text = "Your Keycloak client must be configured as a public client and allow the redirect URI below.",
                style = MaterialTheme.typography.bodySmall,
                color = MaterialTheme.colorScheme.onSurfaceVariant
            )

            Text(
                text = "Redirect URI",
                style = MaterialTheme.typography.labelMedium
            )

            AssistChip(
                onClick = {
                    clipboardManager.setText(AnnotatedString(redirectUri))
                    Toast
                        .makeText(context, "Redirect URI copied", Toast.LENGTH_SHORT)
                        .show()
                },
                label = {
                    Text(
                        text = redirectUri,
                        fontFamily = FontFamily.Monospace
                    )
                },
            )
        }
    }
}

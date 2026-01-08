// NavGraph.kt
package art.ameliah.ehb.keyveil.ui.navigation

import androidx.compose.runtime.Composable
import androidx.navigation.NavHostController
import androidx.navigation.NavType
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.navArgument
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager
import art.ameliah.ehb.keyveil.ui.pages.ClientsPage
import art.ameliah.ehb.keyveil.ui.pages.DashboardPage
import art.ameliah.ehb.keyveil.ui.pages.EditUserPage
import art.ameliah.ehb.keyveil.ui.pages.UsersPage

// Define routes as sealed class for type safety
sealed class Screen(val route: String) {
    data object Dashboard : Screen("dashboard")
    data object Users : Screen("users")
    data object Clients : Screen("clients")
    data object EditUser : Screen("edit_user/{userId}") {
        fun createRoute(userId: String) = "edit_user/$userId"
    }
}

@Composable
fun KeyVeilNavGraph(
    navController: NavHostController,
    authManager: KeycloakAuthManager
) {
    NavHost(
        navController = navController,
        startDestination = Screen.Dashboard.route
    ) {
        composable(Screen.Dashboard.route) {
            DashboardPage(authManager)
        }

        composable(Screen.Users.route) {
            UsersPage(
                authManager = authManager,
                navController = navController,
            )
        }

        composable(Screen.Clients.route) {
            ClientsPage(authManager)
        }

        composable(
            route = Screen.EditUser.route,
            arguments = listOf(
                navArgument("userId") { type = NavType.StringType }
            )
        ) { backStackEntry ->
            val userId = backStackEntry.arguments?.getString("userId") ?: return@composable
            EditUserPage(
                userId = userId,
                authManager = authManager,
                onNavigateBack = { navController.popBackStack() }
            )
        }
    }
}
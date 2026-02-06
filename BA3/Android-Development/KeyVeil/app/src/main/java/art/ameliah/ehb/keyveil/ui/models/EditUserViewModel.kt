package art.ameliah.ehb.keyveil.ui.pages

import android.content.Context
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager
import art.ameliah.ehb.keyveil.core.http.models.KeycloakUser
import art.ameliah.ehb.keyveil.core.http.models.KeycloakRole
import art.ameliah.ehb.keyveil.core.http.models.KeycloakClient
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

sealed class EditUserUiState {
    data object Loading : EditUserUiState()
    data object Idle : EditUserUiState()
    data object Saving : EditUserUiState()
    data class Error(val message: String) : EditUserUiState()
    data object Success : EditUserUiState()
}

data class ClientWithRoles(
    val client: KeycloakClient,
    val roles: List<KeycloakRole>? = null, // null = not loaded yet
    val isExpanded: Boolean = false
)

sealed class RolesUiState {
    data object Loading : RolesUiState()
    data class Success(
        val realmRoles: List<KeycloakRole>,
        val clientsWithRoles: List<ClientWithRoles>
    ) : RolesUiState()
    data class Error(val message: String) : RolesUiState()
}

class EditUserViewModel(
    private val context: Context,
    private val authManager: KeycloakAuthManager,
    public val userId: String
) : ViewModel() {

    private var originalUser: KeycloakUser? = null

    private val _uiState = MutableStateFlow<EditUserUiState>(EditUserUiState.Loading)
    val uiState: StateFlow<EditUserUiState> = _uiState.asStateFlow()

    private val _rolesUiState = MutableStateFlow<RolesUiState>(RolesUiState.Loading)
    val rolesUiState: StateFlow<RolesUiState> = _rolesUiState.asStateFlow()

    private val _user = MutableStateFlow<KeycloakUser?>(null)
    val user: StateFlow<KeycloakUser?> = _user.asStateFlow()

    private val _roleSearchQuery = MutableStateFlow("")
    val roleSearchQuery: StateFlow<String> = _roleSearchQuery.asStateFlow()

    private val _selectedRoles = MutableStateFlow<Set<String>>(emptySet())
    val selectedRoles: StateFlow<Set<String>> = _selectedRoles.asStateFlow()

    private var allRealmRoles: List<KeycloakRole> = emptyList()
    private var allClientsWithRoles: List<ClientWithRoles> = emptyList()
    private var userCurrentRoles: Set<String> = emptySet()

    init {
        loadUser()
        loadRoles()
    }

    private fun loadUser() {
        viewModelScope.launch {
            try {
                _uiState.value = EditUserUiState.Loading

                val api = authManager.getClient()

                originalUser = withContext(Dispatchers.IO){
                    api.getUser(userId)
                }

                _user.value = originalUser

                _uiState.value = EditUserUiState.Idle
            } catch (e: Exception) {
                _uiState.value = EditUserUiState.Error(
                    e.message ?: "Failed to load user ${e.javaClass.simpleName}"
                )
            }
        }
    }

    fun updateUsername(value: String) {
        _user.value = _user.value?.copy(username = value)
    }

    fun updateFirstName(value: String) {
        _user.value = _user.value?.copy(firstName = value)
    }

    fun updateLastName(value: String) {
        _user.value = _user.value?.copy(lastName = value)
    }

    fun updateEmail(value: String) {
        _user.value = _user.value?.copy(email = value)
    }

    fun updateEnabled(value: Boolean) {
        _user.value = _user.value?.copy(enabled = value)
    }

    fun updateEmailVerified(value: Boolean) {
        _user.value = _user.value?.copy(emailVerified = value)
    }

    // Roles methods
    fun searchRoles(query: String) {
        _roleSearchQuery.value = query
        filterRoles()
    }

    fun clearRoleSearch() {
        _roleSearchQuery.value = ""
        filterRoles()
    }

    fun toggleRole(roleId: String) {
        _selectedRoles.value = if (_selectedRoles.value.contains(roleId)) {
            _selectedRoles.value - roleId
        } else {
            _selectedRoles.value + roleId
        }
    }

    fun toggleClientExpansion(clientId: String) {
        viewModelScope.launch {
            val currentState = _rolesUiState.value
            if (currentState !is RolesUiState.Success) return@launch

            val clientIndex = allClientsWithRoles.indexOfFirst { it.client.id == clientId }
            if (clientIndex == -1) return@launch

            val client = allClientsWithRoles[clientIndex]

            if (!client.isExpanded && client.roles == null) {
                try {
                    val api = authManager.getClient()

                    val clientRoles = withContext(Dispatchers.IO) {
                        api.searchClientRoles(clientId, brief = false)
                    }

                    val userClientRoles = withContext(Dispatchers.IO) {
                        api.getUserRoles(userId, clientId)
                    }

                    _selectedRoles.value += userClientRoles.map { it.id }.toSet()
                    userCurrentRoles = userCurrentRoles + userClientRoles.map { it.id }.toSet()

                    allClientsWithRoles = allClientsWithRoles.toMutableList().apply {
                        this[clientIndex] = client.copy(roles = clientRoles, isExpanded = true)
                    }
                } catch (e: Exception) {
                    return@launch
                }
            } else {
                allClientsWithRoles = allClientsWithRoles.toMutableList().apply {
                    this[clientIndex] = client.copy(isExpanded = !client.isExpanded)
                }
            }

            filterRoles()
        }
    }

    private fun loadRoles() {
        viewModelScope.launch {
            try {
                _rolesUiState.value = RolesUiState.Loading

                val api = authManager.getClient()

                // Load realm roles
                val realmRoles = withContext(Dispatchers.IO) {
                    api.searchRoles(null)
                }
                allRealmRoles = realmRoles

                val userRealmRoles = withContext(Dispatchers.IO) {
                    api.getUserRoles(userId, null)
                }

                val clients = withContext(Dispatchers.IO) {
                    api.searchClients(null)
                }

                if (clients.size < 10) {
                    val clientsWithRoles = clients.map { client ->
                        val clientRoles = withContext(Dispatchers.IO) {
                            api.searchClientRoles(client.id, brief = false)
                        }
                        val userClientRoles = withContext(Dispatchers.IO) {
                            api.getUserRoles(userId, client.id)
                        }

                        _selectedRoles.value += userClientRoles.map { it.id }.toSet()
                        userCurrentRoles = userCurrentRoles + userClientRoles.map { it.id }.toSet()

                        ClientWithRoles(
                            client = client,
                            roles = clientRoles,
                            isExpanded = true
                        )
                    }
                    allClientsWithRoles = clientsWithRoles
                } else {
                    allClientsWithRoles = clients.map { client ->
                        ClientWithRoles(
                            client = client,
                            roles = null,
                            isExpanded = false
                        )
                    }
                }

                // Add user's realm roles to selected set
                _selectedRoles.value = _selectedRoles.value + userRealmRoles.map { it.id }.toSet()
                userCurrentRoles = userCurrentRoles + userRealmRoles.map { it.id }.toSet()

                filterRoles()
            } catch (e: Exception) {
                _rolesUiState.value = RolesUiState.Error(
                    e.message ?: "Failed to load roles"
                )
            }
        }
    }

    private fun filterRoles() {
        val query = _roleSearchQuery.value.lowercase()

        // Filter realm roles
        val filteredRealmRoles = if (query.isEmpty()) {
            allRealmRoles
        } else {
            allRealmRoles.filter { role ->
                role.name?.lowercase()?.contains(query) == true ||
                        role.description?.lowercase()?.contains(query) == true
            }
        }

        // Filter client roles
        val filteredClientsWithRoles = if (query.isEmpty()) {
            allClientsWithRoles
        } else {
            allClientsWithRoles.mapNotNull { clientWithRoles ->
                val filteredRoles = clientWithRoles.roles?.filter { role ->
                    role.name?.lowercase()?.contains(query) == true ||
                            role.description?.lowercase()?.contains(query) == true
                }

                // Only include client if it has matching roles or if roles aren't loaded yet
                if (filteredRoles == null || filteredRoles.isNotEmpty()) {
                    clientWithRoles.copy(roles = filteredRoles)
                } else {
                    null
                }
            }
        }

        _rolesUiState.value = RolesUiState.Success(filteredRealmRoles, filteredClientsWithRoles)
    }

    fun saveChanges() {
        viewModelScope.launch {
            try {
                _uiState.value = EditUserUiState.Saving

                val api = authManager.getClient()
                val newUser = user.value;

                if (newUser != null) {
                    withContext(Dispatchers.IO) {
                        api.saveUser(newUser)
                    }

                    for (client in allClientsWithRoles) {
                        if (client.roles == null || client.roles.isEmpty())
                            continue

                        val originalClientRoles = userCurrentRoles
                            .intersect(client.roles.map { it.id }.toSet())

                        val currentClientRoles = _selectedRoles.value
                            .intersect(client.roles.map { it.id }.toSet())

                        val toAdd = currentClientRoles - originalClientRoles;
                        val toDelete = originalClientRoles - currentClientRoles;

                        if (toAdd.isNotEmpty()) {
                            val toSave = client.roles
                                .filter { role ->  toAdd.contains(role.id) }
                                .toList()

                            withContext(Dispatchers.IO) {
                                api.addUserClientRoles(
                                    newUser.id,
                                    client.client.id,
                                    toSave
                                )
                            }
                        }

                        if (toDelete.isNotEmpty()) {
                            val toSave = client.roles
                                .filter { role ->  toDelete.contains(role.id) }
                                .toList()

                            withContext(Dispatchers.IO) {
                                api.deleteUserClientRoles(
                                    newUser.id,
                                    client.client.id,
                                    toSave
                                )
                            }
                        }

                    }
                }

                _uiState.value = EditUserUiState.Success
            } catch (e: Exception) {
                _uiState.value = EditUserUiState.Error(
                    e.message ?: "Failed to save changes"
                )
            }
        }
    }

    fun clearError() {
        _uiState.value = EditUserUiState.Idle
    }
}
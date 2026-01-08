package art.ameliah.ehb.keyveil.ui.pages

import android.content.Context
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager
import art.ameliah.ehb.keyveil.core.http.models.KeycloakUser
import art.ameliah.ehb.keyveil.core.http.models.KeycloakRole
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

sealed class RolesUiState {
    data object Loading : RolesUiState()
    data class Success(val roles: List<KeycloakRole>) : RolesUiState()
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

    // Basic info fields
    private val _username = MutableStateFlow("")
    val username: StateFlow<String> = _username.asStateFlow()

    private val _firstName = MutableStateFlow("")
    val firstName: StateFlow<String> = _firstName.asStateFlow()

    private val _lastName = MutableStateFlow("")
    val lastName: StateFlow<String> = _lastName.asStateFlow()

    private val _email = MutableStateFlow("")
    val email: StateFlow<String> = _email.asStateFlow()

    private val _enabled = MutableStateFlow(true)
    val enabled: StateFlow<Boolean> = _enabled.asStateFlow()

    private val _emailVerified = MutableStateFlow(false)
    val emailVerified: StateFlow<Boolean> = _emailVerified.asStateFlow()

    // Roles
    private val _roleSearchQuery = MutableStateFlow("")
    val roleSearchQuery: StateFlow<String> = _roleSearchQuery.asStateFlow()

    private val _selectedRoles = MutableStateFlow<Set<String>>(emptySet())
    val selectedRoles: StateFlow<Set<String>> = _selectedRoles.asStateFlow()

    private var allRoles: List<KeycloakRole> = emptyList()
    private var userCurrentRoles: Set<String> = emptySet()

    init {
        loadUser()
        loadRoles()
        loadUserRoles()
    }

    private fun loadUser() {
        viewModelScope.launch {
            try {
                _uiState.value = EditUserUiState.Loading

                val api = authManager.getClient()

                originalUser = withContext(Dispatchers.IO){
                    api.getUser(userId)
                };

                originalUser?.let {
                    _username.value = it.username
                    _email.value = it.email ?: ""
                    _enabled.value = it.enabled
                    _emailVerified.value = it.emailVerified
                    _firstName.value = it.firstName ?: ""
                    _lastName.value = it.lastName ?: ""
                }

                _uiState.value = EditUserUiState.Idle
            } catch (e: Exception) {
                _uiState.value = EditUserUiState.Error(
                    e.message ?: "Failed to load user ${e.javaClass.simpleName}"
                )
            }
        }
    }

    fun updateUsername(value: String) {
        _username.value = value
    }

    fun updateFirstName(value: String) {
        _firstName.value = value
    }

    fun updateLastName(value: String) {
        _lastName.value = value
    }

    fun updateEmail(value: String) {
        _email.value = value
    }

    fun updateEnabled(value: Boolean) {
        _enabled.value = value
    }

    fun updateEmailVerified(value: Boolean) {
        _emailVerified.value = value
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

    fun clearSelectedRoles() {
        _selectedRoles.value = emptySet()
    }

    private fun loadRoles() {
        viewModelScope.launch {
            try {
                _rolesUiState.value = RolesUiState.Loading

                val api = authManager.getClient()
                allRoles = withContext(Dispatchers.IO){
                    api.searchRoles(query = null, offSet = 0, brief = false)
                }

                filterRoles()
            } catch (e: Exception) {
                _rolesUiState.value = RolesUiState.Error(
                    e.message ?: "Failed to load roles"
                )
            }
        }
    }

    private fun loadUserRoles() {
        viewModelScope.launch {
            try {
                val api = authManager.getClient()
                // Assuming there's a method to get user's current roles
                // val currentRoles = api.getUserRoles(userId)
                // userCurrentRoles = currentRoles.map { it.id }.toSet()
                // _selectedRoles.value = userCurrentRoles

                // TODO: Replace with actual API call when available
                _selectedRoles.value = emptySet()
            } catch (e: Exception) {
                // Handle error silently or show warning
            }
        }
    }

    private fun filterRoles() {
        val query = _roleSearchQuery.value.lowercase()
        val filtered = if (query.isEmpty()) {
            allRoles
        } else {
            allRoles.filter { role ->
                role.name?.lowercase()?.contains(query) == true ||
                        role.description?.lowercase()?.contains(query) == true
            }
        }
        _rolesUiState.value = RolesUiState.Success(filtered)
    }

    fun saveChanges() {
        viewModelScope.launch {
            try {
                _uiState.value = EditUserUiState.Saving

                val api = authManager.getClient()

                // Update basic user info
                val updatedUser = originalUser?.copy(
                    username = _username.value,
                    firstName = _firstName.value.ifEmpty { null },
                    lastName = _lastName.value.ifEmpty { null },
                    email = _email.value.ifEmpty { null },
                    enabled = _enabled.value,
                    emailVerified = _emailVerified.value
                )

                // TODO: Call API to update user
                // if (updatedUser != null) {
                //     api.updateUser(userId, updatedUser)
                // }

                // Update roles if changed
                val rolesToAdd = _selectedRoles.value - userCurrentRoles
                val rolesToRemove = userCurrentRoles - _selectedRoles.value

                // TODO: Call API to update roles
                // if (rolesToAdd.isNotEmpty()) {
                //     api.addUserRoles(userId, rolesToAdd.toList())
                // }
                // if (rolesToRemove.isNotEmpty()) {
                //     api.removeUserRoles(userId, rolesToRemove.toList())
                // }

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
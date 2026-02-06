package art.ameliah.ehb.keyveil.ui.pages

import android.content.Context
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager
import art.ameliah.ehb.keyveil.core.http.models.KeycloakUser
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.flow.*
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

sealed class UsersUiState {
    data object Loading : UsersUiState()
    data class Success(val users: List<KeycloakUser>) : UsersUiState()
    data class Error(val message: String) : UsersUiState()
}

class UsersViewModel(
    private val context: Context,
    private val authManager: KeycloakAuthManager
) : ViewModel() {

    private val _uiState = MutableStateFlow<UsersUiState>(UsersUiState.Loading)
    val uiState: StateFlow<UsersUiState> = _uiState.asStateFlow()

    private val _searchQuery = MutableStateFlow("")
    val searchQuery: StateFlow<String> = _searchQuery.asStateFlow()

    init {
        loadUsers()
    }

    fun loadUsers() {
        viewModelScope.launch {
            _uiState.value = UsersUiState.Loading

            try {
                val result = withContext(Dispatchers.IO) {
                    authManager.getClient().searchUsers()
                }
                _uiState.value = UsersUiState.Success(result)
            } catch (e: Exception) {
                _uiState.value = UsersUiState.Error(
                    e.message ?: "Failed to load users"
                )
            }
        }
    }

    fun searchUsers(query: String) {
        _searchQuery.value = query

        viewModelScope.launch {
            _uiState.value = UsersUiState.Loading

            try {
                val result = if (query.isBlank()) {
                    authManager.getClient().searchUsers()
                } else {
                    authManager.getClient().searchUsers(query)
                }
                _uiState.value = UsersUiState.Success(result)
            } catch (e: Exception) {
                _uiState.value = UsersUiState.Error(
                    e.message ?: "Search failed"
                )
            }
        }
    }

    fun clearSearch() {
        searchUsers("")
    }
}
package art.ameliah.ehb.keyveil.ui.pages

import android.content.Context
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager
import art.ameliah.ehb.keyveil.core.http.KeycloakApiClient
import art.ameliah.ehb.keyveil.core.http.KeycloakUser
import art.ameliah.ehb.keyveil.core.storage.SecureStorage
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

    private val apiClient: KeycloakApiClient? by lazy {
        try {
            val secureStorage = SecureStorage(context)
            val authority = secureStorage.getValue(SecureStorage.KEY_AUTHORITY)
                ?: return@lazy null

            val baseUrl = authority.replace("/realms/", "/admin/realms/")

            KeycloakApiClient(
                baseUrl = baseUrl,
                getAccessToken = { authManager.refreshTokenIfNeeded() }
            )
        } catch (e: Exception) {
            null
        }
    }

    init {
        loadUsers()
    }

    fun loadUsers() {
        viewModelScope.launch {
            _uiState.value = UsersUiState.Loading

            if (apiClient == null) {
                _uiState.value = UsersUiState.Error("API client not configured")
                return@launch
            }

            try {
                val result = withContext(Dispatchers.IO) {
                    apiClient!!.getUsersPage(first = 0, max = 100)
                }
                _uiState.value = UsersUiState.Success(result.items)
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

            if (apiClient == null) {
                _uiState.value = UsersUiState.Error("API client not configured")
                return@launch
            }

            try {
                val result = if (query.isBlank()) {
                    apiClient!!.getUsersPage(first = 0, max = 100)
                } else {
                    apiClient!!.searchUsers(search = query, first = 0, max = 100)
                }
                _uiState.value = UsersUiState.Success(result.items)
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
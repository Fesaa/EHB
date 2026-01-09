package art.ameliah.ehb.keyveil.ui.pages

import android.content.Context
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import art.ameliah.ehb.keyveil.core.auth.KeycloakAuthManager
import art.ameliah.ehb.keyveil.core.http.models.KeycloakClient
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.flow.*
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

sealed class ClientsUiState {
    data object Loading : ClientsUiState()
    data class Success(val clients: List<KeycloakClient>) : ClientsUiState()
    data class Error(val message: String) : ClientsUiState()
}

class ClientsViewModel(
    private val context: Context,
    private val authManager: KeycloakAuthManager
) : ViewModel() {

    private val _uiState = MutableStateFlow<ClientsUiState>(ClientsUiState.Loading)
    val uiState: StateFlow<ClientsUiState> = _uiState.asStateFlow()

    private val _searchQuery = MutableStateFlow("")
    val searchQuery: StateFlow<String> = _searchQuery.asStateFlow()

    init {
        loadClients()
    }

    fun loadClients() {
        viewModelScope.launch {
            _uiState.value = ClientsUiState.Loading

            try {
                val result = withContext(Dispatchers.IO) {
                    authManager.getClient().searchClients(null)
                }
                _uiState.value = ClientsUiState.Success(result)
            } catch (e: Exception) {
                _uiState.value = ClientsUiState.Error(
                    e.message ?: "Failed to load clients"
                )
            }
        }
    }

    fun searchClients(query: String) {
        _searchQuery.value = query

        viewModelScope.launch {
            _uiState.value = ClientsUiState.Loading

            try {
                val result = if (query.isBlank()) {
                    authManager.getClient().searchClients(null)
                } else {
                    authManager.getClient().searchClients(query)
                }
                _uiState.value = ClientsUiState.Success(result)
            } catch (e: Exception) {
                _uiState.value = ClientsUiState.Error(
                    e.message ?: "Search failed"
                )
            }
        }
    }

    fun clearSearch() {
        searchClients("")
    }
}
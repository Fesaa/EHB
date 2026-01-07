package art.ameliah.ehb.keyveil.core.auth

import android.content.Context
import android.content.SharedPreferences
import androidx.security.crypto.EncryptedSharedPreferences
import androidx.security.crypto.MasterKey
import androidx.core.content.edit

class SecureStorage(context: Context) {

    companion object {
        private const val PREFS_NAME = "keyveil_secure_prefs"
        const val KEY_CLIENT_ID = "client_id"
        const val KEY_AUTHORITY = "authority"
    }

    private val masterKey: MasterKey = MasterKey.Builder(context)
        .setKeyScheme(MasterKey.KeyScheme.AES256_GCM)
        .build()

    private val sharedPreferences: SharedPreferences = EncryptedSharedPreferences.create(
        context,
        PREFS_NAME,
        masterKey,
        EncryptedSharedPreferences.PrefKeyEncryptionScheme.AES256_SIV,
        EncryptedSharedPreferences.PrefValueEncryptionScheme.AES256_GCM
    )

    /**
     * Store a string value securely
     */
    fun setValue(key: String, value: String) {
        sharedPreferences.edit { putString(key, value) }
    }

    /**
     * Retrieve a string value
     */
    fun getValue(key: String): String? {
        return sharedPreferences.getString(key, null)
    }

    /**
     * Store a boolean value securely
     */
    fun setBoolean(key: String, value: Boolean) {
        sharedPreferences.edit { putBoolean(key, value) }
    }

    /**
     * Retrieve a boolean value
     */
    fun getBoolean(key: String, defaultValue: Boolean = false): Boolean {
        return sharedPreferences.getBoolean(key, defaultValue)
    }

    /**
     * Store an integer value securely
     */
    fun setInt(key: String, value: Int) {
        sharedPreferences.edit { putInt(key, value) }
    }

    /**
     * Retrieve an integer value
     */
    fun getInt(key: String, defaultValue: Int = 0): Int {
        return sharedPreferences.getInt(key, defaultValue)
    }

    /**
     * Store a long value securely
     */
    fun setLong(key: String, value: Long) {
        sharedPreferences.edit { putLong(key, value) }
    }

    /**
     * Retrieve a long value
     */
    fun getLong(key: String, defaultValue: Long = 0L): Long {
        return sharedPreferences.getLong(key, defaultValue)
    }

    /**
     * Check if a key exists
     */
    fun containsKey(key: String): Boolean {
        return sharedPreferences.contains(key)
    }

    /**
     * Remove a specific key
     */
    fun removeKey(key: String) {
        sharedPreferences.edit { remove(key) }
    }

    /**
     * Clear all stored data
     */
    fun clear() {
        sharedPreferences.edit { clear() }
    }

    /**
     * Get all keys stored
     */
    fun getAllKeys(): Set<String> {
        return sharedPreferences.all.keys
    }
}
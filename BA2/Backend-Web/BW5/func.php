<?php
$USERNAME = "Holo";
$PASSWORD = "Lawrence";

require_once("Log.php");

session_start();
function checkLogin(): bool
{
    global $USERNAME, $PASSWORD;
    if (empty($_SESSION)) {
        return false;
    }

    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $success = $username == $USERNAME && $password == $PASSWORD;

    $log = new Log($username, $_SERVER["REMOTE_ADDR"], $success ? "S" : "E");
    $log->logToFile();
    $log = null;

    return $success;
}

function updateSession($username, $password)
{
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
}

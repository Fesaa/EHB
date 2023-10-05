<?php
$USERNAME = "Holo";
$PASSWORD = "Lawrence";

session_start();
function checkLogin(): bool
{
    global $USERNAME, $PASSWORD;
    if (empty($_SESSION)) {
        return false;
    }

    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    return $username == $USERNAME && $password == $PASSWORD;
}

function updateSession($username, $password)
{
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
}

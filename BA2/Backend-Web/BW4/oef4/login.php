<?php

include_once("func.php");

if (!empty($_POST)) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    updateSession($username, $password);
}

if (checkLogin()) {
    header("Location: secret1.php");
    exit();
}

?>

<form action="login.php" method="post">

    <label for="username">Username:</label>
    <input type="text" name="username" id="username"><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password"><br>

    <input type="submit" value="Login">
</form>



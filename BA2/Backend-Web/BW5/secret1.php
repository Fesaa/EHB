<?php
include_once("func.php");
if (!checkLogin()) {
    header("Location: login.php");
    exit();
}
?>

<h1>Secret 1</h1>

<button onclick="location.href = 'secret2.php'">Secret 2</button>
<button onclick="location.href = 'logout.php'">Logout</button>
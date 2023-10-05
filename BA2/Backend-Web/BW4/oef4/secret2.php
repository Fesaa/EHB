<?php
include_once("func.php");
if (!checkLogin()) {
    header("Location: login.php");
    exit();
}
?>

<h1>Secret 2</h1>

<button onclick="location.href = 'secret1.php'">Secret 1</button>
<button onclick="location.href = 'logout.php'">Logout</button>

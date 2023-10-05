<?php

if (!empty($_GET)) {
    $lang = $_GET['language'];
    setcookie('lang', $lang);
    header('Location: index.php');
}

?>

<form action="settings.php" method="get">
    <input type="radio" id="en" name="language" value="en">
    <label for="en">English</label><br>
    <input type="radio" id="fr" name="language" value="fr">
    <label for="fr">Français</label><br>
    <input type="radio" id="nl" name="language" value="nl">
    <label for="nl">Nederlands</label><br>

    <input type="submit" value="Safe preference">
</form>

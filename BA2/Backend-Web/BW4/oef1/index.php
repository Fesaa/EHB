<?php
$lang = $_COOKIE['lang'];
if ($lang == '') {
    $lang = 'en';
}
if ($lang == 'en') {
    ?>
<h1>Welcome to the home page!</h1>
<p>Everyone loves Holo here <3</p>
<?php
} else if ($lang == 'nl') {
    ?>
<h1>Welkom op de homepagina!</h1>
<p>Iedereen houdt van Holo hier <3</p>
<?php
} else if ($lang == 'fr') {
    ?>
<h1>Bienvenue sur la page d'accueil!</h1>
<p>Tout le monde aime Holo ici <3</p>
<?php
}
?>

<button onclick="location.href = 'settings.php'">Settings</button>

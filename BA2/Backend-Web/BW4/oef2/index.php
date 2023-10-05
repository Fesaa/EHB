<?php
$lang = $_COOKIE['lang'];
if ($lang == '') {
    $lang = 'en';
}

$name = $_COOKIE['name'];
if ($name == '') {
    $name = 'visitor';
}

$bgColour = $_COOKIE['bg-colour'];
if ($bgColour == '') {
    $bgColour = 'white';
}

$tz = $_COOKIE['tz'];
if ($tz == '') {
    $tz = 'Europe/Brussels';
}

$TITLE = [
    "en" => "Welcome $name to the home page!",
    "nl" => "Welkom $name op de homepagina!",
    "fr" => "Bienvenue $name sur la page d'accueil!"
];
$TEXT = [
    "en" => "Everyone loves Holo here <3",
    "nl" => "Iedereen houdt van Holo hier <3",
    "fr" => "Tout le monde aime Holo ici <3"
];

$title = $TITLE[$lang];
$text = $TEXT[$lang];
?>

<style>
    body {
        background: <?php echo $bgColour ?>;
    }
</style>

<h1><?php echo $title; ?></h1>
<p><?php echo $text ?></p>
<p><?php
    $timestamp = time();
    try {
        $dt = new DateTime("now", new DateTimeZone($tz));
        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
        echo $dt->format('d.m.Y, H:i:s');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?></p>

<button onclick="location.href = 'settings.php'">Settings</button>

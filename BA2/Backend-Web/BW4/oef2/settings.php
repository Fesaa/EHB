<?php

if (!empty($_GET)) {
    setcookie('lang', $_GET['language']);
    setcookie('name', $_GET['name']);
    setcookie('bg-colour', $_GET['bg-colour']);
    setcookie('tz', $_GET['tz'], strtotime('2023-12-31'));
    header('Location: index.php');
}

$bgColour = $_COOKIE['bg-colour'];
if ($bgColour == '') {
    $bgColour = 'white';
}
$tz = $_COOKIE['tz'];
if ($tz == '') {
    $tz = 'Europe/Brussels';
}

function makeBgOption($value, $text) {
    global $bgColour;
    $selectedText = '';
    if ($bgColour == $value) {
        $selectedText = 'selected';
    }
    return "<option value='$value' $selectedText>$text</option>";
}

function makeTzOption($value, $text) {
    global $tz;
    $selectedText = '';
    if ($tz == $value) {
        $selectedText = 'selected';
    }
    return "<option value='$value' $selectedText>$text</option>";

}

?>

<style>
    body {
        background: <?php echo $bgColour ?>;
    }
</style>

<form action="settings.php" method="get">
    <input type="radio" id="en" name="language" value="en">
    <label for="en">English</label><br>
    <input type="radio" id="fr" name="language" value="fr">
    <label for="fr">Français</label><br>
    <input type="radio" id="nl" name="language" value="nl">
    <label for="nl">Nederlands</label><br>

    <label for="name">Your name:</label>
    <input type="text" id="name" name="name" value="<?php echo $_COOKIE['name'] ?>"><br>

    <label for="tz">Timezone:</label>
    <select name="tz" id="tz">
        <?php
        $timezones = [
            'Europe/Brussels' => 'Brussels',
            'Europe/Paris' => 'Paris',
            'Europe/London' => 'London',
            'Europe/Moscow' => 'Moscow',
            'Europe/Athens' => 'Athens',
            'America/New_York' => 'New York',
            'America/Los_Angeles' => 'Los Angeles',
            'Asia/Tokyo' => 'Tokyo',
            'Australia/Sydney' => 'Sydney',
        ];
        foreach ($timezones as $value => $text) {
            echo makeTzOption($value, $text);
        }
        ?>
    </select><br>

    <label for="bg-colour">Personalized BackGround Colour</label>
    <select name="bg-colour" id="bg-colour">
        <?php
        $backgrounds = [
            'white' => 'White',
            '#FF8080' => 'Red',
            '#D2E0FB' => 'Blue',
            '#CDFAD5' => 'Green',
            '#FBECD2' => 'Yellow',
        ];
        foreach ($backgrounds as $value => $text) {
            echo makeBgOption($value, $text);
        }
        ?>
    </select><br>


    <input type="submit" value="Safe preference">
</form>

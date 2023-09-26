<?php include_once("meetkunde.php") ?>

<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WC 1</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="script.js"></script>
<html lang="eng">

<body>

<h1>Werkcollege 1</h1>
<label for="oefs"></label><select name="Oefeningen" id="oefs" style="width: 300px;">
    <option value="none"> -- select an option --</option>
    <option value="oef1">1</option>
    <option value="oef2">2</option>
    <option value="oef3">3</option>
    <option value="oef4">4</option>
    <option value="oef5">5</option>
    <option value="oef6">6</option>
    <option value="oef7">7</option>
    <option value="oef8">8</option>
    <option value="oef9">9</option>
    <option value="oef10">10</option>
    <option value="oef11">11</option>
    <option value="oef12">12</option>
    <option value="oef13">13</option>
    <option value="oef14">14</option>
    <option value="oef15">15</option>
    <option value="oef16">16</option>
    <option value="oef17">17</option>
    <option value="oef18">18</option>
    <option value="oef19">19</option>
</select>

<div id="oef1">
    <?php
    echo berekenOppervlakteCirkel(2.2);
    ?>
</div>
<div id="oef2">
    <?php
    $drie = berekenOppervlakteDriehoek(2.2, 3.3);
    $recht = berekenOppervlakteRechthoek(2.2, 3.3);
    $vier = berekenOppervlakteVierkant(2.2);

    echo "<p> $drie </p>";
    echo "<p> $recht </p>";
    echo "<p> $vier </p>";
    ?>
</div>
<div id="oef3">
    <?php
    echo $functionsExecutedCounter;
    ?>
</div>
<div id="oef4">
    <?php
    $var1 = "something";
    $var2 = null;
    $var3 = 0;
    $var4 = 1;
    $var5 = "aaa";

    $bool1 = isset($var1) == true;
    $bool2 = isset($var2) == false;
    $bool3 = empty($var3) == true;
    $bool4 = empty($var4) == false;
    $bool5 = isset($var5) == true && empty($var5) == false;

    echo "<p> $bool1 </p>";
    echo "<p> $bool2 </p>";
    echo "<p> $bool3 </p>";
    echo "<p> $bool4 </p>";
    echo "<p> $bool5 </p>";
    ?>
</div>
<div id="oef5">
    <?php
    function goodNumber(int $number): bool
    {
        return in_array($number, [10, 20, 30]);
    }

    foreach ([1, 20, 7, 30, -1] as $number) {
        if (goodNumber($number)) {
            echo "<p> Het nummer is gelijk aan $number. </p>";
        }
    }
    ?>
</div>
<div id="oef6">
    <?php
    $sum = 0;
    for ($i = 0; $i < 30; $i++) {
        $sum += $i;
    }
    echo $sum
    ?>
</div>
<div id="oef7">
    <?php
    echo date("l d/m/y, H:m");
    switch (date("F")) {
        case "December":
        case "January":
        case "February":
            echo "<p> Het is winter. </p>";
            break;
        case "March":
        case "April":
        case "May":
            echo "<p> Het is lente. </p>";
            break;
        case "June":
        case "July":
        case "August":
            echo "<p> Het is zomer. </p>";
            break;
        case "September":
        case "October":
        case "November":
            echo "<p> Het is herfst. </p>";
            break;
    }
    ?>
</div>
<div id="oef8">
    <?php
    function splitsNaam(string $naam): string
    {
        if (!str_contains($naam, " ")) {
            die ("De naam moet een voornaam en een achternaam bevatten.");
        }
        $voornaam = "";
        $achternaam = "";
        $passedSpace = false;
        foreach (str_split($naam) as $char) {
            if ($char == " ") {
                $passedSpace = true;
            } else if ($passedSpace) {
                $achternaam .= $char;
            } else {
                $voornaam .= $char;
            }
        }
        return "
<ul>
   <li>Voornaam: $voornaam</li>
   <li>Achternaam: $achternaam</li>
</ul>
";
    }

    function voegNamenSamen(string $voornaam, string $achternaam): string
    {
        return $voornaam . ' ' . $achternaam;
    }

    echo splitsNaam("Jan Janssens");
    echo voegNamenSamen("Jan", "Janssens");
    ?>
</div>
<div id="oef9">
    <?php
    $euMemberStates = [
        "Austria",
        "Belgium",
        "Bulgaria",
        "Croatia",
        "Cyprus",
        "Czech Republic",
        "Denmark",
        "Estonia",
        "Finland",
        "France",
        "Germany",
        "Greece",
        "Hungary",
        "Ireland",
        "Italy",
        "Latvia",
        "Lithuania",
        "Luxembourg",
        "Malta",
        "Netherlands",
        "Poland",
        "Portugal",
        "Romania",
        "Slovakia",
        "Slovenia",
        "Spain",
        "Sweden"
    ];
    ?>
    <h3>Oefening 9</h3>
    <h4>De Europese Unie:</h4>
    <p>De Europese Unie telt sinds 2020 in totaal 27 lidstaten.</p>
    <h5>De volledige lijst van lidstaten, alfabetisch gerangschikt</h5>
    <ol>
        <?php
        foreach ($euMemberStates as $state) {
            echo "<li>$state</li>";
        }
        ?>
    </ol>
</div>
<div id="oef10">
    <table>
        <tr>
            <th>Oefening 10</th>
        </tr>
        <?php
        for ($i = 1; $i < 6; $i++) {
            echo "<tr>";
            for ($j = 1; $j < 7; $j++) {
                $mul = $j * $i;
                echo "<th> $j * $i = $mul  </th><th>   </th>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</div>
<div id="oef11">
    <?php
    function caseMagic(string $s): array
    {
        $out = [];
        $out[] = strtoupper($s);
        $out[] = strtolower($s);
        $out[] = ucfirst($s);
        $out[] = ucwords($s);

        return $out;
    }

    function shuffleWord(string $s): string
    {
        return str_shuffle($s);
    }

    function isPalindroom(string $s): string
    {
        $chars = str_split($s);
        $len = sizeof($chars) - 1;
        $half_len = $len / 2;
        for ($i = 0; $i < $half_len + 1; $i++) {
            if ($chars[$i] != $chars[$len - $i]) {
                return false;
            }
        }
        return true;
    }

    function isAnagram(string $s1, string $s2): bool
    {
        $s1 = strtolower($s1);
        $s2 = strtolower($s2);
        foreach (str_split($s1) as $char) {
            if ($char != " " && !str_contains($s2, $char)) {
                return false;
            }
        }

        return true;
    }


    foreach (caseMagic("this is my test string") as $s) {
        $shuffeled = shuffleWord($s);
        echo "<p> $s => $shuffeled </p>";
    }
    foreach (["kok", "test", "no", "pop", "tarewerat"] as $s) {
        if (isPalindroom($s)) {
            echo "<p> $s is <b>een</b> palindroom </p>";
        } else {
            echo "<p> $s is geen palindroom </p>";
        }
    }
    foreach (["Torchwood" => "Doctor Who", "Tom Marvolo Riddle" => "I am lord Voldemort", "no" => "pop"] as $s => $s2) {
        if (isAnagram($s, $s2)) {
            echo "<p> $s is <b>een</b> anagram </p>";
        } else {
            echo "<p> $s is geen anagram </p>";
        }
    }
    ?>
</div>
<div id="oef12">
    <?php
    $email = "kevin@ehb.be";
    $split = explode("@", $email);
    $gebruikersNaam = $split[0];
    $domain = $split[1];
    echo $gebruikersNaam;
    echo $domain;
    ?>
</div>
<div id="oef13">
    <h3>Oefening 13</h3>
    <h4>De Europese Unie:</h4>
    <p>De Europese Unie telt sinds 2020 in totaal 27 lidstaten.</p>
    <h5>De volledige lijst van lidstaten, alfabetisch gerangschikt</h5>
    <ol>
        <?php
        $a = $euMemberStates;
        shuffle($a);
        foreach ($a as $state) {
            echo "<li>$state</li>";
        }
        ?>
    </ol>
</div>
<div id="oef14">
    <h3>Oefening 14</h3>
    <h4>De Europese Unie:</h4>
    <p>De Europese Unie telt sinds 2020 in totaal 27 lidstaten.</p>
    <h5>De volledige lijst van lidstaten, alfabetisch gerangschikt</h5>
    <ol>
        <?php
        $a = $euMemberStates;
        $a = array_filter($a, function (string $item): bool {
            return str_starts_with($item, "B");
        });
        foreach ($a as $state) {
            echo "<li>$state</li>";
        }
        ?>
    </ol>
</div>
<div id="oef15">
    <h3>Oefening 15</h3>
    <h4>De Europese Unie:</h4>
    <p>De Europese Unie telt sinds 2020 in totaal 27 lidstaten.</p>
    <h5>De volledige lijst van lidstaten, alfabetisch gerangschikt</h5>
    <ol>
        <?php
        $a = $euMemberStates;
        $a = array_filter($a, function (string $item): bool {
            return !str_starts_with($item, "B");
        });
        foreach ($a as $state) {
            echo "<li>$state</li>";
        }
        ?>
    </ol>
</div>
<div id="oef16">
    <?php
    function parameterTest($a, $b): void
    {
        echo "<p> A is $a </p>";
        echo "<p> B is $b </p>";
    }

    parameterTest("Hello", 29);
    parameterTest(true, "PHP");
    parameterTest('A, B', 3, 4.5);
    parameterTest(1, 2, 3, 4);
    ?>
</div>
<div id="oef17">
    <?php
    function convertTextToNumber(string $s): int|float
    {
        $chars = explode(";", $s);
        $mapper = [
            "nul" => "0",
            "een" => "1",
            "twee" => "2",
            "drie" => "3",
            "vier" => "4",
            "vijf" => "5",
            "zes" => "6",
            "zeven" => "7",
            "acht" => "8",
            "negen" => "9"
        ];
        $i = "";
        foreach ($chars as $char) {
            $i .= $mapper[$char];
        }
        return $i;
    }
    echo convertTextToNumber('een;drie;nul;vijf');
    ?>
</div>
<div id="oef18">
    <?php
    function fib(int $n): string {
        function inner(int $n): int {
            if ($n == 0 || $n == 1) {
                return $n;
            } else {
                return inner($n-1) + inner($n-2);
            }
        }
        $out = "";
        for ($i = 0; $i < $n; $i++) {
            $out .= " " . inner($i);
        }
        return $out;
    }
    echo fib(6);
    ?>
</div>
<div id="oef19">
    <?php
    function doStuff(int $n): void {
        $isMul = $n % 2;
        if ($isMul == 0) {
            $div = $n / 2;
            echo "<p> $n is een veelvoud van 2, 2^$div</p>";
        } else {
            $close = $n - 1;
            $div = $close / 2;
            echo "<p> $n is geen veelvoud van 2, het dichtste veelvoud is $close, 2^$div</p>";
        }
    }
    doStuff(64);
    doStuff(13);
    ?>
</div>

</body>

</html>

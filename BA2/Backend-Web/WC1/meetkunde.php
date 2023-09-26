<?php 

global $functionsExecutedCounter;
$functionsExecutedCounter = 0;

function berekenOppervlakteCirkel(float $straal): float {
    global $functionsExecutedCounter;
    $functionsExecutedCounter++;
    return pi() * $straal * $straal;
}

function berekenOppervlakteDriehoek(float $basis, float $hoogte): float {
    global $functionsExecutedCounter;
    $functionsExecutedCounter++;
    return $basis * $hoogte / 2;
}

function berekenOppervlakteRechthoek(float $lengte, float $breedte): float {
    global $functionsExecutedCounter;
    $functionsExecutedCounter++;
    return $lengte * $breedte;
}

function berekenOppervlakteVierkant(float $zijde): float {
    global $functionsExecutedCounter;
    $functionsExecutedCounter++;
    return $zijde * $zijde;
}
?>

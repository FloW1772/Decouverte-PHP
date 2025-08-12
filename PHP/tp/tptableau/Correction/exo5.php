<?php

// Génération des entiers de 1 à 63
$t1 = [];
for ($i = 1; $i <= 63; $i++) {
    $t1[] = $i;
}

// Création de $t2 avec 0 en premier, puis les valeurs de $t1 divisées par 10
$t2 = [0];
foreach ($t1 as $val) {
    $t2[] = $val / 10;
}

// Calcul du sinus de chaque valeur de $t2 et stockage dans $t3 avec la clé sous forme de chaîne
$t3 = [];
foreach ($t2 as $reel) {
    $t3[(string) $reel] = sin($reel);
}

// Affichage sous forme de tableau HTML
echo '<table style="border-collapse: collapse">';
echo '<tr><th style="border: 1px solid black">x</th><th style="border: 1px solid black">sin(x)</th></tr>';

foreach ($t3 as $x => $sinx) {
    echo '<tr>';
    echo '<td style="border: 1px solid black">' . htmlspecialchars($x) . '</td>';
    echo '<td style="border: 1px solid black">' . htmlspecialchars($sinx) . '</td>';
    echo '</tr>';
}

echo '</table>';

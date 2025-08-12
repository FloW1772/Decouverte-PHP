<?php

$personnes1 = include __DIR__ . '/../Exercice1/exo1.php';
$personnes2 = include __DIR__ . '/../Exercice2/exo2.php';

echo "<h2>Affichage du tableau de l'exercice 1</h2>";
foreach ($personnes1 as $nom => $infos) {
    echo "• Élément $nom<br>";
    foreach ($infos as $index => $valeur) {
        echo "o élément $index : $valeur<br>";
    }
    echo "<br>";
}

echo "<h2>Affichage du tableau de l'exercice 2</h2>";
foreach ($personnes2 as $nom => $infos) {
    echo "• Élément $nom<br>";
    $i = 0;
    foreach ($infos as $cle => $valeur) {
        echo "o élément $i : $valeur<br>";
        $i++;
    }
    echo "<br>";
}
?>

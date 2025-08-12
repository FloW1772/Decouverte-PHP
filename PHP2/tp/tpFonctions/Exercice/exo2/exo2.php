<?php

// Fonction qui trie deux entiers par ordre décroissant
function trierDecroissant(&$a, &$b) {
    if ($a < $b) {
        // Échange les valeurs
        $temp = $a;
        $a = $b;
        $b = $temp;
    }
}

// Exemple d'utilisation
$x = 3;
$y = 7;

echo "Avant tri : x = $x, y = $y\n";

trierDecroissant($x, $y);

echo "Après tri : x = $x, y = $y\n";

?>

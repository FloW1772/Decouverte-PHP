<?php
// Version itérative de l'algorithme d'Euclide
function pgcdIteratif(int $a, int $b): int {
    while ($b != 0) {
        $reste = $a % $b;
        $a = $b;
        $b = $reste;
    }
    return abs($a); // On retourne toujours une valeur positive
}

// Version récursive de l'algorithme d'Euclide
function pgcdRecursif(int $a, int $b): int {
    if ($b == 0) {
        return abs($a); // Valeur absolue au cas où
    }
    return pgcdRecursif($b, $a % $b);
}

// ----------------------
// Exemples d'utilisation
// ----------------------

$a = 48;
$b = 18;

echo "PGCD de $a et $b (itératif) : " . pgcdIteratif($a, $b) . "\n";
echo "PGCD de $a et $b (récursif) : " . pgcdRecursif($a, $b) . "\n";

// Autres exemples
echo "PGCD de 100 et 85 (itératif) : " . pgcdIteratif(100, 85) . "\n";
echo "PGCD de 100 et 85 (récursif) : " . pgcdRecursif(100, 85) . "\n";
?>

<?php
function tirerJusqua($cible) {
    // Vérifie que le nombre est bien inférieur à 1000
    if ($cible >= 1000 || $cible < 0) {
        return "Erreur : le nombre doit être compris entre 0 et 999.";
    }

    $nombreTirages = 0;
    do {
        $tirage = rand(0, 999); // Tire un nombre aléatoire entre 0 et 999
        $nombreTirages++;
    } while ($tirage !== $cible); // Continue tant que le nombre tiré n'est pas la cible

    return $nombreTirages;
}

// Exemple d'utilisation
$cible = 123;
echo "Nombre de tirages pour obtenir $cible : " . tirerJusqua($cible);
?>

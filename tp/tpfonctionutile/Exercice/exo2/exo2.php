<?php

$noms = [
    "Jean Dupont",
    "Marie Curie",
    "Albert Einstein",
    "Ada Lovelace",
    "Isaac Newton",
    "Rosalind Franklin"
];

foreach ($noms as $personne) {
    list($prenom, $nom) = explode(" ", $personne, 2);

    $prenomFormate = str_pad($prenom, 20);
    $nomFormate = str_pad($nom, 20);

    echo $prenomFormate . $nomFormate . "<br>";
}

<?php

// 1. Tableau d'adresses e-mail
$emails = [
    "alice@gmail.com",
    "bob@yahoo.fr",
    "charlie@gmail.com",
    "diane@hotmail.com",
    "emma@outlook.com",
    "frank@yahoo.fr",
    "george@gmail.com",
    "hugo@orange.fr",
    "isa@free.fr",
    "julie@gmail.com"
];

// 2. Extraire les noms de serveur
$domaines = [];
foreach ($emails as $email) {
    $parts = explode("@", $email);
    if (count($parts) === 2) {
        $domaines[] = strtolower($parts[1]); // nom de domaine en minuscules
    }
}

// 3. Calcul des occurrences
$statistiques = array_count_values($domaines);

// 4. Affichage avec balises HTML pour saut de ligne
echo "Statistiques des fournisseurs d'e-mail :<br>";
foreach ($statistiques as $fournisseur => $nombre) {
    echo "- $fournisseur : $nombre occurrence(s)<br>";
}

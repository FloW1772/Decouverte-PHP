<?php
// 1. Tableau d'entiers de 1 à 63
$entiers = range(1, 63);

// 2. Tableau de nombres variant de 0.1 à 6.3 (1/10 à 63/10)
$decimaux = array_map(fn($x) => $x / 10, $entiers);

// 3. Tableau associatif clé = décimal, valeur = sin(décimal)
$sinus = [];
foreach ($decimaux as $val) {
    // Format clé en string avec 1 décimale pour la clé du tableau associatif
    $key = number_format($val, 1, '.', '');
    $sinus[$key] = sin($val);
}

// 4. Affichage dans un tableau HTML
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau Sinus</title>
    <style>
        table { border-collapse: collapse; width: 300px; margin: 20px auto; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
<h1>Tableau des valeurs de sin(x)</h1>
<table>
    <thead>
    <tr>
        <th>X (radians)</th>
        <th>sin(X)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($sinus as $x => $sinx): ?>
        <tr>
            <td><?= htmlspecialchars($x) ?></td>
            <td><?= number_format($sinx, 6) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

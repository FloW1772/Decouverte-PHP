<?php
namespace App;

require_once '../vendor/autoload.php';

use App\Entity\Voiture as Bagnole;

$voiture = new Bagnole();


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Exemple d'autoload</h1>
<?php

echo $voiture->rouler();

$dateDepart = new \DateTime("2025-05-01 10:30:00");

var_dump($dateDepart);

//premiere pratique

$dateArrive = clone $dateDepart;
$dateArrive = $dateArrive->modify('+1 hour');

var_dump($dateArrive);

//meilleur pratique
// et rajout de la timezone européenne

$dateDepart = new \DateTimeImmutable("2025-05-01 10:00:00");
$dateDepart->setTimezone(new \DateTimeZone("Europe/Paris"));
$dateArrive = $dateDepart->modify('+1 hour');
$dateArrive->setTimezone(new \DateTimeZone("Europe/Paris"));


?>

<p>Date de départ : <?= $dateDepart->format('d/m/Y h:i:s'); ?> </p>
<p>Date d'arrivé : <?= $dateArrive->format('d/m/Y h:i:s'); ?> </p>


</body>
</html>
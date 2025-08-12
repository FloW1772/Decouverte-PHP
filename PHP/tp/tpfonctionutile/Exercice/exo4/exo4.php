<?php
$dateNaissance = '2001-07-17 15:10:10';

// UTC pour éviter tout biais
$birthDate = new DateTime($dateNaissance, new DateTimeZone('UTC'));
$now = new DateTime('now', new DateTimeZone('UTC'));

$diff = $now->diff($birthDate);

echo "Vous avez :<br>";
echo $diff->y . " ans<br>";
echo $diff->m . " mois<br>";
echo $diff->d . " jours<br>";
echo $diff->h . " heures<br>";
echo $diff->i . " minutes<br>";
echo $diff->s . " secondes<br><br>";

$ageEnSecondes = $now->getTimestamp() - $birthDate->getTimestamp();
echo "Votre âge exact en secondes :<br>" . $ageEnSecondes . " secondes<br>";

?>
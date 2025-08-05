<?php
// Récupérer le mois et l'année courants
$month = date('n');
$year = date('Y');

// Jours de la semaine en français (lundi à dimanche)
$daysOfWeek = ['L', 'M', 'M', 'J', 'V', 'S', 'D'];

// IntlDateFormatter pour le nom du mois en français
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, 'MMMM');
$monthName = $formatter->format(new DateTime("$year-$month-01"));
$monthName = mb_convert_case($monthName, MB_CASE_TITLE, "UTF-8");

// Nombre de jours dans le mois
$numberDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Premier jour de la semaine du mois (1=lundi, ..., 7=dimanche)
$firstDayOfMonth = date('N', strtotime("$year-$month-01"));

// Début du tableau HTML
echo "<h2>$monthName $year</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
foreach ($daysOfWeek as $day) {
    echo "<th>$day</th>";
}
echo "</tr><tr>";

// Cases vides avant le 1er jour
for ($blank = 1; $blank < $firstDayOfMonth; $blank++) {
    echo "<td></td>";
}

$currentDay = 1;

// Affichage des jours
while ($currentDay <= $numberDays) {
    // Afficher le jour dans une case
    echo "<td>$currentDay</td>";

    // Calculer la position dans la semaine
    $position = ($blank + $currentDay - 1) % 7;

    if ($position == 0) {
        echo "</tr>";
        // S'il reste des jours, ouvrir une nouvelle ligne
        if ($currentDay != $numberDays) {
            echo "<tr>";
        }
    }

    $currentDay++;
}

// Compléter la dernière ligne avec des cases vides si nécessaire
if ($position != 0) {
    for ($i = $position; $i < 7; $i++) {
        echo "<td></td>";
    }
    echo "</tr>";
}

echo "</table>";
?>

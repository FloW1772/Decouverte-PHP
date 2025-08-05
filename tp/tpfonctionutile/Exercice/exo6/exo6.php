<?php
for ($year = 2018; $year <= 2037; $year++) {
    $date = new DateTime("$year-05-01");
    $dayOfWeek = $date->format('l'); // jour de la semaine en anglais

    // Traduction (facultative mais utile pour affichage en français)
    $jours = [
        'Monday'    => 'Lundi',
        'Tuesday'   => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday'  => 'Jeudi',
        'Friday'    => 'Vendredi',
        'Saturday'  => 'Samedi',
        'Sunday'    => 'Dimanche',
    ];

    echo "--------------------------------------------<br>";
    echo "📅 1er mai $year<br>";
    echo "Jour de la semaine : " . $jours[$dayOfWeek] . "<br>";

    switch ($dayOfWeek) {
        case 'Saturday':
        case 'Sunday':
            echo "🔔 Message : Désolé !<br>";
            break;
        case 'Monday':
        case 'Friday':
            echo "🎉 Message : Week-end prolongé !<br>";
            break;
        default:
            echo "📌 Message : En semaine<br>";
            break;
    }

    echo "<br>"; // Saut de ligne entre chaque année
}
?>

<?php

for ($year = 2018; $year <= 2037; $year++) {
    $easter = new DateTime();
    $easter->setTimestamp(easter_date($year));
    $ascension = clone $easter;
    $ascension->modify('+39 days');

    echo "Année $year : Ascension le " . $ascension->format('d/m/Y') . "<br>";
}

<?php
$date = new DateTime('2017-12-25');
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
echo $formatter->format($date);
?>

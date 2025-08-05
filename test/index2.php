<?php

ini_set('date.timezone', 'Europe/Paris');

$ts = mktime(0, 0, 0, 1, 1, 1970);

var_dump($ts);

$d = date('d/m/Y H:i:s' );

var_dump($d);


$listeCours = [ "10-PA PA PA PAM"];
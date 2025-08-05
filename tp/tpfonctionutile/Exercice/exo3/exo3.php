<?php

$array = ['1abc', '2def', '10ghi'];

// Tri naturel
natsort($array);

// Ré-indexation
$array = array_values($array);

// Pour affichage lisible dans un navigateur, entourer avec <pre>
echo '<pre>';
print_r($array);
echo '</pre>';

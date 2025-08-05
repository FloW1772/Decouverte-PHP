<?php

$mails = [
    'jean@eni.fr',
    'fred@linux.net',
    'lea@renault.fr',
    'caroline@eni.fr',
    'contact@eni-ecole.fr',
    'valentina@ferrari.it',
    'melanie@eni-ecole.fr',
    'philippe@eni.fr',
    'typhaine@belfort.fr',
    'louis@leparisien.fr'
];

$domaines = [];

foreach ($mails as $mail) {
    $domaine = explode('@', $mail)[1];

    if (isset($domaines[$domaine])) {
        $domaines[$domaine]++;
    } else {
        $domaines[$domaine] = 1;
    }
}

var_dump($domaines);

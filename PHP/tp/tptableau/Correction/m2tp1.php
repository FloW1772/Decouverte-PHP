<?php

// exercice 4

$mails = ['jean@eni.fr', 'fred@linux.net', '@yahoo.fr', 'lea@renault.fr', 'caroline@eni.fr',     'contact@eni-ecole.fr', 'valentina@ferrari.it', 'melanie@eni-ecole.fr',     'philippe@eni.fr', 'typhaine@belfort.fr', 'louis@leparisien.fr'];

foreach ($mails as $mail) {
    if (strpos($mail, '@') === false) {
        continue;
    }
    $nomDeDomaine = explode('@', $mail);
    //var_dump($nomDeDomaine[1]);
    if ($nomDeDomaine[1] == '') {
        continue;
    }
    if (!empty($tabStats[$nomDeDomaine[1]])) {
        $tabStats[$nomDeDomaine[1]]++;
    } else {
        $tabStats[$nomDeDomaine[1]] = 1;
    }
}

var_dump($tabStats);

// Exercice 5

for ($i = 0; $i < 64; $i++) {
    $tab1[] = $i;
}

var_dump($tab1);

for ($i = 0; $i < count($tab1); $i++) {
    $tab2[] = $tab1[$i] / 10;
}

var_dump($tab2);

for ($i = 0; $i < count($tab2); $i++) {
    $tab3[(string)$tab2[$i]] = sin($tab2[$i]);
}

var_dump($tab3);

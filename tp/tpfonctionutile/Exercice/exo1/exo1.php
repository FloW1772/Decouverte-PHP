<?php

$phrase = "bOnJoUr, jE sUiS UnE pHrAsE pOuR tEsTeR.";

// Convertir toute la phrase en minuscules, puis mettre en majuscule la première lettre de chaque mot
$phraseCorrigee = ucwords(strtolower($phrase));

echo $phrase;
echo "<br>". $phraseCorrigee;


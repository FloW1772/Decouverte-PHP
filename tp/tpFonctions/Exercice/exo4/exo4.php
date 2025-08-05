<?php

function calculerTrianglePascal($n) {
    $triangle = [];

    for ($i = 0; $i < $n; $i++) {
        $ligne = [];

        for ($j = 0; $j <= $i; $j++) {
            if ($j === 0 || $j === $i) {
                $ligne[$j] = 1;
            } else {
                $ligne[$j] = $triangle[$i - 1][$j - 1] + $triangle[$i - 1][$j];
            }
        }

        $triangle[$i] = $ligne;
    }

    return $triangle;
}

function afficherTrianglePascal($triangle) {
    $n = count($triangle);

    // Pour navigateur, on utilise du HTML
    echo "<pre>";  // préserve les espaces
    foreach ($triangle as $i => $ligne) {
        echo str_repeat(" ", ($n - $i) * 2);
        foreach ($ligne as $valeur) {
            echo $valeur . "   ";
        }
        echo "\n"; // retour à la ligne dans <pre> fonctionne
    }
    echo "</pre>";
}

$n = 6;
$triangle = calculerTrianglePascal($n);
afficherTrianglePascal($triangle);

?>

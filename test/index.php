<h1> Hello World</h1>


<?php

const UNE_CONSTANTE = "je suis une constante";
//defined("UNE_CONSTANTE", 'je suis toujours une constante');
    echo "Hello World!";
    //le typage existe et en voila l'exemple parfais
    $maVariable = "Je suis une chaine";
    $autreVariable = 10;

    $var = "0";


    ?>


<p> Lorem<?= UNE_CONSTANTE ?> ipsum dolor sit amet,<?= $maVariable ?> consectetur adipiscing elit, sed do eiusmod tempor</p>

<?php

echo $maVariable. $autreVariable;

var_dump($maVariable);
var_dump($autreVariable);

var_dump(isset($maVariable));
var_dump(isset($variableInexistant));

echo $variableInexistant;

var_dump(empty($maVariable));

unset($maVariable);

var_dump(isset($maVariable));

var_dump(defined('UNE_CONSTANTE'));

var_dump($var);
var_dump(isset($var));
var_dump(empty($var));

//est se qu'elle est vrai ou fausse
var_dump($var == false);
//est se qu'elle est vrai ou fausse et booléenne
var_dump($var === false);



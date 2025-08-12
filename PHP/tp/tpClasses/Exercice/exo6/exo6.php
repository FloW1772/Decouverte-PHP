<?php

// Inclusion de la classe Form de l'exercice 5
require_once 'Exercice5.php';

class Form2 extends Form
{
    public function setRadioButton($name, $value, $label)
    {
        $this->formCode .= "  <input type=\"radio\" name=\"$name\" value=\"$value\" id=\"$value\"> <label for=\"$value\">$label</label><br>\n";
    }

    public function setCheckbox($name, $value, $label)
    {
        $this->formCode .= "  <input type=\"checkbox\" name=\"$name\" value=\"$value\" id=\"$value\"> <label for=\"$value\">$label</label><br>\n";
    }
}

// Création d'un formulaire avancé
$monFormulaire2 = new Form2("traitement.php", "post");
$monFormulaire2->setText("prenom", "Votre prénom");
$monFormulaire2->setRadioButton("civilite", "homme", "Homme");
$monFormulaire2->setRadioButton("civilite", "femme", "Femme");
$monFormulaire2->setCheckbox("newsletter", "oui", "S'inscrire à la newsletter");
$monFormulaire2->setSubmit("S'inscrire");

// Affichage du code HTML
echo nl2br(htmlspecialchars($monFormulaire2->getForm()));

// Pour un affichage direct dans le navigateur :
// echo $monFormulaire2->getForm();

?>
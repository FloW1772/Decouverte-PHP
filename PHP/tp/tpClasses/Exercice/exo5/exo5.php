<?php

class Form
{
    protected $formCode;

    public function __construct($action, $method)
    {
        $this->formCode = "<form action=\"$action\" method=\"$method\">\n";
    }

    public function setText($name, $label)
    {
        $this->formCode .= "  <label for=\"$name\">$label :</label><br>\n";
        $this->formCode .= "  <input type=\"text\" name=\"$name\" id=\"$name\"><br><br>\n";
    }

    public function setSubmit($value)
    {
        $this->formCode .= "  <input type=\"submit\" value=\"$value\">\n";
    }

    public function getForm()
    {
        return $this->formCode . "</form>";
    }
}

// Création d'un formulaire
$monFormulaire = new Form("traitement.php", "post");
$monFormulaire->setText("nom", "Votre nom");
$monFormulaire->setText("email", "Votre email");
$monFormulaire->setSubmit("Envoyer");

// Affichage du code HTML du formulaire
echo nl2br(htmlspecialchars($monFormulaire->getForm()));

// Pour un affichage direct dans le navigateur :
// echo $monFormulaire->getForm();

?>
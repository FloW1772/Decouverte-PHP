<?php

abstract class Personne
{
    public $nom;
    public $prenom;

    public function __construct($nom, $prenom)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
    }
}

class Client extends Personne
{
    public $adresse;

    public function setCoord($adresse)
    {
        $this->adresse = $adresse;
    }

    public function __toString()
    {
        return "Client : " . $this->prenom . " " . $this->nom . "<br>Adresse : " . $this->adresse;
    }
}

class Electeur extends Personne
{
    public $bureau_de_vote;
    public $vote = false; // false = n'a pas voté, true = a voté

    public function setBureauDeVote($bureau)
    {
        $this->bureau_de_vote = $bureau;
    }

    public function aVote()
    {
        $this->vote = true;
        echo $this->prenom . " " . $this->nom . " a voté.<br>";
    }
}

// Création d'une instance de Client
$client = new Client("Dupont", "Jean");
$client->setCoord("15 rue de la Paix, 75002 Paris");
echo $client . "<br><br>";

// Création d'une instance d'Electeur
$electeur = new Electeur("Martin", "Sophie");
$electeur->setBureauDeVote("Bureau n°3, École primaire");
echo "Électeur : " . $electeur->prenom . " " . $electeur->nom . "<br>";
echo "Bureau de vote : " . $electeur->bureau_de_vote . "<br>";
$electeur->aVote();

?>
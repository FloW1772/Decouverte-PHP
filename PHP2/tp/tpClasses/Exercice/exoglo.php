<?php

// ===================================================================
// Exercice 1 : Classe représentant une ville sans constructeur
// ===================================================================
echo "<h1>Exercice 1</h1>";

class VilleEx1
{
    public $nom;
    public $departement;

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setDepartement($departement)
    {
        $this->departement = $departement;
    }

    public function afficher()
    {
        echo "La ville " . $this->nom . " est dans le département " . $this->departement . "<br>";
    }
}

// Créer des instances de Ville, affecter leurs propriétés et utiliser la méthode d’affichage.
$ville1 = new VilleEx1();
$ville1->setNom("Nantes");
$ville1->setDepartement("Loire-Atlantique");

$ville2 = new VilleEx1();
$ville2->setNom("Angers");
$ville2->setDepartement("Maine-et-Loire");

$ville1->afficher();
$ville2->afficher();

echo "<hr>";


// ===================================================================
// Exercice 2 : Classe représentant une ville avec un constructeur
// ===================================================================
echo "<h1>Exercice 2</h1>";

class VilleEx2
{
    public $nom;
    public $departement;

    public function __construct($nom, $departement)
    {
        $this->nom = $nom;
        $this->departement = $departement;
    }

    public function afficher()
    {
        echo "La ville " . $this->nom . " est dans le département " . $this->departement . "<br>";
    }
}

// Réaliser les mêmes opérations de création d’instances et d’affichage.
$ville3 = new VilleEx2("Lyon", "Rhône");
$ville4 = new VilleEx2("Marseille", "Bouches-du-Rhône");

$ville3->afficher();
$ville4->afficher();

echo "<hr>";


// ===================================================================
// Exercice 3 : Héritage avec VilleAvecRegion
// ===================================================================
echo "<h1>Exercice 3</h1>";

class VilleAvecRegion extends VilleEx1 // On hérite de la classe du premier exercice
{
    public $region;

    public function setRegion($region)
    {
        $this->region = $region;
    }

    // On surcharge la méthode afficher() pour inclure la région
    public function afficher()
    {
        echo "La ville " . $this->nom . " est dans le département " . $this->departement . " de la région " . $this->region . ".<br>";
    }
}

$villeRegion = new VilleAvecRegion();
$villeRegion->setNom("Bordeaux");
$villeRegion->setDepartement("Gironde");
$villeRegion->setRegion("Nouvelle-Aquitaine");
$villeRegion->afficher();

echo "<hr>";


// ===================================================================
// Exercice 4 : Connaître la ville ayant le nom le plus long
// ===================================================================
echo "<h1>Exercice 4</h1>";

class VilleAvecNomLong
{
    public $nom;
    public $departement;
    private static $villeAuNomLePlusLong = null;

    public function __construct($nom, $departement)
    {
        $this->nom = $nom;
        $this->departement = $departement;

        if (self::$villeAuNomLePlusLong === null || strlen($nom) > strlen(self::$villeAuNomLePlusLong->nom)) {
            self::$villeAuNomLePlusLong = $this;
        }
    }

    public function afficher()
    {
        echo "La ville " . $this->nom . " est dans le département " . $this->departement . ".<br>";
    }

    public static function getVilleAuNomLePlusLong()
    {
        return self::$villeAuNomLePlusLong;
    }
}

$v1 = new VilleAvecNomLong("Paris", "Paris");
$v2 = new VilleAvecNomLong("Saint-Remy-en-Bouzemont-Saint-Genest-et-Isson", "Marne");
$v3 = new VilleAvecNomLong("Montrevault-sur-Èvre", "Maine-et-Loire");
$v4 = new VilleAvecNomLong("Niederschaeffolsheim", "Bas-Rhin");


$villeLaPlusLongue = VilleAvecNomLong::getVilleAuNomLePlusLong();
echo "La ville ayant le nom le plus long est : " . $villeLaPlusLongue->nom . "<br>";

echo "<hr>";


// ===================================================================
// Exercice 5 : Classe Form pour formulaire HTML
// ===================================================================
echo "<h1>Exercice 5</h1>";

class Form
{
    protected $formCode = "";

    public function __construct($action, $method)
    {
        $this->formCode .= "<form action=\"$action\" method=\"$method\">\n";
    }

    public function setText($name, $label)
    {
        $this->formCode .= "  <p><label for=\"$name\">$label :</label><br>\n";
        $this->formCode .= "  <input type=\"text\" id=\"$name\" name=\"$name\"></p>\n";
    }

    public function setSubmit($value)
    {
        $this->formCode .= "  <p><input type=\"submit\" value=\"$value\"></p>\n";
    }

    public function getForm()
    {
        return $this->formCode . "</form>";
    }
}

// Créer des objets Form et y ajouter deux zones de texte et un bouton d’envoi.
$formulaire1 = new Form("traitement.php", "post");
$formulaire1->setText("nom", "Votre nom");
$formulaire1->setText("email", "Votre email");
$formulaire1->setSubmit("Envoyer");

// Tester l’affichage obtenu.
echo $formulaire1->getForm();

echo "<hr>";


// ===================================================================
// Exercice 6 : Sous-classe Form2 avec radios et checkboxes
// ===================================================================
echo "<h1>Exercice 6</h1>";

class Form2 extends Form
{
    public function setRadioButton($name, $value, $label)
    {
        $this->formCode .= "  <input type=\"radio\" id=\"$value\" name=\"$name\" value=\"$value\"> <label for=\"$value\">$label</label><br>\n";
    }

    public function setCheckbox($name, $value, $label)
    {
        $this->formCode .= "  <input type=\"checkbox\" id=\"$value\" name=\"$name\" value=\"$value\"> <label for=\"$value\">$label</label><br>\n";
    }
}

// Créer des objets et tester le résultat.
$formulaire2 = new Form2("traitement2.php", "post");
$formulaire2->setText("prenom", "Votre prénom");
$formulaire2->setRadioButton("civilite", "homme", "Homme");
$formulaire2->setRadioButton("civilite", "femme", "Femme");
$formulaire2->setCheckbox("conditions", "acceptees", "J'accepte les conditions");
$formulaire2->setSubmit("S'inscrire");

echo $formulaire2->getForm();

echo "<hr>";


// ===================================================================
// Exercice 7 : Classes abstraites Personne, Client et Electeur
// ===================================================================
echo "<h1>Exercice 7</h1>";

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
        return "Coordonnées du client : " . $this->prenom . " " . $this->nom . ", habitant à l'adresse : " . $this->adresse;
    }
}

class Electeur extends Personne
{
    public $bureau_de_vote;
    public $vote = false; // booléen, false = n'a pas voté

    public function setBureauDeVote($bureau)
    {
        $this->bureau_de_vote = $bureau;
    }

    public function aVote()
    {
        $this->vote = true;
    }
}

// Instance de Client
$client1 = new Client("Dupont", "Jean");
$client1->setCoord("123 Rue de la République, 75001 Paris");
echo $client1 . "<br>";

// Instance d'Electeur
$electeur1 = new Electeur("Martin", "Marie");
$electeur1->setBureauDeVote("Bureau n°5, Mairie du 10ème");

echo "L'électeur " . $electeur1->prenom . " " . $electeur1->nom . " est rattaché au " . $electeur1->bureau_de_vote . ".<br>";
echo "Statut du vote avant : " . ($electeur1->vote ? 'A voté' : 'N\'a pas encore voté') . "<br>";
$electeur1->aVote();
echo "Statut du vote après : " . ($electeur1->vote ? 'A voté' : 'N\'a pas encore voté') . "<br>";

echo "<hr>";

?>
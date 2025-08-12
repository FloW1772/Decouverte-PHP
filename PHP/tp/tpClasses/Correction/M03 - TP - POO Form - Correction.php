<?php


var_dump($_GET);
die;


//EXERCICE 1
class Ville {

    protected string $nom;
    protected string $departement;

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setDepartement(string $departement): void
    {
        $this->departement = $departement;
    }

    public function __toString(): string
    {
        return "La ville {$this->nom} est dans le département {$this->departement}.<br>";
    }
}

$ville = new Ville();

$ville->setNom("Lorient");
$ville->setDepartement("Morbihan");

echo $ville;

//EXERCICE 2

class Ville2 {

    private string $nom;
    private string $departement;

    private static ?string $villeNomLePlusLong = null ;

    public function __construct(string $nom,string $departement) {
        $this->nom = $nom;
        $this->departement = $departement;

        if (!static::$villeNomLePlusLong) {
            static::$villeNomLePlusLong = $nom;
        } else {
            if (mb_strlen(static::$villeNomLePlusLong) <= mb_strlen($nom)) {
                static::$villeNomLePlusLong = $nom;
            }
        }
    }

    public function __toString() {

        return "La ville {$this->nom} est dans le département {$this->departement}.<br>";
    }

    public static function getNomLePlusLong() {
        return static::$villeNomLePlusLong;
    }
}

$ville2 = new Ville2("Quimper","Finistère");
echo $ville2;
echo Ville2::getNomLePlusLong();


//EXERCICE 3

class VilleAvecRegion extends Ville {
    private string $region;


    public function setRegion(string $region) {
        $this->region = $region;
    }

    public function __toString(): string
    {
        return parent::__toString() . " et de la région {$this->region}.<br>";
    }

}

$villeAvecRegion = new VilleAvecRegion();

$villeAvecRegion->setNom("Paris");
$villeAvecRegion->setDepartement("Essonne");
$villeAvecRegion->setRegion("Iles de france");
echo $villeAvecRegion;


//EXERCICE 4

$quimper = new Ville2("Quimper","Finistère");
echo $quimper;

$reykjavik = new Ville2("Reykjavik","Island");
echo $reykjavik;
$marseille = new Ville2("Marseille","Rhône");
echo $marseille;
echo Ville2::getNomLePlusLong();


//EXERCICE 5


class Form {
    protected array $elements = [];
    protected string $submit = '';
    protected string $start;
    protected string $end;

    public function __construct() {
        $this->start = "<form><fieldset>";
        $this->end = "</fieldset></form>";
    }

    public function setText(string $name, string $libelle): void
    {
        $this->elements[$name] = "<label for='{$name}'>{$libelle}</label><input type='text' name='{$name}' id='{$name}' />";
    }

    public function setSubmit(): void
    {
        $this->submit = "<button type='submit'>Envoyer</button>";
    }

    public function getForm(): string
    {
        return $this->start . implode('', $this->elements) . $this->submit . $this->end;

    }
}

$form = new Form();
$form->setText("pseudo", "Pseudo" );
$form->setText("password", "Mot de passe");
$form->setSubmit();

echo $form->getForm();


//EXERCICE 6

class Form2 extends Form {

    private string $radio = '';
    private string $checkbox = '';

    public function setRadio(string $name, string $label, string $value) {

        $this->radio .= "<label>{$label} : </label> <input type='radio' name='{$name}' value='{$value}' />";
    }

    public function setCheckbox(string $content) {

        $this->checkbox .= "<label>{$content} : </label> <input type='checkbox' name='{$content}' />";
    }

    public function getForm2() {
        return $this->start . implode('', $this->elements) . $this->radio . $this->checkbox . $this->submit . $this->end;
    }
}
$form2 = new Form2();
$form2->setText('pseudo', "Pseudo");
$form2->setText('password', "Mot de passe");
$form2->setRadio("utilisation", "oui", 1);
$form2->setRadio("utilisation", "non", 0);
$form2->setCheckbox("Cookie?");
$form2->setSubmit();

echo $form2->getForm2();

// EXERCICE 7

abstract class Personne
{
    protected string $nom;
    protected string $prenom;

    public function __construct(string $nom, string $prenom)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
    }
}

class Client extends Personne {
    private string $adresse;


    public function setcoord(string $adresse) {

        $this->adresse = $adresse;

    }

    public function __toString() {

        return $this->nom . " " . $this->prenom . " " . $this->adresse;
    }
}
class Electeur extends Personne {

    private string $bureau_de_vote;
    private bool $aVote;

    public function vote(){
        $this->aVote = true;
    }
    public function __toString(): string
    {
        return "{$this->prenom} {$this->nom} " . ($this->aVote ? " a voté" : " n'a pas voté");
    }

}

$client = new Client('Rousseau', 'Jean-Jacques');
$client->setcoord('4 rue Soufflot 75005 Paris');

$electeur = new Electeur('Sand', 'George');
$electeur->vote();

echo $client;
echo "<br>";
echo $electeur;
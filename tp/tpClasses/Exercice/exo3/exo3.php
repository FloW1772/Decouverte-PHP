<?php

// Inclusion de la classe Ville de l'exercice 1
require_once 'Exercice1.php';

class VilleAvecRegion extends Ville
{
    public $region;

    /**
     * Définit la région de la ville.
     * @param string $region Le nom de la région.
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * Affiche une phrase décrivant la ville, son département et sa région.
     * @override
     */
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

?>
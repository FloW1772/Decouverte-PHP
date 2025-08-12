<?php

class Ville
{
    public $nom;
    public $departement;

    /**
     * Définit le nom de la ville.
     * @param string $nom Le nom de la ville.
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Définit le département de la ville.
     * @param string $departement Le nom du département.
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
    }

    /**
     * Affiche une phrase décrivant la ville et son département.
     */
    public function afficher()
    {
        echo "La ville " . $this->nom . " est dans le département " . $this->departement . ".<br>";
    }
}

// Création des instances de la classe Ville
$ville1 = new Ville();
$ville1->setNom("Nantes");
$ville1->setDepartement("Loire-Atlantique");

$ville2 = new Ville();
$ville2->setNom("Angers");
$ville2->setDepartement("Maine-et-Loire");

// Utilisation de la méthode d'affichage
$ville1->afficher();
$ville2->afficher();

?>
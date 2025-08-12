<?php

class VilleAvecConstructeur
{
    public $nom;
    public $departement;

    /**
     * Constructeur de la classe VilleAvecConstructeur.
     * @param string $nom Le nom de la ville.
     * @param string $departement Le nom du département.
     */
    public function __construct($nom, $departement)
    {
        $this->nom = $nom;
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

// Création des instances et affichage
$ville3 = new VilleAvecConstructeur("Lyon", "Rhône");
$ville3->afficher();

$ville4 = new VilleAvecConstructeur("Marseille", "Bouches-du-Rhône");
$ville4->afficher();

?>
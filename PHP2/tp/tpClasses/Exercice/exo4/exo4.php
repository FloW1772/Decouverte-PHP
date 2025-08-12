<?php

class VilleNomLePlusLong
{
    public $nom;
    public $departement;
    private static $nomLePlusLong = '';

    public function __construct($nom, $departement)
    {
        $this->nom = $nom;
        $this->departement = $departement;

        if (strlen($nom) > strlen(self::$nomLePlusLong)) {
            self::$nomLePlusLong = $nom;
        }
    }

    /**
     * Retourne le nom de la ville ayant le nom le plus long parmi toutes les instances créées.
     * @return string
     */
    public static function getNomLePlusLong()
    {
        return self::$nomLePlusLong;
    }
}

// Création de plusieurs instances
$villeA = new VilleNomLePlusLong("Paris", "Paris");
$villeB = new VilleNomLePlusLong("Saint-Remy-en-Bouzemont-Saint-Genest-et-Isson", "Marne");
$villeC = new VilleNomLePlusLong("Villeurbanne", "Rhône");

// Affichage de la ville avec le nom le plus long
echo "La ville avec le nom le plus long est : " . VilleNomLePlusLong::getNomLePlusLong() . ".<br>";

?>
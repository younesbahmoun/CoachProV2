<?php

class Produit {
    public $id;
    public $nom;
    public $prix;
    public $stock;
    public $dateAjout;
    
    /**
     * Constructeur simple
     */
    public function __construct($nom, $prix, $stock, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->stock = $stock;
    }
}
<?php
require_once 'config.php';
require_once 'Produit.php';

class ProduitDAO {
    private $pdo;
    
    /**
     * Constructeur - initialise la connexion
     */
    public function __construct() {
        $this->pdo = getConnection();
    }
    
    /**
     * CREATE - Ajouter un produit
     */
    public function ajouter(Produit $produit) {
        $sql = "INSERT INTO produits (nom, prix, stock) VALUES (?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $produit->nom,
            $produit->prix,
            $produit->stock
        ]);
    }
    
    /**
     * READ - Obtenir tous les produits
     */
    public function getTous() {
        $sql = "SELECT * FROM produits ORDER BY id DESC";
        
        $stmt = $this->pdo->query($sql);
        
        // Récupérer tous les résultats
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Convertir en objets Produit
        $produits = [];
        foreach ($resultats as $row) {
            $produit = new Produit(
                $row['nom'],
                $row['prix'],
                $row['stock'],
                $row['id']
            );
            $produit->dateAjout = $row['date_ajout'];
            $produits[] = $produit;
        }
        
        return $produits;
    }
    
    /**
     * READ - Obtenir un produit par ID
     */
    public function getParId($id) {
        $sql = "SELECT * FROM produits WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $produit = new Produit(
                $row['nom'],
                $row['prix'],
                $row['stock'],
                $row['id']
            );
            $produit->dateAjout = $row['date_ajout'];
            return $produit;
        }
        
        return null;
    }
    
    /**
     * READ - Rechercher des produits
     */
    public function rechercher($mot) {
        $sql = "SELECT * FROM produits WHERE nom LIKE ? ORDER BY nom";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['%' . $mot . '%']);
        
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $produits = [];
        foreach ($resultats as $row) {
            $produit = new Produit(
                $row['nom'],
                $row['prix'],
                $row['stock'],
                $row['id']
            );
            $produits[] = $produit;
        }
        
        return $produits;
    }
    
    /**
     * UPDATE - Modifier un produit
     */
    public function modifier(Produit $produit) {
        $sql = "UPDATE produits SET nom = ?, prix = ?, stock = ? WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $produit->nom,
            $produit->prix,
            $produit->stock,
            $produit->id
        ]);
    }
    
    /**
     * DELETE - Supprimer un produit
     */
    public function supprimer($id) {
        $sql = "DELETE FROM produits WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([$id]);
    }
    
    /**
     * Compter le nombre de produits
     */
    public function compter() {
        $sql = "SELECT COUNT(*) as total FROM produits";
        
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }
}
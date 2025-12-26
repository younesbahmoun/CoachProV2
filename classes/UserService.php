<?php
require_once __DIR__ . '../config/Database.php';

/**
 * Classe UserService
 * Gère la logique métier et l'interaction avec la base de données
 */
class UserService {
    private $conn;  // Connexion PDO
    
    /**
     * Constructeur
     * Récupère la connexion à la base de données
     */
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    /**
     * Valider les données du formulaire
     * @param array $data - Données POST du formulaire
     * @return array - Tableau des erreurs (vide si tout est OK)
     */
    public function valider($data) {
        $erreurs = [];
        
        // 1. Vérifier que tous les champs sont remplis
        if (empty($data['nom'])) {
            $erreurs[] = "Le nom est obligatoire";
        }
        
        if (empty($data['prenom'])) {
            $erreurs[] = "Le prénom est obligatoire";
        }
        
        if (empty($data['email'])) {
            $erreurs[] = "L'email est obligatoire";
        } else {
            // 2. Vérifier que l'email est valide
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $erreurs[] = "L'email n'est pas valide";
            } else {
                // 3. Vérifier que l'email n'existe pas déjà
                if ($this->emailExiste($data['email'])) {
                    $erreurs[] = "Cet email est déjà utilisé";
                }
            }
        }
        
        if (empty($data['password'])) {
            $erreurs[] = "Le mot de passe est obligatoire";
        } else {
            // 4. Vérifier que le mot de passe fait au moins 6 caractères
            if (strlen($data['password']) < 6) {
                $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères";
            }
        }
        
        if (empty($data['role'])) {
            $erreurs[] = "Le rôle est obligatoire";
        } else {
            // 5. Vérifier que le rôle est valide
            if (!in_array($data['role'], ['coach', 'sportif'])) {
                $erreurs[] = "Le rôle doit être 'coach' ou 'sportif'";
            }
        }
        
        return $erreurs;
    }
    
    /**
     * Vérifier si un email existe déjà dans la base
     * @param string $email
     * @return bool
     */
    private function emailExiste($email) {
        $query = "SELECT email FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Si on trouve un résultat, l'email existe
        return $stmt->rowCount() > 0;
    }
    
    /**
     * Insérer un utilisateur dans la base de données
     * @param Utilisateur $user
     * @return bool - true si succès, false si échec
     */
    public function inscrire(Utilisateur $user) {
        try {
            // Requête SQL préparée (sécurisée contre les injections SQL)
            $query = "INSERT INTO users (nom, prenom, email, password, role) 
                      VALUES (:nom, :prenom, :email, :password, :role)";
            
            // Préparer la requête
            $stmt = $this->conn->prepare($query);
            
            // Lier les paramètres (binding)
            $stmt->bindParam(':nom', $user->getNom());
            $stmt->bindParam(':prenom', $user->getPrenom());
            $stmt->bindParam(':email', $user->getEmail());
            $stmt->bindParam(':password', $user->getMotDePasse());  // Déjà hashé
            $stmt->bindParam(':role', $user->getRole());
            
            // Exécuter la requête
            if ($stmt->execute()) {
                return true;  // Succès
            }
            
            return false;  // Échec
            
        } catch(PDOException $e) {
            // En cas d'erreur, afficher le message (en production, utiliser error_log)
            echo "Erreur lors de l'inscription : " . $e->getMessage();
            return false;
        }
    }
}
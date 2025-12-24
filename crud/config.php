<?php
// Informations de connexion
define('DB_HOST', 'localhost');
define('DB_NAME', 'boutique');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Fonction pour obtenir une connexion PDO
 */
function getConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        
        // Mode d'erreur : exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $pdo;
        
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
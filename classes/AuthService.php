<?php
require_once __DIR__ . "/../config/database.php";
require_once "Utilisateur.php";

class AuthService extends Database
{
    public function create(Utilisateur $user): int
    {
        $pdo = $this->connect();

        $sql = "
            INSERT INTO users (nom, prenom, email, role, password_hash)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $user->getNom(),
            $user->getPrenom(),
            $user->getEmail(),
            $user->getRole(),
            password_hash($user->getMotDePasse(), PASSWORD_DEFAULT)
        ]);

        return (int) $pdo->lastInsertId();
    }

    public function findByEmail(string $email): ?array
    {
        $pdo = $this->connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}

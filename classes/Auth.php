<?php

class Auth
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function login(string $email, string $password): bool {
        $sql = "
            SELECT
                u.user_id,
                u.nom, u.prenom,
                u.email,
                u.password_hash,
                r.nom AS role
            FROM users u
            JOIN roles r ON r.role_id = u.role_id
            WHERE u.email = :email
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }

        $_SESSION['user'] = [
            'id' => $user['user_id'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        $this->db->prepare(
            "UPDATE users SET derniere_connexion = NOW() WHERE user_id = ?"
        )->execute([$user['user_id']]);

        return true;
    }

    public function logout(): void {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    public function isLogged(): bool
    {
        return isset($_SESSION['user']);
    }

    public function role(): ?string
    {
        return $_SESSION['user']['role'] ?? null;
    }
}
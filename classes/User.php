<?php

class User {
    public ?int $id;
    public string $nom;
    public string $prenom;
    public string $email;
    public string $password_hash;
    public ?string $adresse = null;
    public int $age;
    public string $phone;
    public string $date_inscription;
    public ?string $derniere_connexion = null;
    public int $role_id;

    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * Créer un utilisateur
     */
    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO users 
            (nom, prenom, email, password_hash, adresse, age, phone, role_id)
            VALUES 
            (:nom, :prenom, :email, :password_hash, :adresse, :age, :phone, :role_id)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'adresse' => $data['adresse'] ?? null,
            'age' => $data['age'],
            'phone' => $data['phone'],
            'role_id' => $data['role_id']
        ]);
    }

    /**
     * Trouver user par ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE user_id = ?"
        );
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    /**
     * Trouver user par email
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = ? LIMIT 1"
        );
        $stmt->execute([$email]);

        return $stmt->fetch() ?: null;
    }

    /**
     * Mettre à jour le profil
     */
    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE users SET
                nom = :nom,
                prenom = :prenom,
                adresse = :adresse,
                age = :age,
                phone = :phone
            WHERE user_id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'adresse' => $data['adresse'],
            'age' => $data['age'],
            'phone' => $data['phone'],
            'id' => $id
        ]);
    }

    /**
     * Supprimer user
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM users WHERE user_id = ?"
        );
        return $stmt->execute([$id]);
    }
}
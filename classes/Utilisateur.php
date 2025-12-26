<?php

class Utilisateur {
    protected ?int $id;
    protected string $email;
    protected string $motDePasse;
    protected string $nom;
    protected string $prenom;
    protected string $role; // 'coach' ou 'sportif'

    public function __construct(
        string $email,
        string $motDePasse,
        string $nom,
        string $prenom,
        string $role,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->motDePasse = password_hash($motDePasse, PASSWORD_BCRYPT);
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
    }

    public function getId(): ?int { return $this->id; }
    public function getEmail(): string { return $this->email; }
    public function getMotDePasse(): string { return $this->motDePasse; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getRole(): string { return $this->role; }

    public function setEmail(string $email): void { $this->email = $email; }
    public function setMotDePasse(string $motDePasse): void { $this->motDePasse = $motDePasse; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
    public function setRole(string $role): void { $this->role = $role; }
}

<?php

class Utilisateur
{
    // Propriétés privées
    private ?int $id;
    private string $email;
    private string $motDePasse;
    private string $nom;
    private string $prenom;
    private ?string $adresse;
    private int $age;
    private string $phone;
    private ?DateTime $dateInscription;
    private ?DateTime $derniereConnexion;
    private int $roleId;

    /**
     * Constructeur
     */
    public function __construct(
        string $email,
        string $motDePasse,
        string $nom,
        string $prenom,
        int $age,
        string $phone,
        int $roleId,
        ?int $id = null,
        ?string $adresse = null,
        ?DateTime $dateInscription = null,
        ?DateTime $derniereConnexion = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->age = $age;
        $this->phone = $phone;
        $this->roleId = $roleId;
        $this->adresse = $adresse;
        $this->dateInscription = $dateInscription ?? new DateTime();
        $this->derniereConnexion = $derniereConnexion;
    }

    // ========== GETTERS ==========

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getDateInscription(): ?DateTime
    {
        return $this->dateInscription;
    }

    public function getDerniereConnexion(): ?DateTime
    {
        return $this->derniereConnexion;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    // ========== SETTERS ==========

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setMotDePasse(string $motDePasse): void
    {
        $this->motDePasse = $motDePasse;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setAdresse(?string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setDateInscription(?DateTime $dateInscription): void
    {
        $this->dateInscription = $dateInscription;
    }

    public function setDerniereConnexion(?DateTime $derniereConnexion): void
    {
        $this->derniereConnexion = $derniereConnexion;
    }

    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }
}
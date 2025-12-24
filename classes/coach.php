<?php

require_once 'Utilisateur.php';

class Coach extends Utilisateur
{
    // Propriétés spécifiques au Coach
    private ?int $coachId;
    private string $niveau;
    private int $anneesExperience;
    private string $photo;
    private ?float $tarifHoraire;
    private float $noteMoyenne;
    private int $nombreAvis;

    public function __construct(
        // Paramètres de la classe parent Utilisateur
        string $email,
        string $motDePasse,
        string $nom,
        string $prenom,
        int $age,
        string $phone,
        int $roleId,
        // Paramètres spécifiques au Coach
        string $niveau = 'débutant',
        int $anneesExperience = 0,
        string $photo = 'default-coach.jpg',
        ?float $tarifHoraire = null,
        float $noteMoyenne = 0.00,
        int $nombreAvis = 0,
        // Paramètres optionnels
        ?int $id = null,
        ?int $coachId = null,
        ?string $adresse = null,
        ?DateTime $dateInscription = null,
        ?DateTime $derniereConnexion = null
    ) {
        // Appel du constructeur parent
        parent::__construct(
            $email,
            $motDePasse,
            $nom,
            $prenom,
            $age,
            $phone,
            $roleId,
            $id,
            $adresse,
            $dateInscription,
            $derniereConnexion
        );

        // Initialisation des propriétés spécifiques
        $this->coachId = $coachId;
        $this->niveau = $niveau;
        $this->anneesExperience = $anneesExperience;
        $this->photo = $photo;
        $this->tarifHoraire = $tarifHoraire;
        $this->noteMoyenne = $noteMoyenne;
        $this->nombreAvis = $nombreAvis;
    }

    // ========== GETTERS ==========

    public function getCoachId(): ?int
    {
        return $this->coachId;
    }

    public function getNiveau(): string
    {
        return $this->niveau;
    }

    public function getAnneesExperience(): int
    {
        return $this->anneesExperience;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getTarifHoraire(): ?float
    {
        return $this->tarifHoraire;
    }

    public function getNoteMoyenne(): float
    {
        return $this->noteMoyenne;
    }

    public function getNombreAvis(): int
    {
        return $this->nombreAvis;
    }

    // ========== SETTERS ==========

    public function setCoachId(?int $coachId): void
    {
        $this->coachId = $coachId;
    }

    public function setNiveau(string $niveau): void
    {
        // Validation des valeurs ENUM
        $niveauxValides = ['débutant', 'intermédiaire', 'avancé', 'expert', 'professionnel'];
        if (!in_array($niveau, $niveauxValides)) {
            throw new InvalidArgumentException("Niveau invalide");
        }
        $this->niveau = $niveau;
    }

    public function setAnneesExperience(int $anneesExperience): void
    {
        $this->anneesExperience = $anneesExperience;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    public function setTarifHoraire(?float $tarifHoraire): void
    {
        $this->tarifHoraire = $tarifHoraire;
    }

    public function setNoteMoyenne(float $noteMoyenne): void
    {
        $this->noteMoyenne = $noteMoyenne;
    }

    public function setNombreAvis(int $nombreAvis): void
    {
        $this->nombreAvis = $nombreAvis;
    }

    // ========== METHODES METIER ==========

    //Calcule et met a jour la note moyenne apres un nouvel avis
    public function ajouterAvis(float $nouvelleNote): void
    {
        $totalNotes = $this->noteMoyenne * $this->nombreAvis;
        $this->nombreAvis++;
        $this->noteMoyenne = round(($totalNotes + $nouvelleNote) / $this->nombreAvis, 2);
    }

    // Verifie si le coach est experimenté (5+ annees)
    public function estExperimente(): bool
    {
        return $this->anneesExperience >= 5;
    }
}
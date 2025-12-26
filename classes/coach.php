<?php

require_once "Utilisateur.php";

class Coach extends Utilisateur
{
    // 🔒 Propriétés spécifiques au coach
    private string $discipline;
    private int $experience;
    private string $description;

    // 🧱 Constructeur
    public function __construct(
        string $email,
        string $password,
        string $discipline,
        int $experience,
        string $description,
        int $id = 0
    ) {
        // Appel du constructeur parent
        parent::__construct($email, $password, $id);

        $this->discipline = $discipline;
        $this->experience = $experience;
        $this->description = $description;
    }

    // 🔎 Getters
    public function getDiscipline(): string
    {
        return $this->discipline;
    }

    public function getExperience(): int
    {
        return $this->experience;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    // ✏️ Setters
    public function setDiscipline(string $discipline): void
    {
        $this->discipline = $discipline;
    }

    public function setExperience(int $experience): void
    {
        $this->experience = $experience;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}

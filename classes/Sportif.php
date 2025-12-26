<?php

require_once "Utilisateur.php";

class Sportif extends Utilisateur
{
    // 🧱 Constructeur
    public function __construct(
        string $email,
        string $password,
        int $id = 0
    ) {
        parent::__construct($email, $password, $id);
    }
}
?>

<?php
// require_once "Utilisateur.php";

// class Sportif extends Utilisateur {
//     private string $niveau;

//     public function __construct(
//         string $email,
//         string $motDePasse,
//         string $nom,
//         string $prenom,
//         string $role,
//         string $niveau = "débutant",
//         ?int $id = null
//     ) {
//         parent::__construct($email, $motDePasse, $nom, $prenom, $role, $id);
//         $this->niveau = $niveau;
//     }

//     public function getNiveau(): string { return $this->niveau; }
//     public function setNiveau(string $niveau): void { $this->niveau = $niveau; }
// }
?>
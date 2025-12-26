<?php
require_once __DIR__ . "/../config/Database.php";

// class Seance
// {
//     private PDO $pdo;
//     private ?int $id;
//     private int $coachId;
//     private string $dateSeance;
//     private string $heure;
//     private int $duree; // en minutes
//     private string $statut;

//     /**
//      * Constructeur
//      */
//     public function __construct(
//         PDO $pdo,
//         int $coachId,
//         string $dateSeance,
//         string $heure,
//         int $duree,
//         string $statut = "disponible",
//         ?int $id = null
//     ) {
//         $this->pdo = $pdo;
//         $this->id = $id;
//         $this->coachId = $coachId;
//         $this->dateSeance = $dateSeance;
//         $this->heure = $heure;
//         $this->duree = $duree;
//         $this->statut = $statut;
//     }

//     // 🔎 Getters
//     public function getId(): ?int
//     {
//         return $this->id;
//     }

//     public function getCoachId(): int
//     {
//         return $this->coachId;
//     }

//     public function getDateSeance(): string
//     {
//         return $this->dateSeance;
//     }

//     public function getHeure(): string
//     {
//         return $this->heure;
//     }

//     public function getDuree(): int
//     {
//         return $this->duree;
//     }

//     public function getStatut(): string
//     {
//         return $this->statut;
//     }

//     // ✏️ Setters
//     public function setCoachId(int $coachId): void
//     {
//         $this->coachId = $coachId;
//     }

//     public function setDateSeance(string $dateSeance): void
//     {
//         $this->dateSeance = $dateSeance;
//     }

//     public function setHeure(string $heure): void
//     {
//         $this->heure = $heure;
//     }

//     public function setDuree(int $duree): void
//     {
//         $this->duree = $duree;
//     }

//     public function setStatut(string $statut): void
//     {
//         $this->statut = $statut;
//     }

//     // METHODE
//     public function creerSeance(array $data): bool {
//         $sql = "INSERT INTO seances
//                 (coach_id, date_seance, heure, duree, statut)
//                 VALUES
//                 (:coach_id, :date_seance, :heure, :duree, :statut)";

//         $stmt = $this->pdo->prepare($sql);

//         return $stmt->execute([
//             ":coach_id"    => $data["coach_id"],
//             ":date_seance" => $data["date_seance"],
//             ":heure"       => $data["heure"],
//             ":duree"       => $data["duree"],
//             ":statut"      => $data["statut"] ?? "disponible"
//         ]);
//     }

//     public function modifierSeance(array $data): bool {
//         $sql = "UPDATE seances
//                 (coach_id, date_seance, heure, duree, statut)
//                 VALUES
//                 (:coach_id, :date_seance, :heure, :duree, :statut)";

//         $stmt = $this->pdo->prepare($sql);

//         return $stmt->execute([
//             ":coach_id"    => $data["coach_id"],
//             ":date_seance" => $data["date_seance"],
//             ":heure"       => $data["heure"],
//             ":duree"       => $data["duree"],
//             ":statut"      => $data["statut"] ?? "disponible"
//         ]);
//     }

//     public function modifierSeances (int $id) {
//         $sql = "UPDATE seances 
//         SET date_seance date_seance
//         WHERE coach_id = :id
//         ";
//     }

//     public function supprimerSeance(int $id): bool {
//         $sql = "DELETE FROM seances 
//         WHERE id = :id";

//         $stmt = $this->pdo->prepare($sql);

//         return $stmt->execute([
//             ":id" => $id
//         ]);
//     }




//     public function suppSeances (int $id) {
//         $sql = "DELETE FROM seances
//         WHERE coach_id = :id";

//         $stmt = $this->pdo->prepare($sql);

//         return $stmt->execute([
//             ":id" => $id
//         ]);
//     }



// }

class Seance
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // public function creerSeance(array $data): int
    public function creerSeance(array $data)
    {
        $sql = "INSERT INTO seances (coach_id, date_seance, heure, duree, statut)
                VALUES (:coach_id, :date_seance, :heure, :duree, :statut)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":coach_id"    => $data["coach_id"],
            ":date_seance" => $data["date_seance"],
            ":heure"       => $data["heure"],
            ":duree"       => (int)$data["duree"],
            ":statut"      => $data["statut"] ?? "disponible"
        ]);

        // return (int)$this->pdo->lastInsertId(); // يرجع id ديال séance الجديدة
    }

    public function modifierSeance(int $id, array $data): bool
    {
        $sql = "UPDATE seances
                SET coach_id = :coach_id,
                    date_seance = :date_seance,
                    heure = :heure,
                    duree = :duree,
                    statut = :statut
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":coach_id"    => $data["coach_id"],
            ":date_seance" => $data["date_seance"],
            ":heure"       => $data["heure"],
            ":duree"       => (int)$data["duree"],
            ":statut"      => $data["statut"] ?? "disponible",
            ":id"          => $id
        ]);
    }

    public function supprimerSeance(int $id): bool
    {
        $sql = "DELETE FROM seances WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":id" => $id
        ]);
    }
}
<?php
class Calculatrice {
    public function additionner(int $a, int $b): int {
        return $a + $b;
    }
    
    public function soustraire(int $a, int $b): int {
        return $a - $b;
    }
    
    public function multiplier(float $a, float $b): float {
        return $a * $b;
    }
}

$calc = new Calculatrice();
echo $calc->additionner(5, 3); // 8
?>

<?php
class Utilisateur {
    private string $nom;
    private string $email;
    
    public function __construct(string $nom, string $email) {
        $this->nom = $nom;
        $this->email = $email;
        echo "Utilisateur créé : {$this->nom} {$this->email}\n";
    }
    
    public function getNom(): string {
        return $this->nom;
    }
}

$user = new Utilisateur("Marie", "marie@example.com");
// Affiche: Utilisateur créé : Marie
?>

<?php
class Produit {
    public function __construct(
        public string $nom,
        public float $prix,
        private int $stock = 0
    ) {}
    
    public function getStock(): int {
        return $this->stock;
    }
}

$produit = new Produit("Laptop", 999.99, 10);
echo $produit->nom; // Laptop
?>
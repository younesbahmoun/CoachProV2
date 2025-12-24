<?php
require_once 'ProduitDAO.php';

$dao = new ProduitDAO();
$erreurs = [];
$succes = false;

// Récupérer l'ID
$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// Charger le produit
$produit = $dao->getParId($id);

if (!$produit) {
    die("Produit introuvable");
}

// Traiter la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prix = $_POST['prix'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    
    // Validation
    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire";
    }
    if ($prix <= 0) {
        $erreurs[] = "Le prix doit être supérieur à 0";
    }
    if ($stock < 0) {
        $erreurs[] = "Le stock ne peut pas être négatif";
    }
    
    // Si pas d'erreurs, modifier
    if (empty($erreurs)) {
        $produit->nom = $nom;
        $produit->prix = $prix;
        $produit->stock = $stock;
        
        if ($dao->modifier($produit)) {
            $succes = true;
        } else {
            $erreurs[] = "Erreur lors de la modification";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un produit</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 { color: #333; margin-bottom: 20px; }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }
        .form-group { margin-bottom: 20px; }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }
        button, .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        button {
            background: #ffc107;
            color: #333;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Modifier le produit</h1>

        <?php if ($succes): ?>
            <div class="alert alert-success">
                ✅ Produit modifié avec succès !
            </div>
        <?php endif; ?>

        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-error">
                <?php foreach ($erreurs as $e): ?>
                    <div><?= htmlspecialchars($e) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $produit->id ?>">

            <div class="form-group">
                <label>Nom du produit *</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($produit->nom) ?>" required>
            </div>

            <div class="form-group">
                <label>Prix (€) *</label>
                <input type="number" name="prix" step="0.01" value="<?= $produit->prix ?>" required>
            </div>

            <div class="form-group">
                <label>Stock *</label>
                <input type="number" name="stock" value="<?= $produit->stock ?>" required>
            </div>

            <div class="buttons">
                <button type="submit">💾 Enregistrer</button>
                <a href="index.php" class="btn btn-secondary">↩️ Retour</a>
            </div>
        </form>
    </div>
</body>
</html>
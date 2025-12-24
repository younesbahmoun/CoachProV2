<?php
require_once 'ProduitDAO.php';

$erreurs = [];
$succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données
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
    
    // Si pas d'erreurs, ajouter le produit
    if (empty($erreurs)) {
        $dao = new ProduitDAO();
        $produit = new Produit($nom, $prix, $stock);
        
        if ($dao->ajouter($produit)) {
            $succes = true;
            // Réinitialiser le formulaire
            $nom = $prix = $stock = '';
        } else {
            $erreurs[] = "Erreur lors de l'ajout";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
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
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-group {
            margin-bottom: 20px;
        }
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
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }
        button, .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        button {
            background: #28a745;
            color: white;
        }
        button:hover {
            background: #218838;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Ajouter un produit</h1>

        <?php if ($succes): ?>
            <div class="alert alert-success">
                ✅ Produit ajouté avec succès !
            </div>
        <?php endif; ?>

        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-error">
                <strong>Erreurs :</strong>
                <ul>
                    <?php foreach ($erreurs as $erreur): ?>
                        <li><?= htmlspecialchars($erreur) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nom">Nom du produit *</label>
                <input type="text" 
                       id="nom" 
                       name="nom" 
                       value="<?= htmlspecialchars($nom ?? '') ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="prix">Prix (€) *</label>
                <input type="number" 
                       id="prix" 
                       name="prix" 
                       step="0.01" 
                       min="0"
                       value="<?= htmlspecialchars($prix ?? '') ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="stock">Stock *</label>
                <input type="number" 
                       id="stock" 
                       name="stock" 
                       min="0"
                       value="<?= htmlspecialchars($stock ?? '') ?>"
                       required>
            </div>

            <div class="buttons">
                <button type="submit">💾 Enregistrer</button>
                <a href="index.php" class="btn btn-secondary">↩️ Retour</a>
            </div>
        </form>
    </div>
</body>
</html>
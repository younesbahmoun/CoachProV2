<?php
require_once 'ProduitDAO.php';

$dao = new ProduitDAO();

// Gérer la recherche
$motRecherche = $_GET['recherche'] ?? '';
if ($motRecherche) {
    $produits = $dao->rechercher($motRecherche);
} else {
    $produits = $dao->getTous();
}

$total = $dao->compter();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .stats {
            color: #666;
            font-size: 14px;
        }
        .btn {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input {
            padding: 10px;
            width: 300px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .search-box button {
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            color: #333;
            font-weight: bold;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .btn-small {
            padding: 5px 12px;
            font-size: 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }
        .btn-edit {
            background: #ffc107;
        }
        .btn-delete {
            background: #dc3545;
        }
        .empty {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>📦 Gestion des Produits</h1>
                <p class="stats">Total : <?= $total ?> produit(s)</p>
            </div>
            <a href="ajouter.php" class="btn">➕ Ajouter un produit</a>
        </div>

        <!-- Formulaire de recherche -->
        <div class="search-box">
            <form method="GET">
                <input type="text" 
                    name="recherche" 
                    placeholder="Rechercher un produit..." 
                    value="<?= htmlspecialchars($motRecherche) ?>">
                <button type="submit">🔍 Rechercher</button>
                <?php if ($motRecherche): ?>
                    <a href="index.php" class="btn-small btn-edit">Réinitialiser</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Tableau des produits -->
        <?php if (count($produits) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Date d'ajout</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $p): ?>
                        <tr>
                            <td><?= $p->id ?></td>
                            <td><?= htmlspecialchars($p->nom) ?></td>
                            <td><?= number_format($p->prix, 2) ?> €</td>
                            <td><?= $p->stock ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($p->dateAjout)) ?></td>
                            <td>
                                <div class="actions">
                                    <a href="modifier.php?id=<?= $p->id ?>" class="btn-small btn-edit">✏️ Modifier</a>
                                    <a href="supprimer.php?id=<?= $p->id ?>" 
                                        class="btn-small btn-delete"
                                        onclick="return confirm('Confirmer la suppression ?')">
                                        🗑️ Supprimer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">
                <p>Aucun produit trouvé.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
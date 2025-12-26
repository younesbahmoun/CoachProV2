<?php
// Démarrer la session pour afficher les messages d'erreur/succès
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <!-- Bootstrap CSS pour un design simple -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="text-center mb-4">Inscription</h2>
        
        <?php
        // Afficher les messages d'erreur s'il y en a
        if (isset($_SESSION['erreurs']) && !empty($_SESSION['erreurs'])) {
            echo '<div class="alert alert-danger">';
            echo '<ul class="mb-0">';
            foreach ($_SESSION['erreurs'] as $erreur) {
                echo '<li>' . htmlspecialchars($erreur) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
            unset($_SESSION['erreurs']);  // Supprimer les erreurs après affichage
        }
        
        // Afficher le message de succès
        if (isset($_SESSION['succes'])) {
            echo '<div class="alert alert-success">';
            echo htmlspecialchars($_SESSION['succes']);
            echo '</div>';
            unset($_SESSION['succes']);
        }
        ?>
        
        <!-- Formulaire d'inscription -->
        <form action="../actions/register_post.php" method="POST">
            
            <!-- Nom -->
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" 
                       class="form-control" 
                       id="nom" 
                       name="nom" 
                       value="<?= isset($_SESSION['old']['nom']) ? htmlspecialchars($_SESSION['old']['nom']) : '' ?>"
                       required>
            </div>
            
            <!-- Prénom -->
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" 
                       class="form-control" 
                       id="prenom" 
                       name="prenom"
                       value="<?= isset($_SESSION['old']['prenom']) ? htmlspecialchars($_SESSION['old']['prenom']) : '' ?>"
                       required>
            </div>
            
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" 
                       class="form-control" 
                       id="email" 
                       name="email"
                       value="<?= isset($_SESSION['old']['email']) ? htmlspecialchars($_SESSION['old']['email']) : '' ?>"
                       required>
            </div>
            
            <!-- Mot de passe -->
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" 
                       class="form-control" 
                       id="password" 
                       name="password" 
                       required>
                <small class="text-muted">Minimum 6 caractères</small>
            </div>
            
            <!-- Rôle -->
            <div class="mb-3">
                <label class="form-label">Je suis un :</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" 
                               type="radio" 
                               name="role" 
                               id="sportif" 
                               value="sportif"
                               <?= (isset($_SESSION['old']['role']) && $_SESSION['old']['role'] === 'sportif') ? 'checked' : '' ?>
                               required>
                        <label class="form-check-label" for="sportif">Sportif</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" 
                               type="radio" 
                               name="role" 
                               id="coach" 
                               value="coach"
                               <?= (isset($_SESSION['old']['role']) && $_SESSION['old']['role'] === 'coach') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="coach">Coach</label>
                    </div>
                </div>
            </div>
            
            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </form>
        
        <!-- Lien vers la page de connexion (optionnel) -->
        <div class="text-center mt-3">
            <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
        </div>
    </div>
    
    <?php
    // Nettoyer les anciennes valeurs après affichage
    unset($_SESSION['old']);
    ?>
</body>
</html>
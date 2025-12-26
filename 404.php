<?php
/**
 * PAGE 404 PERSONNALISÉE
 * Fichier : 404.php
 * 
 * Cette page s'affiche quand un utilisateur demande une page qui n'existe pas
 */

// ÉTAPE 1 : Envoyer le code HTTP 404 au navigateur
// C'est TRÈS IMPORTANT pour le SEO et pour que les navigateurs comprennent qu'il y a une erreur
http_response_code(404);

// ÉTAPE 2 : Récupérer l'URL que l'utilisateur a demandée
// $_SERVER est un tableau qui contient plein d'informations sur la requête
$url_demandee = $_SERVER['REQUEST_URI'];

// ÉTAPE 3 : Récupérer d'autres informations utiles (optionnel, pour montrer)
$nom_serveur = $_SERVER['SERVER_NAME'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404 - Page introuvable</title>
    
    <style>
        /* Reset basique */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Style du body */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Conteneur principal */
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        /* Le grand 404 */
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #667eea;
            line-height: 1;
            margin-bottom: 20px;
        }

        /* Titre */
        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 15px;
        }

        /* Paragraphe */
        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* Zone pour afficher l'URL demandée */
        .url-box {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin: 25px 0;
            word-break: break-all;
            font-family: monospace;
            font-size: 14px;
            color: #333;
        }

        .url-label {
            font-weight: bold;
            color: #667eea;
            display: block;
            margin-bottom: 8px;
        }

        /* Barre de recherche */
        .search-form {
            margin: 30px 0;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: border-color 0.3s;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
        }

        /* Boutons */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #667eea;
            margin-top: 15px;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .error-code {
                font-size: 80px;
            }
            
            h1 {
                font-size: 22px;
            }
            
            .container {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Le code d'erreur 404 en gros -->
        <div class="error-code">404</div>
        
        <!-- Titre principal -->
        <h1>Oups ! Page introuvable</h1>
        
        <!-- Message explicatif -->
        <p>
            Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
        </p>
        
        <!-- Affichage de l'URL demandée de façon SÉCURISÉE -->
        <div class="url-box">
            <span class="url-label">URL demandée :</span>
            <?php 
            // htmlspecialchars() est ESSENTIEL pour la sécurité
            // Il empêche l'injection de code malveillant (XSS)
            echo htmlspecialchars($url_demandee); 
            ?>
        </div>
        
        <!-- Barre de recherche simple -->
        <form class="search-form" action="/recherche.php" method="GET">
            <input 
                type="text" 
                name="q" 
                class="search-input" 
                placeholder="Rechercher sur le site..." 
                required
            >
            <button type="submit" class="btn btn-primary">
                Rechercher
            </button>
        </form>
        
        <!-- Lien de retour à l'accueil -->
        <a href="/" class="btn btn-secondary">
            ← Retour à l'accueil
        </a>
    </div>
</body>
</html>
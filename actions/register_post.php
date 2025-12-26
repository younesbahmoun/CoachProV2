<?php
// Démarrer la session
session_start();

// Charger les classes nécessaires
require_once __DIR__ . '/../classes/Utilisateur.php';
require_once __DIR__ . '/../classes/UserService.php';

// Vérifier que la requête est bien POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/register.php');
    exit();
}

// Récupérer les données du formulaire
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

// Sauvegarder les anciennes valeurs pour les réafficher en cas d'erreur
$_SESSION['old'] = [
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'role' => $role
];

// Créer une instance du service utilisateur
$userService = new UserService();

// Valider les données
$erreurs = $userService->valider([
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'password' => $password,
    'role' => $role
]);

// Si des erreurs existent, rediriger vers le formulaire
if (!empty($erreurs)) {
    $_SESSION['erreurs'] = $erreurs;
    header('Location: ../pages/register.php');
    exit();
}

// Si tout est OK, créer l'objet Utilisateur
$utilisateur = new Utilisateur($nom, $prenom, $email, $password, $role);

// Tenter d'insérer l'utilisateur dans la base de données
if ($userService->inscrire($utilisateur)) {
    // Succès : supprimer les anciennes valeurs et afficher un message
    unset($_SESSION['old']);
    $_SESSION['succes'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    header('Location: ../pages/register.php');
    exit();
} else {
    // Échec : afficher une erreur
    $_SESSION['erreurs'] = ["Une erreur est survenue lors de l'inscription. Veuillez réessayer."];
    header('Location: ../pages/register.php');
    exit();
}
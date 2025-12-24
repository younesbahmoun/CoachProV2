<?php
require_once 'ProduitDAO.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $dao = new ProduitDAO();
    $dao->supprimer($id);
}

header('Location: index.php');
exit;
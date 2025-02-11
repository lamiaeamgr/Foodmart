<?php
session_start();
include('../Acces_BD/Models/Vendeur.php');
include('../Acces_BD/Models/Produit.php');
include('../Acces_BD/Models/Promotion.php');

// Ensure the user is logged in as a vendeur
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != 'vendeur') {
    header("Location: ../../IHM/Public/login.php");
    exit;
}

$action = $_GET['action'] ?? ''; // Capture the action from the URL

switch ($action) {
    case 'add_product':
        if (isset($_POST['reference'], $_POST['designation'], $_POST['prix'], $_POST['quantite_stock'], $_POST['categorie'], $_POST['date_peremption'], $_POST['promotion'], $_POST['image_path'])) {
            $reference = $_POST['reference'];
            $designation = $_POST['designation'];
            $prix = $_POST['prix'];
            $quantite_stock = $_POST['quantite_stock'];
            $categorie = $_POST['categorie'];
            $date_peremption = $_POST['date_peremption'];
            $promotion = $_POST['promotion'];
            $image_path = $_POST['image_path'];

            createProduit($reference, $designation, $prix, $quantite_stock, $categorie, $date_peremption, $promotion, $image_path);
            header("Location: ../../IHM/vendeur/products.php");
            exit;
        }
        break;

    case 'update_product':
        if (isset($_POST['id'], $_POST['reference'], $_POST['designation'], $_POST['prix'], $_POST['quantite_stock'], $_POST['categorie'], $_POST['date_peremption'], $_POST['promotion'], $_POST['image_path'])) {
            $id = $_POST['id'];
            $reference = $_POST['reference'];
            $designation = $_POST['designation'];
            $prix = $_POST['prix'];
            $quantite_stock = $_POST['quantite_stock'];
            $categorie = $_POST['categorie'];
            $date_peremption = $_POST['date_peremption'];
            $promotion = $_POST['promotion'];
            $image_path = $_POST['image_path'];

            updateProduit($id, $reference, $designation, $prix, $quantite_stock, $categorie, $date_peremption, $promotion, $image_path);
            header("Location: ../../IHM/vendeur/products.php");
            exit;
        }
        break;

    case 'delete_product':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            deleteProduit($id);
            header("Location: ../../IHM/vendeur/products.php");
            exit;
        }
        break;

    case 'add_promotion':
        if (isset($_POST['produit_id'], $_POST['reduction'], $_POST['date_debut'], $_POST['date_fin'])) {
            $produit_id = $_POST['produit_id'];
            $reduction = $_POST['reduction'];
            $date_debut = $_POST['date_debut'];
            $date_fin = $_POST['date_fin'];

            createPromotion($produit_id, $reduction, $date_debut, $date_fin);
            header("Location: ../../IHM/vendeur/promotions.php");
            exit;
        }
        break;

    default:
        header("Location: ../../IHM/vendeur/index.php");
        exit;
}
?>
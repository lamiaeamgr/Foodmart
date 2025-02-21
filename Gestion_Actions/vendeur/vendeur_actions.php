<?php
session_start();
include('../../Acces_BD/Models/Vendeur.php');
include('../../Acces_BD/Models/Produit.php');
include('../../Acces_BD/Models/Promotion.php');
include('../../Acces_BD/Models/Commande.php');

// Ensure the user is logged in as a vendeur
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != 'vendeur') {
    header("Location: ../../IHM/Public/login.php");
    exit;
}

$action = $_GET['action'] ?? ''; // Capture the action from the URL

switch ($action) {
    case 'add_product':
        // Check if all required fields are set, including the image upload
        if (isset($_POST['reference'], $_POST['designation'], $_POST['prix'], $_POST['quantite_stock'], $_POST['categorie'], $_POST['date_peremption'], $_POST['promotion'], $_FILES['image_upload'])) {

            // Get form data
            $reference = $_POST['reference'];
            $designation = $_POST['designation'];
            $prix = $_POST['prix'];
            $quantite_stock = $_POST['quantite_stock'];
            $categorie = $_POST['categorie'];
            $date_peremption = $_POST['date_peremption'];
            $promotion = $_POST['promotion'];

            // Handle file upload
            $uploadDir = '../../uploads/';
            $image_path = '';

            // Ensure the file is uploaded
            if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($_FILES['image_upload']['tmp_name']);

                if (in_array($fileType, $allowedTypes)) {
                    // Generate a unique name for the file
                    $filename = uniqid() . '_' . basename($_FILES['image_upload']['name']);
                    $targetPath = $uploadDir . $filename;

                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $targetPath)) {
                        $image_path = $targetPath; // Set the image path
                    } else {
                        echo "Erreur lors de l'upload du fichier.";
                        exit;
                    }
                } else {
                    echo "Erreur : Type de fichier non autorisé.";
                    exit;
                }
            } else {
                echo "Erreur : Aucun fichier n'a été téléchargé.";
                exit;
            }

            // Call createProduit function to store the product with the image path
            createProduit($reference, $designation, $prix, $quantite_stock, $categorie, $date_peremption, $promotion, $image_path);
            unset($_SESSION['list_products']);

            // Redirect to the products page
            header("Location: ../../IHM/vendeur/products.php");
            exit;
        } else {
            echo "Veuillez remplir tous les champs !";
        }

        break;
    case 'list_products':
        $products = listAllProduits();
        $_SESSION['list_products'] = $products;
        header("Location: ../../IHM/vendeur/products.php");
        break;
    case 'list_promotions':
        $promotions = listAllPromotions();
        $_SESSION['list_promotions'] = $promotions;
        header("Location: ../../IHM/vendeur/promotions.php");
        break;
    case 'list_orders':
        $orders = listAllCommandes();
        $_SESSION['list_orders'] = $orders;
        header("Location: ../../IHM/vendeur/orders.php");
        break;

    case 'update_product':

        // Validate required fields
        $requiredFields = [
            'id',
            'reference',
            'designation',
            'prix',
            'quantite_stock',
            'categorie',
            'date_peremption',
            'promotion'
        ];

        // Handle file upload
        $image_path = $_POST['existing_image'] ?? '';

        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../../uploads/';

            // Ensure tmp_name is not empty
            if (!empty($_FILES['image_upload']['tmp_name']) && file_exists($_FILES['image_upload']['tmp_name'])) {
                $fileType = mime_content_type($_FILES['image_upload']['tmp_name']);
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                // Validate MIME type
                if (in_array($fileType, $allowedTypes)) {
                    $filename = uniqid() . '_' . basename($_FILES['image_upload']['name']);
                    $targetPath = $uploadDir . $filename;

                    if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $targetPath)) {
                        $image_path = $targetPath;
                    }
                } else {
                    die("Erreur : Type de fichier non autorisé.");
                }
            } else {
                die("Erreur : Fichier non valide.");
            }
        }

        updateProduit(
            $_POST['id'],
            $_POST['reference'],
            $_POST['designation'],
            $_POST['prix'],
            $_POST['quantite_stock'],
            $_POST['categorie'],
            $_POST['date_peremption'],
            $_POST['promotion'],
            $image_path
        );

        // Clear old input on success
        unset($_SESSION['list_products']);
        header("Location: ../../IHM/vendeur/products.php");
        exit;

    // break;


    case 'delete_product':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            deleteProduit($id);
            unset($_SESSION['list_products']);
            header("Location: ../../IHM/vendeur/products.php");
            exit;
        }
        break;
    case 'delete_promotion':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            deletePromotion($id);
            unset($_SESSION['list_promotions']);
            header("Location: ../../IHM/vendeur/promotions.php");
            exit;
        }
        break;
    case 'get_product':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $_SESSION['product_to_edit'] = readProduit($id);
            var_dump($_SESSION['product_to_edit']);
            header("Location: ../../IHM/vendeur/edit_product.php");
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
            unset($_SESSION['list_promotions']);
            header("Location: ../../IHM/vendeur/promotions.php");
            exit;
        }
        break;

        case 'update_order_status':
            if (isset($_POST['commande_id'], $_POST['statut'])) {
                $commande_id = $_POST['commande_id'];
                $statut = $_POST['statut'];
    
                // Update the order status
                updateOrderStatus($commande_id, $statut);
    
                unset($_SESSION['list_orders']);
                // Redirect back to the orders page
                header("Location: ../../IHM/vendeur/orders.php");
                exit;
            }
            break;
    
    default:
        header("Location: ../../IHM/vendeur/index.php");
        exit;
}
?>
<?php
session_start();
include('../Acces_BD/Models/Client.php');
include('../Acces_BD/Models/Commande.php');
include('../Acces_BD/Models/Coupon.php');

// Ensure the user is logged in as a client
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != 'client') {
    header("Location: ../../IHM/Public/login.php");
    exit;
}

$action = $_GET['action'] ?? ''; // Capture the action from the URL

switch ($action) {
    case 'add_order':
        if (isset($_POST['produit_id'], $_POST['quantite'], $_POST['date_livraison'], $_POST['type_livraison'])) {
            $email = $_SESSION['email'];
            $product_id = $_POST['produit_id'];
            $quantity = $_POST['quantite'];
            $delivery_date = $_POST['date_livraison'];
            $delivery_type = $_POST['type_livraison'];

            $user_id = getUserIdByEmail($email); // Function to get user ID
            if ($user_id) {
                insertOrder($user_id, $product_id, $quantity, $delivery_date, $delivery_type);
                header("Location: ../../IHM/acheteur/orders.php");
                exit;
            } else {
                echo "User not found!";
            }
        }
        break;

    case 'update_order':
        if (isset($_POST['order_id'], $_POST['status'])) {
            $order_id = $_POST['order_id'];
            $status = $_POST['status'];
            updateOrderStatus($order_id, $status);
            header("Location: ../../IHM/acheteur/orders.php");
            exit;
        }
        break;

    case 'delete_order':
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
            deleteOrder($order_id);
            header("Location: ../../IHM/acheteur/orders.php");
            exit;
        }
        break;

    case 'use_coupon':
        if (isset($_POST['coupon_id'])) {
            $coupon_id = $_POST['coupon_id'];
            useCoupon($coupon_id);
            header("Location: ../../IHM/acheteur/cart.php");
            exit;
        }
        break;

    default:
        header("Location: ../../IHM/acheteur/index.php");
        exit;
}
?>
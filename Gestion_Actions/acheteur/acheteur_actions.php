<?php
// Include model files so that the model functions are available here
include('../../Acces_BD/Models/Client.php');
include('../../Acces_BD/Models/Commande.php');
include('../../Acces_BD/Models/Coupon.php');
session_start();

// Ensure the user is logged in as a client
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != 'client') {
    var_dump($_SESSION);
    // header("Location: ../../IHM/Public/login.php");
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'view_coupons':
        // Call the model function to fetch coupons for the client
        $coupons = listAllCouponsForClient($_SESSION['user_id']);
        // Store coupons in the session to be used by the IHM
        $_SESSION['coupons'] = $coupons;
        // Redirect to the IHM coupons page
        header("Location: ../../IHM/acheteur/coupons.php");
        exit;
    case 'view_profile':
        // Use the model function to fetch client details
        $client = getClientById($_SESSION['user_id']);
        // Store the client details in the session
        $_SESSION['client'] = $client;
        // Redirect to the IHM profile page
        header("Location: ../../IHM/acheteur/profile.php");
        exit;
    case 'view_orders':
        $client_id = $_SESSION['user_id'];
        $orders = listAllOrdersForClient($client_id);
        $_SESSION['orders'] = $orders; // Store orders in session for IHM to display
        header("Location: ../../IHM/acheteur/orders.php");
        exit;
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

    case 'update_profile':{
        // Check that all required POST fields are set.
        if (isset($_POST['nom'], $_POST['email'], $_POST['telephone'], $_POST['adresse'])) {
            $client_id = $_SESSION['user_id'];

            // Retrieve the existing client data to preserve fields that are not being updated (e.g., points)
            $existingClient = getClientById($client_id);
            if (!$existingClient) {
                echo "Client not found.";
                exit;
            }

            // Collect the updated profile data from the form
            $nom = trim($_POST['nom']);
            $email = trim($_POST['email']);
            $mot_de_passe = trim($_POST['mot_de_passe']);
            $telephone = trim($_POST['telephone']);
            $adresse = trim($_POST['adresse']);

            // Preserve the existing points
            $points = $existingClient['points'];
            var_dump($client_id, $nom, $email, $mot_de_passe, $telephone, $adresse, $points);

            // Call the updateClient() function defined in your model to update the database.
            $updateResult = updateClient($client_id, $nom, $email, $mot_de_passe, $telephone, $adresse, $points);

            if ($updateResult > 0) {
                // Update was successful: update the session client details
                $_SESSION['client'] = getClientById($client_id);
                // Optionally pass a success flag via query string
                header("Location: ../../IHM/acheteur/profile.php?status=success");
                exit;
            } else {
                // No rows updated or an error occurred; redirect back to the edit page with an error flag.
                header("Location: ../../IHM/acheteur/edit_profile.php?status=error");
                exit;
            }
        } else {
            // If required fields are missing, redirect back with a missing data flag.
            header("Location: ../../IHM/acheteur/edit_profile.php?status=missing");
            exit;
        }
    }

    default:
        header("Location: ../../IHM/acheteur/index.php");
        exit;
}
?>
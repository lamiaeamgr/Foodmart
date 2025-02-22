<?php
// Include model files so that the model functions are available here
include('../../Acces_BD/Models/Client.php');
include('../../Acces_BD/Models/Commande.php');
include('../../Acces_BD/Models/Produit.php');
include('../../Acces_BD/Models/Coupon.php');
include('../../Acces_BD/Models/Cart.php'); // Assuming the Cart model is implemented
session_start();

// Ensure the user is logged in as a client
if (!isset($_SESSION['email']) ) {
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
        $client = readClient($_SESSION['user_id'], $_SESSION['user_type']);
        // Store the client details in the session
        $_SESSION['client'] = $client;
        // Redirect to the IHM profile page
        header("Location: ../../IHM/acheteur/profile.php");
        exit;
    case 'view_points':
        // Use the model function to fetch client details
        $client = readClient($_SESSION['user_id'], $_SESSION['user_type']);
        // Store the client details in the session
        $_SESSION['client'] = $client;
        // Redirect to the IHM profile page
        header("Location: ../../IHM/acheteur/coupons.php");
        exit;

    case 'view_orders':
        $client_id = $_SESSION['user_id'];
        $orders = listAllOrdersForClient($client_id);
        $_SESSION['orders'] = $orders; // Store orders in session for IHM to display
        header("Location: ../../IHM/acheteur/orders.php");
        exit;

        case 'add_order':
            if (isset($_POST['produit_id'], $_POST['quantite'], $_POST['date_livraison'], $_POST['type_livraison'])) {
                $product_ids = $_POST['produit_id']; // Array of product IDs
                $quantities = $_POST['quantite'];   // Array of quantities
                $prices = $_POST['prices'];        // Array of prices
                $delivery_date = $_POST['date_livraison'];
                $delivery_type = $_POST['type_livraison'];
                $total = array_sum($prices);       // Calculate total order amount
                $user_id = $_SESSION['user_id'];
        
                // Check if a coupon is applied
                if (isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])) {
                    $coupon_code = $_POST['coupon_code'];
                    $coupon = getCouponByCode($coupon_code);         
                    if ($coupon && $coupon['client_id'] == $user_id && $coupon['date_expiration'] > date('Y-m-d')) {
                        // Apply coupon discount
                        if ($coupon['type'] == 'montant') {
                            $total -= $coupon['valeur']; // Deduct fixed amount
                        } elseif ($coupon['type'] == 'pourcentage') {
                            $total *= (1 - $coupon['valeur'] / 100); // Deduct percentage
                        }
        
                        // Mark the coupon as used
                        useCoupon($coupon['id']);
                    } else {
                        // Invalid or expired coupon
                        $_SESSION['error'] = "Coupon invalide ou expiré.";
                        header("Location: ../../IHM/acheteur/cart.php");
                        exit;
                    }
                }
        
                // Create the order
                $commande_id = createCommande(
                    client_id: $user_id,
                    date_commande: date('Y-m-d'),
                    statut: 'En attente',
                    total: $total,
                    type_livraison: $delivery_type,
                    date_livraison: $delivery_date
                );
        
                if ($commande_id) {
                    // Add items to the order
                    foreach ($product_ids as $index => $product_id) {
                        addDetailCommande($commande_id, $product_id, $quantities[$index], $prices[$index]);
                    }
        
                    // Clear the cart
                    unset($_SESSION['cart']);
                    unset($_SESSION['list_orders_clt']);
                    foreach ($product_ids as $product_id) {
                        deleteCart($product_id);
                    }
        
                    // Award loyalty points (e.g., 1 point for every 10 DH spent)
                    $points_earned = floor($total / 10); // Adjust the ratio as needed
                    updateClientPoints($user_id, $points_earned);
        
                    // Redirect to the orders page
                    header("Location: ../../IHM/acheteur/orders.php");
                    exit;
                } else {
                    echo "Failed to create order!";
                }
            }
            break;
        case 'list_orders_clt':
            $client_id = $_SESSION['user_id'];
            $orders = listAllCommandesForClient($client_id);
            $_SESSION['list_orders_clt'] = $orders;
            header("Location: ../../IHM/acheteur/orders.php");
            exit;
    
       
        case 'remove_from_cart':
            if (isset($_GET['product_id'])) {
                $produit_id = $_GET['product_id']; // This is actually the product ID
                deleteCart($produit_id);

                if (isset($_GET['product_id'])) {
                    $produit_id = $_GET['product_id']; // This is the product ID to remove
            
                    foreach ($_SESSION['cart'] as $index => $item) {
                        if ($item['produit_id'] == $produit_id) {
                            unset($_SESSION['cart'][$index]);
                            break; 
                        }
                    }
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                    header("Location: ../../IHM/acheteur/cart.php");
            }
            break;
        }
        case 'update_cart_quantity':
            if (isset($_POST['product_id'], $_POST['quantity'])) {
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];
        
                // Update the quantity in the cart
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] == $product_id) {
                        $item['quantite'] = $quantity;
                        break;
                    }
                }
                // header("Location: ../../IHM/acheteur/cart.php");
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
    
    case 'list_products':
        $products = listAllProduits();
        $_SESSION['list_products'] = $products;
        header("Location: ../../IHM/acheteur/index.php");
        break;

    // Handle the add to cart action
    case 'add_to_cart':
        if (isset($_POST['produit_id'], $_POST['quantite'])) {
            $produit_id = $_POST['produit_id'];
            $quantite = $_POST['quantite'];
            $client_id = $_SESSION['user_id'];

            // Call the add to cart function from the Cart model
            $result = addToCart($client_id, $produit_id, $quantite);

            if ($result > 0) {
                // Redirect to the cart page after successfully adding the item
                $_SESSION['cart']= listAllCartsForClient($_SESSION['user_id']);
                header("Location: ../../IHM/acheteur/cart.php");
                exit;
            } else {
                // If there was an issue adding to the cart, maybe redirect with an error message
                header("Location: ../../IHM/acheteur/index.php?status=error");
                exit;
            }
        }
        break;

    case 'update_profile':
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
        case 'exchange_points':
            if (isset($_POST['points'])) {
                $points = $_POST['points'];
                $user_id = $_SESSION['user_id'];
        
                // Fetch client's current points
                $client = getClientById($user_id);
                if ($client['points'] >= $points) {
                    // Deduct points
                    updateClientPoints($user_id, -$points);
        
                    // Create a coupon (e.g., 100 points = 20 DH coupon)
                    $coupon_value = floor($points / 100) * 20;
                    $coupon_code = generateCouponCode(); // Implement this function
                    createCoupon($user_id, $coupon_code, $coupon_value, 'montant',$points, date('Y-m-d', strtotime('+30 days')));
        
                    $_SESSION['success'] = "Coupon généré avec succès!";
                } else {
                    $_SESSION['error'] = "Points insuffisants.";
                }
                unset($_SESSION['client']);
                unset($_SESSION['coupons']);
                header("Location: ../../IHM/acheteur/coupons.php");
                exit;
            }
            break;
    default:
        header("Location: ../../IHM/acheteur/index.php");
        exit;
}
?>

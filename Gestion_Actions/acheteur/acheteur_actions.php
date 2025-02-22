<?php
include('../../Acces_BD/Models/Client.php');
include('../../Acces_BD/Models/Commande.php');
include('../../Acces_BD/Models/Produit.php');
include('../../Acces_BD/Models/Coupon.php');
include('../../Acces_BD/Models/Cart.php'); 
session_start();



$action = $_GET['action'] ?? '';

switch ($action) {
    case 'view_coupons':
        $coupons = listAllCouponsForClient($_SESSION['user_id']);
        $_SESSION['coupons'] = $coupons;
        header("Location: ../../IHM/acheteur/coupons.php");
        exit;
        
    case 'view_profile':
        $client = readClient($_SESSION['user_id'], $_SESSION['user_type']);
        $_SESSION['client'] = $client;
        header("Location: ../../IHM/acheteur/profile.php");
        exit;
    case 'view_points':
        $client = readClient($_SESSION['user_id'], $_SESSION['user_type']);
        $_SESSION['client'] = $client;
        header("Location: ../../IHM/acheteur/coupons.php");
        exit;

    case 'view_orders':
        $client_id = $_SESSION['user_id'];
        $orders = listAllOrdersForClient($client_id);
        $_SESSION['orders'] = $orders; 
        header("Location: ../../IHM/acheteur/orders.php");
        exit;

        case 'add_order':
            if (isset($_POST['produit_id'], $_POST['quantite'], $_POST['date_livraison'], $_POST['type_livraison'])) {
                $product_ids = $_POST['produit_id']; 
                $quantities = $_POST['quantite'];   
                $prices = $_POST['prices'];        
                $delivery_date = $_POST['date_livraison'];
                $delivery_type = $_POST['type_livraison'];
                $total = array_sum($prices);       
                $user_id = $_SESSION['user_id'];
        
                if (isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])) {
                    $coupon_code = $_POST['coupon_code'];
                    $coupon = getCouponByCode($coupon_code);         
                    if ($coupon && $coupon['client_id'] == $user_id && $coupon['date_expiration'] > date('Y-m-d')) {
                        if ($coupon['type'] == 'montant') {
                            $total -= $coupon['valeur'];
                        } elseif ($coupon['type'] == 'pourcentage') {
                            $total *= (1 - $coupon['valeur'] / 100); 
                        }
        
                        useCoupon($coupon['id']);
                    } else {
                        $_SESSION['error'] = "Coupon invalide ou expiré.";
                        header("Location: ../../IHM/acheteur/cart.php");
                        exit;
                    }
                }
        
                $commande_id = createCommande(
                    client_id: $user_id,
                    date_commande: date('Y-m-d'),
                    statut: 'En attente',
                    total: $total,
                    type_livraison: $delivery_type,
                    date_livraison: $delivery_date
                );
        
                if ($commande_id) {
                    foreach ($product_ids as $index => $product_id) {
                        addDetailCommande($commande_id, $product_id, $quantities[$index], $prices[$index]);
                    }
        
                    unset($_SESSION['cart']);
                    unset($_SESSION['list_orders_clt']);
                    foreach ($product_ids as $product_id) {
                        deleteCart($product_id);
                    }
        
                    $points_earned = floor($total / 10); 
                    updateClientPoints($user_id, $points_earned);
        
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
                $produit_id = $_GET['product_id']; 
                deleteCart($produit_id);

                if (isset($_GET['product_id'])) {
                    $produit_id = $_GET['product_id']; 
            
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
        
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] == $product_id) {
                        $item['quantite'] = $quantity;
                        break;
                    }
                }
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

    case 'add_to_cart':
        if (isset($_POST['produit_id'], $_POST['quantite'])) {
            $produit_id = $_POST['produit_id'];
            $quantite = $_POST['quantite'];
            $client_id = $_SESSION['user_id'];

            $result = addToCart($client_id, $produit_id, $quantite);

            if ($result > 0) {
                $_SESSION['cart']= listAllCartsForClient($_SESSION['user_id']);
                header("Location: ../../IHM/acheteur/cart.php");
                exit;
            } else {
                header("Location: ../../IHM/acheteur/index.php?status=error");
                exit;
            }
        }
        break;

    case 'update_profile':
        if (isset($_POST['nom'], $_POST['email'], $_POST['telephone'], $_POST['adresse'])) {
            $client_id = $_SESSION['user_id'];

            $existingClient = getClientById($client_id);
            if (!$existingClient) {
                echo "Client not found.";
                exit;
            }

            $nom = trim($_POST['nom']);
            $email = trim($_POST['email']);
            $mot_de_passe = trim($_POST['mot_de_passe']);
            $telephone = trim($_POST['telephone']);
            $adresse = trim($_POST['adresse']);

            $points = $existingClient['points'];

            $updateResult = updateClient($client_id, $nom, $email, $mot_de_passe, $telephone, $adresse, $points);

            if ($updateResult > 0) {
                $_SESSION['client'] = getClientById($client_id);
                header("Location: ../../IHM/acheteur/profile.php?status=success");
                exit;
            } else {
                header("Location: ../../IHM/acheteur/edit_profile.php?status=error");
                exit;
            }
        } else {
            header("Location: ../../IHM/acheteur/edit_profile.php?status=missing");
            exit;
        }
        case 'exchange_points':
            if (isset($_POST['points'])) {
                $points = $_POST['points'];
                $user_id = $_SESSION['user_id'];
        
                $client = getClientById($user_id);
                if ($client['points'] >= $points) {
                    updateClientPoints($user_id, -$points);
        
                    $coupon_value = floor($points / 100) * 20;
                    $coupon_code = generateCouponCode(); 
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

<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

$order_id = $_GET['id'] ?? '';
if (!$order_id) {
    header("Location: orders.php");
    exit;
}

// Fetch order details
$order = getOrderDetails($order_id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Commande</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Détails de la Commande #<?= $order_id; ?></h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Date de Commande:</strong> <?= $order['date_commande']; ?></p>
                <p><strong>Statut:</strong> <?= $order['statut']; ?></p>
                <p><strong>Total:</strong> <?= $order['total']; ?> DH</p>
                <h3>Produits:</h3>
                <ul>
                    <?php
                    foreach ($order['produits'] as $produit) {
                        echo "<li>{$produit['designation']} - {$produit['quantite']} x {$produit['prix_unitaire']} DH</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <a href="orders.php" class="btn btn-primary mt-3">Retour</a>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != 'vendeur') {
    header("Location: ../Public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Commandes</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Commande</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch orders from the database
                $orders = listAllOrders();
                foreach ($orders as $order) {
                    echo "<tr>
                            <td>{$order['id']}</td>
                            <td>{$order['client_id']}</td>
                            <td>{$order['date_commande']}</td>
                            <td>{$order['statut']}</td>
                            <td>{$order['total']} DH</td>
                            <td>
                                <a href='order_details.php?id={$order['id']}' class='btn btn-info btn-sm'>Détails</a>
                                <a href='Gestion_Actions/vendeur/vendeur_actions.php?action=update_order_status&id={$order['id']}' class='btn btn-success btn-sm'>Mettre à Jour</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
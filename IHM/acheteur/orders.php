<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

// Retrieve orders from the session that were set by the gestion_actions file
$orders = isset($_SESSION['orders']) ? $_SESSION['orders'] : [];

// Optionally, clear the session variable if you don't need it anymore
// unset($_SESSION['orders']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Commandes</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>

<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Mes Commandes</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Commande</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($orders)) {
                    echo "<tr><td colspan='5' class='text-center'>Aucune commande trouvée.</td></tr>";
                } else {
                    foreach ($orders as $order) {
                        echo "<tr>
                                <td>{$order['id']}</td>
                                <td>{$order['date_commande']}</td>
                                <td>{$order['statut']}</td>
                                <td>{$order['total']} DH</td>
                                <td>
                                    <a href='order_details.php?id={$order['id']}' class='btn btn-info btn-sm'>Détails</a>
                                    <a href='Gestion_Actions/acheteur/acheteur_actions.php?action=delete_order&order_id={$order['id']}' class='btn btn-danger btn-sm'>Supprimer</a>
                                </td>
                              </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>

</html>
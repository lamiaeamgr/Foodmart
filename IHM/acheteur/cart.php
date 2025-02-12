<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/style.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>

<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Mon Panier</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch cart items from the session or database
                $cart = $_SESSION['cart'] ?? [];
                foreach ($cart as $item) { ?>
                    <tr>
                        <td><?= $item['designation'] ?></td>
                        <td><?= $item['quantite'] ?></td>
                        <td><?= $item['prix'] ?> DH</td>
                        <td><?= $item['quantite'] * $item['prix'] ?> DH</td>
                        <td>
                            <a href='Gestion_Actions/acheteur/acheteur_actions.php?action=remove_from_cart&product_id={<?= $item['id'] ?>'
                                class='btn btn-danger btn-sm'>Supprimer</a>
                        </td>
                    </tr>
                    <?php ;
                }
                ?>
            </tbody>
        </table>
        <a href="../../Gestion_Actions/acheteur/acheteur_actions.php?action=checkout" class="btn btn-success">Passer la
            Commande</a>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>

</html>
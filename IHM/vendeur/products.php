<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit;
}
$products = isset($_SESSION['list_products']) ? $_SESSION['list_products'] : null;

if (!$products) {
    header("Location: ../../Gestion_Actions/vendeur/vendeur_actions.php?action=list_products");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>

<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Gestion des Produits</h1>
        <a href="add_product.php" class="btn btn-primary mb-3">Ajouter un Produit</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Référence</th>
                    <th>Désignation</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch products from the database
                foreach ($products as $product) {
                    echo "<tr>
                            <td>{$product['id']}</td>
                            <td>{$product['reference']}</td>
                            <td>{$product['designation']}</td>
                            <td>{$product['prix']} DH</td>
                            <td>{$product['quantite_stock']}</td>
                            <td>
                                <a href='edit_product.php?id={$product['id']}' class='btn btn-info btn-sm'>Modifier</a>
                                <a href='../../Gestion_Actions/vendeur/vendeur_actions.php?action=delete_product&id={$product['id']}' class='btn btn-danger btn-sm'>Supprimer</a>
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
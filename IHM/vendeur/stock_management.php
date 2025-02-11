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
    <title>Gestion des Stocks</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Gestion des Stocks</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Produit</th>
                    <th>Désignation</th>
                    <th>Quantité en Stock</th>
                    <th>Date de Péremption</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch products from the database
                $products = listAllProduits();
                foreach ($products as $product) {
                    echo "<tr>
                            <td>{$product['id']}</td>
                            <td>{$product['designation']}</td>
                            <td>{$product['quantite_stock']}</td>
                            <td>{$product['date_peremption']}</td>
                            <td>
                                <a href='edit_stock.php?id={$product['id']}' class='btn btn-info btn-sm'>Modifier</a>
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
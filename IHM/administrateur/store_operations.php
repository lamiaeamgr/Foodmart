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
    <title>Opérations du Magasin</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Opérations du Magasin</h1>
        <div class="row">
            <div class="col-md-6">
                <a href="stock_management.php" class="btn btn-primary btn-block">Gestion des Stocks</a>
            </div>
            <div class="col-md-6">
                <a href="sales_operations.php" class="btn btn-success btn-block">Opérations de Vente</a>
            </div>
        </div>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
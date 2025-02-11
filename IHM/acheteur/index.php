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
    <title>Accueil Acheteur</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Bienvenue, <?= $_SESSION['email']; ?></h1>
        <div class="row">
            <div class="col-md-4">
                <a href="orders.php" class="btn btn-primary btn-block">Mes Commandes</a>
            </div>
            <div class="col-md-4">
                <a href="cart.php" class="btn btn-success btn-block">Mon Panier</a>
            </div>
            <div class="col-md-4">
                <a href="coupons.php" class="btn btn-info btn-block">Mes Coupons</a>
            </div>
        </div>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
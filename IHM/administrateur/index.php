<?php
session_start();
if (!isset($_SESSION['email']) ) {
    header("Location: ../Public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Administrateur</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Bienvenue, Administrateur</h1>
        <div class="row">
            <div class="col-md-4">
                <a href="user_management.php" class="btn btn-primary btn-block">Gestion des Utilisateurs</a>
            </div>
            <div class="col-md-4">
                <a href="reports.php" class="btn btn-success btn-block">Rapports</a>
            </div>
            <div class="col-md-4">
                <a href="store_operations.php" class="btn btn-info btn-block">Opérations du Magasin</a>
            </div>
        </div>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
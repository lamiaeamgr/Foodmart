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
    <title>Ajouter un Produit</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Ajouter un Produit</h1>
        <form action="../../Gestion_Actions/vendeur/vendeur_actions.php?action=add_product" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="reference">Référence</label>
                <input type="text" class="form-control" id="reference" name="reference" required>
            </div>
            <div class="form-group">
                <label for="designation">Désignation</label>
                <input type="text" class="form-control" id="designation" name="designation" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
            </div>
            <div class="form-group">
                <label for="quantite_stock">Quantité en Stock</label>
                <input type="number" class="form-control" id="quantite_stock" name="quantite_stock" required>
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <input type="text" class="form-control" id="categorie" name="categorie" required>
            </div>
            <div class="form-group">
                <label for="date_peremption">Date de Péremption</label>
                <input type="date" class="form-control" id="date_peremption" name="date_peremption">
            </div>
            <div class="form-group">
                <label for="promotion">Promotion (%)</label>
                <input type="number" step="0.01" class="form-control" id="promotion" name="promotion">
            </div>
            <div class="form-group">
                <label for="image_upload">Choisir une Image</label>
                <input type="file" class="form-control" id="image_upload" name="image_upload" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
        </form>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
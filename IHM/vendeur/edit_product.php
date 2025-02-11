<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

$product_id = $_GET['id'] ?? '';
if (!$product_id) {
    header("Location: products.php");
    exit;
}

// Fetch product details
$product = getProduitById($product_id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Produit</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Modifier un Produit</h1>
        <form action="Gestion_Actions/vendeur/vendeur_actions.php?action=update_product" method="POST">
            <input type="hidden" name="id" value="<?= $product['id']; ?>">
            <div class="form-group">
                <label for="reference">Référence</label>
                <input type="text" class="form-control" id="reference" name="reference" value="<?= $product['reference']; ?>" required>
            </div>
            <div class="form-group">
                <label for="designation">Désignation</label>
                <input type="text" class="form-control" id="designation" name="designation" value="<?= $product['designation']; ?>" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" step="0.01" class="form-control" id="prix" name="prix" value="<?= $product['prix']; ?>" required>
            </div>
            <div class="form-group">
                <label for="quantite_stock">Quantité en Stock</label>
                <input type="number" class="form-control" id="quantite_stock" name="quantite_stock" value="<?= $product['quantite_stock']; ?>" required>
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <input type="text" class="form-control" id="categorie" name="categorie" value="<?= $product['categorie']; ?>" required>
            </div>
            <div class="form-group">
                <label for="date_peremption">Date de Péremption</label>
                <input type="date" class="form-control" id="date_peremption" name="date_peremption" value="<?= $product['date_peremption']; ?>">
            </div>
            <div class="form-group">
                <label for="promotion">Promotion (%)</label>
                <input type="number" step="0.01" class="form-control" id="promotion" name="promotion" value="<?= $product['promotion']; ?>">
            </div>
            <div class="form-group">
                <label for="image_path">Chemin de l'Image</label>
                <input type="text" class="form-control" id="image_path" name="image_path" value="<?= $product['image_path']; ?>">
            </div>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </form>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
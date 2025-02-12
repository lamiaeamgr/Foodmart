<?php
session_start();
if (!isset($_SESSION['email'])) {
    // header("Location: ../../index.php");
    echo "lhabs";
    exit;
}

$product_id = $_GET['id'] ?? '';
if (!$product_id) {
    header("Location: products.php");
    exit;
}

$product_to_edit = isset($_SESSION['product_to_edit']) ? $_SESSION['product_to_edit'] : null;
// var_dump($_SESSION['product_to_edit']);
if (!$product_to_edit || $product_to_edit['id'] != $product_id) {
    header("Location: ../../Gestion_Actions/vendeur/vendeur_actions.php?action=get_product&&id=$product_id");
    exit;
}



// Fetch product details
// $product = getProduitById($product_id);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Produit</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>

<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Modifier un Produit</h1>
        <form action="../../Gestion_Actions/vendeur/vendeur_actions.php?action=update_product" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product_to_edit['id']; ?>">
            <div class="form-group">
                <label for="reference">Référence</label>
                <input type="text" class="form-control" id="reference" name="reference"
                    value="<?= $product_to_edit['reference']; ?>" required>
            </div>
            <div class="form-group">
                <label for="designation">Désignation</label>
                <input type="text" class="form-control" id="designation" name="designation"
                    value="<?= $product_to_edit['designation']; ?>" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" step="0.01" class="form-control" id="prix" name="prix"
                    value="<?= $product_to_edit['prix']; ?>" required>
            </div>
            <div class="form-group">
                <label for="quantite_stock">Quantité en Stock</label>
                <input type="number" class="form-control" id="quantite_stock" name="quantite_stock"
                    value="<?= $product_to_edit['quantite_stock']; ?>" required>
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <input type="text" class="form-control" id="categorie" name="categorie"
                    value="<?= $product_to_edit['categorie']; ?>" required>
            </div>
            <div class="form-group">
                <label for="date_peremption">Date de Péremption</label>
                <input type="date" class="form-control" id="date_peremption" name="date_peremption"
                    value="<?= $product_to_edit['date_peremption']; ?>">
            </div>
            <div class="form-group">
                <label for="promotion">Promotion (%)</label>
                <input type="number" step="0.01" class="form-control" id="promotion" name="promotion"
                    value="<?= $product_to_edit['promotion']; ?>">
            </div>
            <div class="form-group">
                <label for="image_upload">Image Upload</label>
                <input type="file" class="form-control-file" id="image_upload" name="image_upload">
                <!-- Show current image if editing -->
                <?php if (isset($product_to_edit['image_path'])): ?>
                    <div class="mt-2">
                        <small>Current Image:</small>
                        <img src="<?= htmlspecialchars($product_to_edit['image_path']) ?>" alt="Product image"
                            style="max-width: 200px;">
                        <!-- Hidden field to preserve existing image path -->
                        <input type="hidden" name="existing_image"
                            value="<?= htmlspecialchars($product_to_edit['image_path']) ?>">
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </form>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>

</html>
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
    <title>Ajouter une Promotion</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Ajouter une Promotion</h1>
        <form action="Gestion_Actions/vendeur/vendeur_actions.php?action=add_promotion" method="POST">
            <div class="form-group">
                <label for="produit_id">Produit</label>
                <select class="form-control" id="produit_id" name="produit_id" required>
                    <?php
                    $products = listAllProduits();
                    foreach ($products as $product) {
                        echo "<option value='{$product['id']}'>{$product['designation']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="reduction">Réduction (%)</label>
                <input type="number" step="0.01" class="form-control" id="reduction" name="reduction" required>
            </div>
            <div class="form-group">
                <label for="date_debut">Date Début</label>
                <input type="date" class="form-control" id="date_debut" name="date_debut" required>
            </div>
            <div class="form-group">
                <label for="date_fin">Date Fin</label>
                <input type="date" class="form-control" id="date_fin" name="date_fin" required>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
        </form>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
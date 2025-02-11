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
    <title>Gestion des Promotions</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Gestion des Promotions</h1>
        <a href="add_promotion.php" class="btn btn-primary mb-3">Ajouter une Promotion</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produit</th>
                    <th>Réduction (%)</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch promotions from the database
                $promotions = listAllPromotions();
                foreach ($promotions as $promotion) {
                    echo "<tr>
                            <td>{$promotion['id']}</td>
                            <td>{$promotion['produit_id']}</td>
                            <td>{$promotion['reduction']}</td>
                            <td>{$promotion['date_debut']}</td>
                            <td>{$promotion['date_fin']}</td>
                            <td>
                                <a href='edit_promotion.php?id={$promotion['id']}' class='btn btn-info btn-sm'>Modifier</a>
                                <a href='Gestion_Actions/vendeur/vendeur_actions.php?action=delete_promotion&id={$promotion['id']}' class='btn btn-danger btn-sm'>Supprimer</a>
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
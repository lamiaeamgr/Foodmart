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
    <title>Mes Coupons</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Mes Coupons</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Coupon</th>
                    <th>Points Gagnés</th>
                    <th>Points Utilisés</th>
                    <th>Date d'Expiration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch coupons from the database
                $coupons = listAllCouponsForClient($_SESSION['user_id']);
                foreach ($coupons as $coupon) {
                    echo "<tr>
                            <td>{$coupon['id']}</td>
                            <td>{$coupon['points_gagnes']}</td>
                            <td>{$coupon['points_utilises']}</td>
                            <td>{$coupon['date_expiration']}</td>
                            <td>
                                <a href='Gestion_Actions/acheteur/acheteur_actions.php?action=use_coupon&coupon_id={$coupon['id']}' class='btn btn-success btn-sm'>Utiliser</a>
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
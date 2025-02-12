<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

// Retrieve coupons from the session set by the actions layer
$coupons = isset($_SESSION['coupons']) ? $_SESSION['coupons'] : [];

// Optionally, you might want to clear the session variable once it is used:
// unset($_SESSION['coupons']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Coupons</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                if (empty($coupons)) {
                    echo "<tr><td colspan='5' class='text-center'>Aucun coupon trouvé.</td></tr>";
                } else {
                    foreach ($coupons as $coupon) {
                        echo "<tr>
                                <td>" . htmlspecialchars($coupon['id']) . "</td>
                                <td>" . htmlspecialchars($coupon['points_gagnes']) . "</td>
                                <td>" . htmlspecialchars($coupon['points_utilises']) . "</td>
                                <td>" . htmlspecialchars($coupon['date_expiration']) . "</td>
                                <td>
                                    <a href='Gestion_Actions/acheteur/acheteur_actions.php?action=use_coupon&coupon_id=" . urlencode($coupon['id']) . "' class='btn btn-success btn-sm'>Utiliser</a>
                                </td>
                              </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>

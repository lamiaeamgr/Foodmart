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
    <title>Rapports</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Rapports</h1>
        <div class="row">
            <div class="col-md-4">
                <a href="daily_report.php" class="btn btn-primary btn-block">Rapport Journalier</a>
            </div>
            <div class="col-md-4">
                <a href="weekly_report.php" class="btn btn-success btn-block">Rapport Hebdomadaire</a>
            </div>
            <div class="col-md-4">
                <a href="monthly_report.php" class="btn btn-info btn-block">Rapport Mensuel</a>
            </div>
        </div>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
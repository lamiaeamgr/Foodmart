<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

// Fetch client details
$client = getClientById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Mon Profil</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Nom:</strong> <?= $client['nom']; ?></p>
                <p><strong>Email:</strong> <?= $client['email']; ?></p>
                <p><strong>Téléphone:</strong> <?= $client['telephone']; ?></p>
                <p><strong>Adresse:</strong> <?= $client['adresse']; ?></p>
                <p><strong>Points:</strong> <?= $client['points']; ?></p>
                <a href="edit_profile.php" class="btn btn-primary">Modifier le Profil</a>
            </div>
        </div>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
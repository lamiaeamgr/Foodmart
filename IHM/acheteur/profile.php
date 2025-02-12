<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit;
}

$client = isset($_SESSION['client']) ? $_SESSION['client'] : null;

if (!$client) {
    header("Location: ../../Gestion_Actions/acheteur/acheteur_actions.php?action=view_profile");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Mon Profil</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Nom:</strong> <?= htmlspecialchars($client['nom']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($client['email']); ?></p>
                <p><strong>Téléphone:</strong> <?= htmlspecialchars($client['telephone']); ?></p>
                <p><strong>Adresse:</strong> <?= htmlspecialchars($client['adresse']); ?></p>
                <p><strong>Points:</strong> <?= htmlspecialchars($client['points']); ?></p>
                <a href="edit_profile.php" class="btn btn-primary">Modifier le Profil</a>
            </div>
        </div>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>

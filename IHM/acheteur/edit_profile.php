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
    <title>Modifier le Profil</title>
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Modifier le Profil</h1>
        <form action="Gestion_Actions/acheteur/acheteur_actions.php?action=update_profile" method="POST">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= $client['nom']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $client['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="<?= $client['telephone']; ?>">
            </div>
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <textarea class="form-control" id="adresse" name="adresse"><?= $client['adresse']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </form>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
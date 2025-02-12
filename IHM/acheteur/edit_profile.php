<?php
session_start();
// require_once '../ACCES_BD/Models/client.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit;
}

$client = isset($_SESSION['client']) ? $_SESSION['client'] : null;

if (!$client) {
    header("Location: ../../Gestion_Actions/acheteur/acheteur_actions.php?action=view_profile");
    exit;
}

// Fetch client details
// $client = getClientById(id: $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
   <!-- Link to Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Add Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="../Public/css/style.css">
<link rel="stylesheet" href="../Public/css/style.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.getElementById("editProfileForm");
            form.addEventListener("submit", function(event) {
                // Get the values of the password fields
                var pwd = document.getElementById("mot_de_passe").value;
                var confirmPwd = document.getElementById("confirmation_mot_de_passe").value;
                
                // Clear any previous error message
                document.getElementById("pwdError").textContent = "";
                
                // Check if the passwords match
                if (pwd !== confirmPwd) {
                    event.preventDefault(); // Prevent form submission
                    document.getElementById("pwdError").textContent = "Les mots de passe ne correspondent pas.";
                }
            });
        });
    </script>
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Modifier le Profil</h1>
        <form id="editProfileForm" action="../../Gestion_Actions/acheteur/acheteur_actions.php?action=update_profile" method="POST">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($client['nom']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($client['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="<?= htmlspecialchars($client['telephone']); ?>">
            </div>
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <textarea class="form-control" id="adresse" name="adresse"><?= htmlspecialchars($client['adresse']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
            </div>
            <div class="form-group">
                <label for="confirmation_mot_de_passe">Confirmation du mot de passe</label>
                <input type="password" class="form-control" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe">
                <!-- Error message placeholder -->
                <div id="pwdError" class="error-message"></div>
            </div>
            <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
        </form>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}
$users = isset($_SESSION['list_users']) ? $_SESSION['list_users'] : null;
if (!$users) {
    header("Location: ../../Gestion_Actions/administrateur/admin_actions.php?action=list_users");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Gestion des Utilisateurs</h1>
        <a href="add_user.php" class="btn btn-primary mb-3">Ajouter un Utilisateur</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch users from the database
                // $users = listAllUsers();
                foreach ($users as $user) {
                    echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['nom']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['type']}</td>
                            <td>
                                <a href='edit_user.php?id={$user['id']}' class='btn btn-info btn-sm'>Modifier</a>
                            </td>
                          </tr>";
                }
                ?>                               
                 <!-- <a href='Gestion_Actions/administrateur/admin_actions.php?action=delete_user&id={$user['id']}&user_type={$user['user_type']}' class='btn btn-danger btn-sm'>Supprimer</a> -->

            </tbody>
        </table>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
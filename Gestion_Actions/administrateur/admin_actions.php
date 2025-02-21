<?php
session_start();
include('../../Acces_BD/Models/Administrateur.php');
include('../../Acces_BD/Models/Client.php');
include('../../Acces_BD/Models/Vendeur.php');

// Ensure the user is logged in as an admin
if (!isset($_SESSION['email'])) {
    header("Location: ../../IHM/Public/login.php");
    exit;
}

$action = $_GET['action'] ?? ''; // Capture the action from the URL

switch ($action) {
    case 'add_user':
        if (isset($_POST['nom'], $_POST['email'], $_POST['mot_de_passe'], $_POST['user_type'])) {
            $nom = htmlspecialchars($_POST['nom']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
            $user_type = $_POST['user_type'];

            if ($user_type == 'client') {
                createClient($nom, $email, $mot_de_passe, '', '', 0);
            } elseif ($user_type == 'vendeur') {
                createVendeur($nom, $email, $mot_de_passe, '', '');
            }

            // Refresh the list of users in the session
            $users = listAllUsers();
            $_SESSION['list_users'] = $users;

            header("Location: ../../IHM/administrateur/user_management.php");
            exit;
        }
        break;

    case 'delete_user':
        
        if (isset($_GET['id'], $_GET['user_type'])) {
            $id = intval($_GET['id']);
            $user_type = $_GET['user_type'];

            if ($user_type == 'client') {
                deleteClient($id);
            } elseif ($user_type == 'vendeur') {
                deleteVendeur($id);
            }

            // Refresh the list of users in the session
            $users = listAllUsers();
            $_SESSION['list_users'] = $users;

            header("Location: ../../IHM/administrateur/user_management.php");
            exit;
        }
        break;

    case 'list_users':
        $users = listAllUsers();
        $_SESSION['list_users'] = $users;
        header("Location: ../../IHM/administrateur/user_management.php");
        break;

    default:
        header("Location: ../../IHM/administrateur/index.php");
        exit;
}
?>
<?php
session_start();
include_once('../Acces_BD/connexion.php'); 

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query_admin = "SELECT * FROM administrateurs WHERE email='$email'";
    $result_admin = mysqli_fetch_assoc(mysqli_query($conn, $query_admin));

    $query_vendeur = "SELECT * FROM vendeurs WHERE email='$email'";
    $result_vendeur = mysqli_fetch_assoc(mysqli_query($conn, $query_vendeur));

    $query_client = "SELECT * FROM clients WHERE email='$email'";
    $result_client = mysqli_fetch_assoc(mysqli_query($conn, $query_client));

    if ($result_admin && $password == $result_admin['mot_de_passe']) {
        $_SESSION['email'] = $result_admin['email'];
        $_SESSION['isAdmin'] = 1; 
        $_SESSION['user_type'] = 'admin'; 
        $_SESSION['user_id']=$result_admin['id'];
        header("Location: ../IHM/administrateur/index.php"); 
        exit;
    }
    else if ($result_vendeur && $password == $result_vendeur['mot_de_passe']) {
        $_SESSION['email'] = $result_vendeur['email'];
        $_SESSION['isAdmin'] = 0; 
        $_SESSION['user_type'] = 'vendeur'; 
        $_SESSION['user_id']=$result_vendeur['id'];
        header("Location: ../IHM/vendeur/index.php"); 
        exit;
    }
    else if ($result_client && $password == $result_client['mot_de_passe']) {
        $_SESSION['email'] = $result_client['email'];
        $_SESSION['isAdmin'] = 0; 
        $_SESSION['user_type'] = 'client'; 
        $_SESSION['user_id']=$result_client['id'];
        header("Location: ../IHM/acheteur/index.php"); 
        exit;
    } else {
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: ../index.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Email and password are required.";
    header("Location: ../index.php");
    exit;
}
?>

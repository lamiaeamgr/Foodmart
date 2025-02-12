<?php
require_once __DIR__ . '/../connexion.php';

function createAdministrateur($nom, $email, $mot_de_passe) {
    global $conn;
    $sql = "INSERT INTO administrateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $nom, $email, password_hash($mot_de_passe, PASSWORD_DEFAULT));
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function readAdministrateur($id) {
    global $conn;
    $sql = "SELECT * FROM administrateurs WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateAdministrateur($id, $nom, $email, $mot_de_passe) {
    global $conn;
    $sql = "UPDATE administrateurs SET nom = ?, email = ?, mot_de_passe = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssi', $nom, $email, password_hash($mot_de_passe, PASSWORD_DEFAULT), $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deleteAdministrateur($id) {
    global $conn;
    $sql = "DELETE FROM administrateurs WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function listAllAdministrateurs() {
    global $conn;
    $sql = "SELECT * FROM administrateurs";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function listAllUsers() {
    global $conn;
    
    $sql = "
        SELECT id, nom, email, 'administrateur' AS type FROM administrateurs
        UNION 
        SELECT id, nom, email, 'vendeur' AS type FROM vendeurs
        UNION 
        SELECT id, nom, email, 'client' AS type FROM clients
    ";

    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        die("Erreur SQL : " . mysqli_error($conn));
    }
    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}



?>
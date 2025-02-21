<?php
require_once __DIR__ . '/../connexion.php';

function createVendeur($nom, $email, $mot_de_passe, $telephone, $adresse) {
    global $conn;
    $sql = "INSERT INTO vendeurs (nom, email, mot_de_passe, telephone, adresse) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $nom, $email, password_hash($mot_de_passe, PASSWORD_DEFAULT), $telephone, $adresse);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function readVendeur($id) {
    global $conn;
    $sql = "SELECT * FROM vendeurs WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateVendeur($id, $nom, $email, $mot_de_passe, $telephone, $adresse) {
    global $conn;
    $sql = "UPDATE vendeurs SET nom = ?, email = ?, mot_de_passe = ?, telephone = ?, adresse = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssi', $nom, $email, password_hash($mot_de_passe, PASSWORD_DEFAULT), $telephone, $adresse, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deleteVendeur($id) {
    global $conn;
    $sql = "DELETE FROM vendeurs WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function listAllVendeurs() {
    global $conn;
    $sql = "SELECT * FROM vendeurs";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<?php
require_once 'connexion.php';

function createClient($nom, $email, $mot_de_passe, $telephone, $adresse, $points) {
    global $conn;
    $sql = "INSERT INTO clients (nom, email, mot_de_passe, telephone, adresse, points) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssi', $nom, $email, password_hash($mot_de_passe, PASSWORD_DEFAULT), $telephone, $adresse, $points);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function readClient($id) {
    global $conn;
    $sql = "SELECT * FROM clients WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateClient($id, $nom, $email, $mot_de_passe, $telephone, $adresse, $points) {
    global $conn;
    $sql = "UPDATE clients SET nom = ?, email = ?, mot_de_passe = ?, telephone = ?, adresse = ?, points = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssii', $nom, $email, password_hash($mot_de_passe, PASSWORD_DEFAULT), $telephone, $adresse, $points, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deleteClient($id) {
    global $conn;
    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function listAllClients() {
    global $conn;
    $sql = "SELECT * FROM clients";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<?php
require_once 'connexion.php';

function createProduit($reference, $designation, $prix, $quantite_stock, $categorie, $date_peremption, $promotion, $image_path) {
    global $conn;
    $sql = "INSERT INTO produits (reference, designation, prix, quantite_stock, categorie, date_peremption, promotion, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssdissss', $reference, $designation, $prix, $quantite_stock, $categorie, $date_peremption, $promotion, $image_path);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function readProduit($id) {
    global $conn;
    $sql = "SELECT * FROM produits WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateProduit($id, $reference, $designation, $prix, $quantite_stock, $categorie, $date_peremption, $promotion, $image_path) {
    global $conn;
    $sql = "UPDATE produits SET reference = ?, designation = ?, prix = ?, quantite_stock = ?, categorie = ?, date_peremption = ?, promotion = ?, image_path = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssdissssi', $reference, $designation, $prix, $quantite_stock, $categorie, $date_peremption, $promotion, $image_path, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deleteProduit($id) {
    global $conn;
    $sql = "DELETE FROM produits WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function listAllProduits() {
    global $conn;
    $sql = "SELECT * FROM produits";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
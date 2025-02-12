<?php
require_once __DIR__ . '/../connexion.php';

function createPromotion($produit_id, $reduction, $date_debut, $date_fin) {
    global $conn;
    $sql = "INSERT INTO promotions (produit_id, reduction, date_debut, date_fin) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'idss', $produit_id, $reduction, $date_debut, $date_fin);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function readPromotion($id) {
    global $conn;
    $sql = "SELECT * FROM promotions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updatePromotion($id, $produit_id, $reduction, $date_debut, $date_fin) {
    global $conn;
    $sql = "UPDATE promotions SET produit_id = ?, reduction = ?, date_debut = ?, date_fin = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'idssi', $produit_id, $reduction, $date_debut, $date_fin, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deletePromotion($id) {
    global $conn;
    $sql = "DELETE FROM promotions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function listAllPromotions() {
    global $conn;
    $sql = "SELECT * FROM promotions";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
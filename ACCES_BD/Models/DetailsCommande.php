<?php
require_once __DIR__ . '/../connexion.php';

function createDetailsCommande($commande_id, $produit_id, $quantite, $prix_unitaire) {
    global $conn;
    $sql = "INSERT INTO details_commandes (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iiid', $commande_id, $produit_id, $quantite, $prix_unitaire);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function readDetailsCommande($id) {
    global $conn;
    $sql = "SELECT * FROM details_commandes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateDetailsCommande($id, $commande_id, $produit_id, $quantite, $prix_unitaire) {
    global $conn;
    $sql = "UPDATE details_commandes SET commande_id = ?, produit_id = ?, quantite = ?, prix_unitaire = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iiidi', $commande_id, $produit_id, $quantite, $prix_unitaire, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deleteDetailsCommande($id) {
    global $conn;
    $sql = "DELETE FROM details_commandes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function listAllDetailsCommandes() {
    global $conn;
    $sql = "SELECT * FROM details_commandes";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
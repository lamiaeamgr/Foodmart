<?php
require_once 'connexion.php';

function createCommande($client_id, $date_commande, $statut, $total, $type_livraison, $date_livraison, $produit_id, $quantite) {
    global $conn;
    $sql = "INSERT INTO commandes (client_id, date_commande, statut, total, type_livraison, date_livraison, produit_id, quantite) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isssssii', $client_id, $date_commande, $statut, $total, $type_livraison, $date_livraison, $produit_id, $quantite);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function readCommande($id) {
    global $conn;
    $sql = "SELECT * FROM commandes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateCommande($id, $client_id, $date_commande, $statut, $total, $type_livraison, $date_livraison, $produit_id, $quantite) {
    global $conn;
    $sql = "UPDATE commandes SET client_id = ?, date_commande = ?, statut = ?, total = ?, type_livraison = ?, date_livraison = ?, produit_id = ?, quantite = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isssssiii', $client_id, $date_commande, $statut, $total, $type_livraison, $date_livraison, $produit_id, $quantite, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deleteCommande($id) {
    global $conn;
    $sql = "DELETE FROM commandes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function listAllCommandes() {
    global $conn;
    $sql = "SELECT * FROM commandes";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
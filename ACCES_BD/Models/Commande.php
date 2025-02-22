<?php
require_once __DIR__ . '/../connexion.php';

function createCommande($client_id, $date_commande, $statut, $total, $type_livraison, $date_livraison) {
    global $conn;
    $sql = "INSERT INTO commandes (client_id, date_commande, statut, total, type_livraison, date_livraison) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isssss', $client_id, $date_commande, $statut, $total, $type_livraison, $date_livraison);
    mysqli_stmt_execute($stmt);
    return mysqli_insert_id($conn); 
}

function addDetailCommande($commande_id, $produit_id, $quantite, $prix_unitaire) {
    global $conn;
    $sql = "INSERT INTO details_commandes (commande_id, produit_id, quantite, prix_unitaire) 
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iiid', $commande_id, $produit_id, $quantite, $prix_unitaire);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function listAllCommandesForClient($client_id) {
    global $conn;
    $sql = "SELECT c.*, p.designation, p.image_path, dc.quantite, dc.prix_unitaire 
            FROM commandes c
            JOIN details_commandes dc ON c.id = dc.commande_id
            JOIN produits p ON dc.produit_id = p.id
            WHERE c.client_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $client_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
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

function updateOrderStatus($commande_id, $statut) {
    global $conn;
    $sql = "UPDATE commandes SET statut = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $statut, $commande_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function getOrderItems($order_id) {
    global $conn;
    $sql = "SELECT p.designation, dc.quantite, dc.prix_unitaire 
            FROM details_commandes dc
            JOIN produits p ON dc.produit_id = p.id
            WHERE dc.commande_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>
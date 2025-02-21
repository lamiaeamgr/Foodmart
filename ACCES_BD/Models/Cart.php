<?php
require_once __DIR__ . '/../connexion.php';

function createCart($client_id, $produit_id, $quantite) {
    global $conn;
    $sql = "INSERT INTO cart (client_id, produit_id, quantite) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iii', $client_id, $produit_id, $quantite);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function readCart($id) {
    global $conn;
    $sql = "SELECT * FROM cart WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateCart($id, $client_id, $produit_id, $quantite) {
    global $conn;
    $sql = "UPDATE cart SET client_id = ?, produit_id = ?, quantite = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iiii', $client_id, $produit_id, $quantite, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deleteCart($id) {
    global $conn;
    $sql = "DELETE FROM cart WHERE produit_id = $id";
    $res=mysqli_query($conn, $sql);
    var_dump($res);
    return ;
}

function listAllCartsForClient($client_id) {
    global $conn;
    $sql = "SELECT * FROM cart, produits WHERE client_id = $client_id and cart.produit_id = produits.id ";
    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getCartById($id) {
    return readCart($id);
}
function addToCart($client_id, $produit_id, $quantite) {
    global $conn;
    
    $sql = "SELECT * FROM cart WHERE client_id = ? AND produit_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $client_id, $produit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $sql = "UPDATE cart SET quantite = quantite + ? WHERE client_id = ? AND produit_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'iii', $quantite, $client_id, $produit_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt);
    } else {
        $sql = "INSERT INTO cart (client_id, produit_id, quantite) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'iii', $client_id, $produit_id, $quantite);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_affected_rows($stmt);
    }
}

?>

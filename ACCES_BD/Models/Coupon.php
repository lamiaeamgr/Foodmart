<?php
require_once __DIR__ . '/../connexion.php';

function createCoupon($client_id, $points_gagnes, $points_utilises, $date_expiration) {
    global $conn;
    $sql = "INSERT INTO coupons (client_id, points_gagnes, points_utilises, date_expiration) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iiis', $client_id, $points_gagnes, $points_utilises, $date_expiration);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function readCoupon($id) {
    global $conn;
    $sql = "SELECT * FROM coupons WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateCoupon($id, $client_id, $points_gagnes, $points_utilises, $date_expiration) {
    global $conn;
    $sql = "UPDATE coupons SET client_id = ?, points_gagnes = ?, points_utilises = ?, date_expiration = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iiisi', $client_id, $points_gagnes, $points_utilises, $date_expiration, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function deleteCoupon($id) {
    global $conn;
    $sql = "DELETE FROM coupons WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

function listAllCoupons() {
    global $conn;
    $sql = "SELECT * FROM coupons";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
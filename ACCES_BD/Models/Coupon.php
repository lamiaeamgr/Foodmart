<?php
require_once __DIR__ . '/../connexion.php';


function generateCouponCode() {
    return strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
}

function createCoupon($client_id, $code, $valeur, $type, $points, $date_expiration) {
    global $conn;
    $sql = "INSERT INTO coupons (client_id, code, valeur, `type`, points_utilises, date_expiration) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Corrected binding parameters: "isssis"
    mysqli_stmt_bind_param($stmt, 'isssis', $client_id, $code, $valeur, $type, $points, $date_expiration);
    
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}


function getCouponByCode($id) {
    global $conn;
    $sql = "SELECT * FROM coupons WHERE code = ?";
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

function listAllCouponsForClient($client_id) {
    global $conn;
    $sql = "SELECT * FROM coupons where client_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $client_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC); 
}

function useCoupon($coupon_id) {
    global $conn;
    $sql = "UPDATE coupons SET is_used = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $coupon_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}
?>
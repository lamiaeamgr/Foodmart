<?php 
require_once __DIR__ . '/../connexion.php';

// Get vendor information
$vendor_email = $_SESSION['email'];
$vendor_info = $conn->prepare("SELECT * FROM vendeurs WHERE email = ?");
$vendor_info->bind_param("s", $vendor_email);
$vendor_info->execute();
$vendor = $vendor_info->get_result()->fetch_assoc();

// Sales data for charts
$monthly_sales = $conn->query("SELECT 
    MONTH(date_commande) AS month, 
    SUM(total) AS total 
    FROM commandes 
    WHERE YEAR(date_commande) = YEAR(CURDATE())
    GROUP BY MONTH(date_commande)");

$sales_data = [];
while($row = $monthly_sales->fetch_assoc()) {
    $sales_data['months'][] = date('F', mktime(0, 0, 0, $row['month'], 1));
    $sales_data['totals'][] = $row['total'];
}

// Product category distribution
$category_dist = $conn->query("SELECT categorie, COUNT(*) AS count 
                             FROM produits 
                             GROUP BY categorie");
$categories = [];
$counts = [];
while($row = $category_dist->fetch_assoc()) {
    $categories[] = $row['categorie'];
    $counts[] = $row['count'];
}
?>
<?php
// Inclusion de la connexion BD
require_once __DIR__ . '/../connexion.php';

// Récupérer les données statistiques
$stats = [];
$queries = [
    'total_products' => "SELECT COUNT(*) AS total FROM produits",
    'low_stock' => "SELECT COUNT(*) AS low FROM produits WHERE quantite_stock < 50",
    'pending_orders' => "SELECT COUNT(*) AS pending FROM commandes WHERE statut = 'en attente'",
    'active_promotions' => "SELECT COUNT(*) AS promotions FROM promotions WHERE date_debut <= CURDATE() AND date_fin >= CURDATE()"
];

foreach ($queries as $key => $sql) {
    $result = $conn->query($sql);
    $stats[$key] = $result->fetch_assoc()[$key === 'low_stock' ? 'low' : ($key === 'pending_orders' ? 'pending' : ($key === 'active_promotions' ? 'promotions' : 'total'))];
}

// Récupérer les dernières commandes
$recent_orders = $conn->query("SELECT c.id, cl.nom, c.total, c.statut 
                             FROM commandes c 
                             JOIN clients cl ON c.client_id = cl.id 
                             ORDER BY c.date_commande DESC 
                             LIMIT 5");

// Récupérer les produits en rupture de stock
$low_stock_products = $conn->query("SELECT designation, quantite_stock 
                                  FROM produits 
                                  WHERE quantite_stock < 50 
                                  ORDER BY quantite_stock ASC 
                                  LIMIT 5");
?>
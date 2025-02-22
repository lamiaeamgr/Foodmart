<?php
// Inclusion de la connexion BD
require_once __DIR__ . '/../connexion.php';

// Fonction pour récupérer les données
function recupererDonnees($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// 1. Ventes totales sur la période
$ventesPeriode = recupererDonnees($conn, 
    "SELECT DATE(date_commande) AS date_vente, SUM(total) AS total 
     FROM commandes 
     GROUP BY date_vente 
     ORDER BY date_vente");

// 2. Ventes par catégorie
$categoriesData = recupererDonnees($conn,
    "SELECT p.categorie, SUM(dc.prix_unitaire * dc.quantite) AS total
     FROM details_commandes dc
     JOIN produits p ON dc.produit_id = p.id
     GROUP BY p.categorie");

// 3. Produits les plus vendus
$topProduits = recupererDonnees($conn,
    "SELECT p.designation, SUM(dc.quantite) AS total_quantite
     FROM details_commandes dc
     JOIN produits p ON dc.produit_id = p.id
     GROUP BY p.designation
     ORDER BY total_quantite DESC
     LIMIT 5");

// 4. Historique des achats clients
$achatsClients = recupererDonnees($conn,
    "SELECT cl.nom, SUM(c.total) AS total 
     FROM clients cl
     LEFT JOIN commandes c ON cl.id = c.client_id
     GROUP BY cl.nom");

// 5. Utilisation des coupons
$utilisationCoupons = recupererDonnees($conn,
    "SELECT cl.nom, 
            COUNT(cp.id) AS nombre_coupons, 
            SUM(cp.points_utilises) AS points_utilises
     FROM coupons cp
     JOIN clients cl ON cp.client_id = cl.id
     GROUP BY cl.nom");


?>
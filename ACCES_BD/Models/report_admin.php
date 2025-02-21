<?php
// Inclusion de la connexion BD
require_once __DIR__ . '/../connexion.php';

// Fonction pour récupérer les données
function recupererDonnees($conn, $sql) {
    $result = mysqli_query($conn, $sql);
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
    "SELECT p.categorie, SUM(c.total) AS total
     FROM commandes c
     JOIN produits p ON FIND_IN_SET(p.id, c.product_ids)
     GROUP BY p.categorie");

// 3. Produits les plus vendus
$topProduits = recupererDonnees($conn,
    "SELECT p.designation, SUM(sub.quantite) AS total_quantite
     FROM (
         SELECT 
             SUBSTRING_INDEX(SUBSTRING_INDEX(c.product_ids, ',', n.n), ',', -1) AS produit_id,
             SUBSTRING_INDEX(SUBSTRING_INDEX(c.quantities, ',', n.n), ',', -1) AS quantite
         FROM commandes c
         CROSS JOIN (
             SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
         ) n
         WHERE n.n <= (LENGTH(c.product_ids) - LENGTH(REPLACE(c.product_ids, ',', '')) + 1)
     ) sub
     JOIN produits p ON sub.produit_id = p.id
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
            SUM(cp.points_gagnes) AS points_gagnes, 
            SUM(cp.points_utilises) AS points_utilises
     FROM coupons cp
     JOIN clients cl ON cp.client_id = cl.id
     GROUP BY cl.nom");
?>
<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != 'vendeur') {
    header("Location: ../../IHM/Public/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: ../../IHM/vendeur/orders.php");
    exit;
}

$order_id = $_GET['id'];

// Fetch order details from the database
include('../../Acces_BD/Models/Commande.php');
$order = readCommande($order_id);

if (!$order) {
    echo "Commande non trouvée.";
    exit;
}

// Fetch order items
$order_items = getOrderItems($order_id);

// Determine status class
$statusClass = match(strtolower($order['statut'])) {
    'livrée' => 'status-delivered',
    'annulée' => 'status-cancelled',
    default => 'status-pending'
};
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
:root {
    --neon-green: #7dce94;
    --cyber-gold: #ffd700;
    --cream-citrus: #FFD8A8;
    --cyber-bg-gradient: radial-gradient(circle at center, #f8fff9 0%, #fff5e6 100%);
    --cyber-border: 2px solid #FFE4C4;
    --dark-text: #5d4037;
}

body {
    background: var(--cyber-bg-gradient);
    min-height: 100vh;
}

.orders-container {
    max-width: 1200px;
    margin: 3rem auto;
    padding: 2.5rem;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    border: var(--cyber-border);
    box-shadow: 0 10px 30px rgba(125, 206, 148, 0.1);
    animation: slideUp 0.6s ease;
    backdrop-filter: blur(8px);
}

@keyframes slideUp {
    from { transform: translateY(50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

h1 {
    color: var(--neon-green);
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
    text-shadow: 0 2px 4px rgba(125, 206, 148, 0.1);
}

.subtitle-shimmer {
    color: var(--cream-citrus);
    font-size: 1.2rem;
    position: relative;
    display: inline-block;
    margin-top: 1rem;
}

.subtitle-shimmer::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    width: 120px;
    height: 3px;
    background: linear-gradient(90deg, 
        transparent 0%, 
        var(--neon-green) 30%, 
        var(--cream-citrus) 70%, 
        transparent 100%);
    transform: translateX(-50%);
    border-radius: 2px;
}

.card {
    background: rgba(255, 255, 255, 0.95);
    border: var(--cyber-border);
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(125, 206, 148, 0.1);
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(125, 206, 148, 0.15);
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    display: inline-block;
}

.status-pending { 
    background: rgba(255, 215, 0, 0.2); 
    color: #5d4037; 
}
.status-delivered { 
    background: rgba(125, 206, 148, 0.2); 
    color: var(--neon-green); 
}
.status-cancelled { 
    background: rgba(178, 34, 34, 0.2); 
    color: #B22222; 
}

.btn-action {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
}

.btn-details {
    background: rgba(125, 206, 148, 0.2);
    color: var(--neon-green);
}

.btn-update {
    background: rgba(255, 215, 0, 0.2);
    color: var(--dark-text);
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(125, 206, 148, 0.1);
}

@media (max-width: 768px) {
    .orders-container {
        margin: 2rem 1rem;
        padding: 1.5rem;
    }
    
    .card {
        margin-bottom: 2rem;
    }
}

.neon-text {
    font-size: 2.5rem;
    text-shadow: 0 0 15px rgba(125, 206, 148, 0.3);
    animation: flicker 3s infinite;
}

@keyframes flicker {
    0% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
    50% { opacity: 0.9; text-shadow: 0 0 20px rgba(125, 206, 148, 0.4); }
    100% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
}
    </style>
</head>
<body>
    <?php include('../Public/navbar.php'); ?>
    
    <div class="orders-container">
        <h1><i class="bi bi-receipt"></i> Détails de la Commande #<?= $order['id'] ?></h1>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <strong>Client ID:</strong> <?= $order['client_id'] ?>
                </div>
                <div class="mb-3">
                    <strong>Date de Commande:</strong> <?= date('d/m/Y H:i', strtotime($order['date_commande'])) ?>
                </div>
                <div class="mb-3">
                    <strong>Statut:</strong> 
                    <span class="status-badge <?= $statusClass ?>">
                        <?= $order['statut'] ?>
                    </span>
                </div>
                <div class="mb-3">
                    <strong>Total:</strong> <?= number_format($order['total'], 2) ?> DH
                </div>
                <div class="mb-3">
                    <strong>Type de Livraison:</strong> <?= $order['type_livraison'] ?>
                </div>
                <div class="mb-3">
                    <strong>Date de Livraison:</strong> <?= date('d/m/Y', strtotime($order['date_livraison'])) ?>
                </div>
                <div class="mb-3">
                    <strong>Produits:</strong>
                    <ul>
                        <?php foreach ($order_items as $item): ?>
                            <li>
                                <?= $item['designation'] ?> (Quantité: <?= $item['quantite'] ?>, Prix: <?= number_format($item['prix_unitaire'], 2) ?> DH)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include('../Public/footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
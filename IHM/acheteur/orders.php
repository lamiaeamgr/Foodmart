<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

if (empty($_SESSION['list_orders_clt'])) {
    header("Location: ../../Gestion_Actions/acheteur/acheteur_actions.php?action=list_orders_clt");
    exit;
}
$orders = $_SESSION['list_orders_clt'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes</title>
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

.order-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    border: var(--cyber-border);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    backdrop-filter: blur(8px);
}

.order-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 2rem 0;
    position: relative;
}

.neon-text {
    font-size: 2.5rem;
    color: var(--neon-green);
    text-shadow: 0 0 15px rgba(125, 206, 148, 0.3);
    animation: flicker 3s infinite;
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

.order-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    margin-bottom: 1.5rem;
    border: var(--cyber-border);
    box-shadow: 0 4px 15px rgba(125, 206, 148, 0.05);
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.order-card:hover {
    transform: translateY(-5px) rotateZ(1deg);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.order-header-card {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    padding: 1rem 1.5rem;
    color: white;
    border-radius: 20px 20px 0 0;
}

.status-badge {
    background: rgba(255, 255, 255, 0.9);
    color: var(--dark-text);
    padding: 0.4rem 1.2rem;
    border-radius: 20px;
    font-weight: 600;
    border: var(--cyber-border);
}

.product-image {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid var(--neon-green);
    background: white;
    box-shadow: 0 2px 8px rgba(125, 206, 148, 0.1);
}

.section-title {
    color: var(--neon-green);
    font-weight: 600;
    margin-bottom: 1rem;
}

.total-price {
    font-size: 1.25rem;
    color: var(--dark-text);
    font-weight: 600;
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    padding: 0.8rem 1.5rem;
    border-radius: 12px;
    display: inline-block;
}

.bi-icon {
    color: var(--cream-citrus);
    margin-right: 0.5rem;
}

.product-details {
    background: rgba(255, 255, 255, 0.9);
    padding: 1rem;
    border-radius: 12px;
    border: var(--cyber-border);
}

@keyframes flicker {
    0% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
    50% { opacity: 0.9; text-shadow: 0 0 20px rgba(125, 206, 148, 0.4); }
    100% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
}

@media (max-width: 768px) {
    .order-container {
        margin: 1rem;
        padding: 1.5rem;
    }
    
    .neon-text {
        font-size: 2rem;
    }
    
    .order-card {
        margin-bottom: 2rem;
    }
}
    </style>
</head>
<body>
    <?php include('../Public/navbar.php'); ?>
    
    <div class="order-container">
        <div class="order-header">
            <h1 class="order-title neon-text">Historique des Commandes</h1>
        </div>

        <?php foreach ($orders as $order): ?>
        <div class="order-card">
            <div class="order-header-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-basket3"></i>
                        Commande #<?= $order['id'] ?>
                    </div>
                    <span class="status-badge"><?= $order['statut'] ?></span>
                </div>
            </div>
            
            <div class="p-4">
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="mb-3"><i class="bi bi-images"></i> Produits</h5>
                        <div class="product-item">
                            <img src="<?= $order['image_path'] ?>" class="product-image" alt="Produit">
                            <div class="product-details">
                                <div class="fw-bold"><?= $order['designation'] ?></div>
                                <small class="text-muted">Quantité: <?= $order['quantite'] ?></small>
                                <small class="text-muted">Prix <?= $order['prix_unitaire'] ?> DH</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <h5 class="mb-3"><i class="bi bi-calendar-date"></i> Date</h5>
                        <div class="fs-5 text-dark"><?= date('d/m/Y', strtotime($order['date_commande'])) ?></div>
                    </div>
                    
                    <div class="col-md-4">
                        <h5 class="mb-3"><i class="bi bi-cash"></i> Total</h5>
                        <div class="total-price"><?= number_format($order['total'], 2) ?> DH</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php include('../Public/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
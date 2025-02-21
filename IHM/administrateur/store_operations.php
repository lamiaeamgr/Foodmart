
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}
require_once '../../Acces_BD/models/store.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opérations du Magasin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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

.dashboard-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    border-left: 4px solid var(--neon-green);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    padding: 1.5rem;
    backdrop-filter: blur(8px);
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px) rotateZ(1deg);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.stat-card::before {
    content: '';
    position: absolute;
    width: 150%;
    height: 150%;
    background: radial-gradient(circle, 
        rgba(177, 156, 217, 0.1) 0%, 
        rgba(255, 215, 0, 0.05) 50%, 
        transparent 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-card:hover::before {
    opacity: 1;
}

.card-title {
    color: var(--dark-text);
    font-weight: 600;
}

.stat-number {
    color: var(--neon-green);
    font-weight: 700;
    font-size: 2.2rem;
    text-shadow: 0 2px 4px rgba(125, 206, 148, 0.1);
}

.section-card {
    border: var(--cyber-border);
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
}

.section-header {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    padding: 1.25rem;
}

.list-group-item {
    border: none;
    border-bottom: 1px solid rgba(93, 64, 55, 0.1);
    padding: 1.25rem;
    transition: all 0.3s ease;
    background: transparent;
}

.list-group-item:hover {
    background: rgba(125, 206, 148, 0.05);
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    background: var(--cream-citrus);
    color: var(--dark-text);
}

h1 {
    color: var(--neon-green);
    font-weight: 700;
    text-align: center;
    margin-bottom: 3rem;
    text-shadow: 0 2px 4px rgba(125, 206, 148, 0.1);
    font-size: 2.5rem;
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

@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }
    
    .stat-card {
        margin-bottom: 1.5rem;
    }
    
    h1 {
        font-size: 2rem;
    }
}

.border-left-success { border-left-color: var(--neon-green) !important; }
.border-left-danger { border-left-color: #B22222 !important; }
.text-danger { color: #B22222 !important; }
.bg-success { background-color: var(--neon-green) !important; }
.bg-warning { background-color: var(--cyber-gold) !important; }
.bg-danger { background-color: #B22222 !important; }
</style>
</head>
<body>
    <?php include('../Public/navbar.php'); ?>
    
    <div class="dashboard-container">
        <h1 class="text-center mb-5" style="color: var(--secondary);">
            <i class="bi bi-speedometer2"></i> Tableau de Bord du Magasin
        </h1>
        
        <!-- Statistics Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-box-seam"></i> Produits</h5>
                        <div class="stat-number"><?= $stats['total_products'] ?></div>
                        <small class="text-muted">Total en stock</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card border-left-danger">
                    <div class="card-body">
                        <h5 class="card-title text-danger"><i class="bi bi-exclamation-triangle"></i> Stock Faible</h5>
                        <div class="stat-number text-danger"><?= $stats['low_stock'] ?></div>
                        <small class="text-muted">À réapprovisionner</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-cart"></i> Commandes</h5>
                        <div class="stat-number"><?= $stats['pending_orders'] ?></div>
                        <small class="text-muted">En attente</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card border-left-success">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-percent"></i> Promotions</h5>
                        <div class="stat-number text-success"><?= $stats['active_promotions'] ?></div>
                        <small class="text-muted">Actives</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders and Low Stock -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Commandes Récentes</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($recent_orders->num_rows > 0): ?>
                            <div class="list-group">
                                <?php while($order = $recent_orders->fetch_assoc()): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Commande #<?= $order['id'] ?></h6>
                                            <small class="text-muted">Client: <?= $order['nom'] ?></small>
                                        </div>
                                        <div class="text-end">
                                            <span class="status-badge bg-<?= match($order['statut']) {
                                                'livrée' => 'success',
                                                'expédiée' => 'warning',
                                                default => 'danger'
                                            } ?>">
                                                <?= ucfirst($order['statut']) ?>
                                            </span>
                                            <div class="mt-1 fw-bold"><?= number_format($order['total'], 2) ?> MAD</div>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">Aucune commande récente</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header bg-warning">
                        <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Stock Critique</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($low_stock_products->num_rows > 0): ?>
                            <div class="list-group">
                                <?php while($product = $low_stock_products->fetch_assoc()): ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div><?= $product['designation'] ?></div>
                                        <span class="badge bg-danger p-2"><?= $product['quantite_stock'] ?> restants</span>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">Aucun produit en stock critique</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('../Public/footer.php'); ?>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != 'vendeur') {
    header("Location: ../Public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Vendeur</title>
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

.feature-card {
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    border: var(--cyber-border);
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    min-height: 250px;
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    position: relative;
    overflow: hidden;
}

.feature-card:hover {
    transform: translateY(-10px) rotateZ(1deg);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.feature-card::before {
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

.feature-card:hover::before {
    opacity: 1;
}

.card-icon {
    font-size: 2.5rem;
    color: var(--neon-green);
    margin-bottom: 1rem;
    filter: drop-shadow(0 2px 4px rgba(125, 206, 148, 0.1));
}

.card-hover-effect {
    transition: opacity 0.3s;
    text-decoration: none !important;
}

.card-hover-effect:hover {
    opacity: 0.9;
}

.portal-header {
    text-align: center;
    margin-bottom: 5rem;
    position: relative;
}

.neon-text {
    font-size: 2.8rem;
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

.badge {
    background: var(--neon-green);
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.feature-card:hover .badge {
    background: var(--cream-citrus);
    color: var(--dark-text);
}

@keyframes flicker {
    0% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
    50% { opacity: 0.9; text-shadow: 0 0 20px rgba(125, 206, 148, 0.4); }
    100% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
}

@media (max-width: 768px) {
    .neon-text {
        font-size: 2rem;
    }
    
    .feature-card {
        min-height: 200px;
    }
}
</style>
</head>
<body class="bg-light">
    <?php include('../Public/navbar.php'); ?>
    
    <div class="container py-5">
        <h1 class="text-center mb-5 display-4 fw-bold text-success">Tableau de Bord Vendeur</h1>
        
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-3">
                <a href="products.php" class="card-hover-effect">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-box card-icon"></i>
                            <h3 class="h4 mb-3">Produits</h3>
                            <p class="text-muted">Gérez votre inventaire et ajoutez de nouveaux produits</p>
                            <span class="badge bg-primary">Gérer →</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <a href="reports_operations.php" class="card-hover-effect">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-graph-up card-icon"></i>
                            <h3 class="h4 mb-3">Rapports</h3>
                            <p class="text-muted">Analysez vos performances et opérations</p>
                            <span class="badge bg-success">Voir →</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <a href="orders.php" class="card-hover-effect">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-cart-check card-icon"></i>
                            <h3 class="h4 mb-3">Commandes</h3>
                            <p class="text-muted">Suivez et gérez les commandes clients</p>
                            <span class="badge bg-warning text-dark">Vérifier →</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <a href="promotions.php" class="card-hover-effect">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-percent card-icon"></i>
                            <h3 class="h4 mb-3">Promotions</h3>
                            <p class="text-muted">Créez des offres spéciales et promotions</p>
                            <span class="badge bg-info">Configurer →</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <?php include('../Public/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
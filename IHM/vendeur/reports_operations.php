<?php
session_start();
require_once '../../Acces_BD/Models/report_vendeur.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Vendeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../Public/css/style.css">
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

.container {
    max-width: 1400px;
    padding: 2rem 0;
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

.card {
    border: var(--cyber-border);
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.card:hover {
    transform: translateY(-5px) rotateZ(1deg);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.card-header {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    color: white;
    border-radius: 20px 20px 0 0 !important;
}

.card-title i {
    color: var(--cream-citrus);
    margin-right: 0.5rem;
}

.display-6 {
    color: var(--dark-text);
    font-weight: 700;
}

.text-muted {
    color: var(--cream-citrus) !important;
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
    
    .card {
        margin-bottom: 1.5rem;
    }
}
</style>

</head>
<body class="bg-light">
    <?php include('../Public/navbar.php'); ?>
    
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h2 class="mb-3">Bienvenue, <?= $vendor['nom'] ?>!</h2>
                        <p class="lead">Email: <?= $vendor['email'] ?></p>
                        <p class="text-muted">Téléphone: <?= $vendor['telephone'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-currency-exchange"></i> Chiffre d'Affaires</h5>
                        <h2 class="display-6">
                            <?= number_format(array_sum($sales_data['totals'] ?? []), 2) ?> MAD
                        </h2>
                        <small class="text-muted">Total cette année</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-cart-check"></i> Commandes</h5>
                        <h2 class="display-6"><?= count($sales_data['totals'] ?? []) ?></h2>
                        <small class="text-muted">Commandes traitées</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-boxes"></i> Produits</h5>
                        <h2 class="display-6"><?= array_sum($counts ?? []) ?></h2>
                        <small class="text-muted">Produits en stock</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-star"></i> Satisfaction</h5>
                        <h2 class="display-6">4.8/5</h2>
                        <small class="text-muted">Note moyenne</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-graph-up"></i> Ventes Mensuelles</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Répartition des Catégories</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('../Public/footer.php'); ?>

    <script>
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode($sales_data['months'] ?? []) ?>,
                datasets: [{
                    label: 'Ventes Mensuelles (MAD)',
                    data: <?= json_encode($sales_data['totals'] ?? []) ?>,
                    borderColor: '#0d6efd',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(13, 110, 253, 0.05)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        // Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($categories ?? []) ?>,
                datasets: [{
                    label: 'Produits par Catégorie',
                    data: <?= json_encode($counts ?? []) ?>,
                    backgroundColor: [
                        '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', 
                        '#9966ff', '#ff9f40', '#c9cbcf'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}
require_once '../../Acces_BD/models/report_admin.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports de Ventes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
:root {
    --neon-green: #7dce94;
    --cyber-gold: #ffd700;
    --cream-citrus: #FFD8A8;
    --cyber-bg-gradient: radial-gradient(circle at center, #f8fff9 0%, #fff5e6 100%);
    --cyber-border: 2px solid #FFE4C4;
}

body {
    background: var(--cyber-bg-gradient);
    min-height: 100vh;
}

.report-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 2rem;
}

.card {
    border: var(--cyber-border);
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.card:hover {
    transform: translateY(-5px) rotateZ(1deg);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.card-header {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    color: #5d4037;
    border-radius: 20px 20px 0 0 !important;
    border: none;
}

h1 {
    color: var(--neon-green);
    font-weight: 700;
    text-align: center;
    margin-bottom: 3rem;
    text-shadow: 0 2px 4px rgba(125, 206, 148, 0.1);
    font-size: 2.5rem;
}

.card-header h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: white;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

canvas {
    max-height: 400px;
    margin: 1rem 0;
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
    .report-container {
        padding: 1rem;
    }
    
    .card {
        margin-bottom: 1.5rem;
    }
    
    h1 {
        font-size: 2rem;
    }
}
</style>

</head>
<body class="bg-light">
    <?php include('../Public/navbar.php'); ?>

    <div class="report-container">
        <h1><i class="bi bi-graph-up"></i> Rapports de Ventes</h1>

        <!-- Ventes sur la période -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><i class="bi bi-calendar-week"></i> Ventes Totales sur Période</h3>
            </div>
            <div class="card-body">
                <canvas id="ventesPeriodeChart"></canvas>
            </div>
        </div>

        <!-- Ventes par catégorie -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><i class="bi bi-folder"></i> Répartition par Catégorie</h3>
            </div>
            <div class="card-body">
                <canvas id="ventesCategoriesChart"></canvas>
            </div>
        </div>

        <!-- Top produits -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><i class="bi bi-trophy"></i> Produits les Plus Vendus</h3>
            </div>
            <div class="card-body">
                <canvas id="topProduitsChart"></canvas>
            </div>
        </div>

        <!-- Achats clients -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><i class="bi bi-people"></i> Historique des Achats Clients</h3>
            </div>
            <div class="card-body">
                <canvas id="achatsClientsChart"></canvas>
            </div>
        </div>

        <!-- Utilisation coupons -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><i class="bi bi-ticket-perforated"></i> Utilisation des Points de Fidélité</h3>
            </div>
            <div class="card-body">
                <canvas id="utilisationCouponsChart"></canvas>
            </div>
        </div>
    </div>
    <?php include('../Public/footer.php'); ?>

    <script>
        // Color scheme
        const warningPalette = {
            orange: '#7dce94',
            darkOrange: '#FFD8A8',
            gold: '#FFD700',
            red: '#5d4037',
            lightOrange: '#fff5e6'
        };

        // Common chart options
        const chartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: warningPalette.darkOrange,
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: warningPalette.lightOrange },
                    ticks: { color: warningPalette.darkOrange }
                },
                y: {
                    grid: { color: warningPalette.lightOrange },
                    ticks: { color: warningPalette.darkOrange }
                }
            }
        };

        // Ventes sur la période
        new Chart(document.getElementById('ventesPeriodeChart'), {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($ventesPeriode, 'date_vente')) ?>,
                datasets: [{
                    label: 'Ventes Totales (MAD)',
                    data: <?= json_encode(array_column($ventesPeriode, 'total')) ?>,
                    borderColor: warningPalette.orange,
                    backgroundColor: warningPalette.lightOrange,
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: chartOptions
        });

        // Ventes par catégorie
        new Chart(document.getElementById('ventesCategoriesChart'), {
            type: 'pie',
            data: {
                labels: <?= json_encode(array_column($categoriesData, 'categorie')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($categoriesData, 'total')) ?>,
                    backgroundColor: [
                        warningPalette.orange,
                        warningPalette.gold,
                        warningPalette.darkOrange,
                        warningPalette.red,
                        warningPalette.lightOrange
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Top produits
        new Chart(document.getElementById('topProduitsChart'), {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($topProduits, 'designation')) ?>,
                datasets: [{
                    label: 'Unités Vendues',
                    data: <?= json_encode(array_column($topProduits, 'total_quantite')) ?>,
                    backgroundColor: warningPalette.orange,
                    borderColor: warningPalette.darkOrange,
                    borderWidth: 1
                }]
            },
            options: chartOptions
        });

        // Achats clients
        new Chart(document.getElementById('achatsClientsChart'), {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($achatsClients, 'nom')) ?>,
                datasets: [{
                    label: 'Dépense Totale (MAD)',
                    data: <?= json_encode(array_column($achatsClients, 'total')) ?>,
                    backgroundColor: warningPalette.gold,
                    borderColor: warningPalette.darkOrange,
                    borderWidth: 1
                }]
            },
            options: chartOptions
        });

        // Utilisation coupons
        new Chart(document.getElementById('utilisationCouponsChart'), {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($utilisationCoupons, 'nom')) ?>,
                datasets: [
                    {
                        label: 'Points Gagnés',
                        data: <?= json_encode(array_column($utilisationCoupons, 'points_gagnes')) ?>,
                        backgroundColor: warningPalette.orange
                    },
                    {
                        label: 'Points Utilisés',
                        data: <?= json_encode(array_column($utilisationCoupons, 'points_utilises')) ?>,
                        backgroundColor: warningPalette.red
                    }
                ]
            },
            options: {
                ...chartOptions,
                scales: {
                    x: { stacked: true },
                    y: { stacked: true }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
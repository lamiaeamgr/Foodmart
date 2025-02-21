<?php
session_start();
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
    <title>Accueil Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
   <style>
:root {
    --neon-green: #7dce94;
    --cyber-gold: #ffd700;
    --cream-citrus: #FFD8A8;
    --cyber-bg-gradient: radial-gradient(circle at center, #f8fff9 0%, #fff5e6 100%);
    --cyber-border: 2px solid #FFE4C4;
}

.admin-portal {
    background: var(--cyber-bg-gradient);
    min-height: 100vh;
    padding: 4rem 0;
}

.admin-card {
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.95);
    border: var(--cyber-border);
    min-height: 300px;
    overflow: hidden;
    position: relative;
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
}

.admin-card:hover {
    transform: translateY(-10px) rotateZ(1deg);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.card-icon-admin {
    font-size: 3.5rem;
    margin-bottom: 1.5rem;
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
}

.hologram-effect {
    position: absolute;
    width: 140%;
    height: 140%;
    background: conic-gradient(
        from 0deg at 50% 50%,
        transparent 0%,
        var(--neon-green) 15%,
        var(--cyber-gold) 30%,
        var(--cream-citrus) 45%,
        transparent 60%
    );
    animation: rotate-beam 6s linear infinite;
    opacity: 0.1;
    mix-blend-mode: soft-light;
    z-index: 0;
}

.admin-badge {
    position: absolute;
    bottom: 20px;
    right: 20px;
    font-size: 1.1em;
    padding: 8px 15px;
    border-radius: 8px;
    background: var(--neon-green);
    color: white;
    transition: all 0.3s ease;
}

.admin-card:hover .admin-badge {
    background: var(--cream-citrus);
    color: #5d4037;
}

.portal-header {
    text-align: center;
    margin-bottom: 5rem;
    position: relative;
}

.neon-text {
    font-size: 3.5rem;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: var(--neon-green);
    text-shadow: 0 0 15px rgba(125, 206, 148, 0.3);
    animation: flicker 3s infinite;
}

@keyframes rotate-beam {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes flicker {
    0% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
    50% { opacity: 0.9; text-shadow: 0 0 20px rgba(125, 206, 148, 0.4); }
    100% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
}

.card-hover-admin {
    transition: opacity 0.3s;
    text-decoration: none !important;
}

.card-hover-admin:hover {
    opacity: 0.9;
}

.card-body {
    position: relative;
    z-index: 1;
    padding: 2rem !important;
}

h3 {
    color: #5d4037;
    font-weight: 600;
    margin-bottom: 1rem !important;
}

p.text-muted {
    color: #8a7f78 !important;
    line-height: 1.6;
}
</style>

</head>
<body class="bg-light">
    <?php include('../Public/navbar.php'); ?>
    
    <div class="container py-5">
        <h1 class="text-center mb-5 display-4 fw-bold text-dark">Panel d'Administration</h1>
        
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4">
                <a href="user_management.php" class="card-hover-admin">
                    <div class="card admin-card h-100 p-4">
                        <div class="card-body position-relative">
                            <i class="bi bi-people-fill card-icon-admin"></i>
                            <h3 class="h4 mb-3">Gestion Utilisateurs</h3>
                            <p class="text-muted">Gérez les comptes utilisateurs, permissions et rôles</p>
                            <span class="admin-badge bg-primary text-white">Accéder <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a href="reports.php" class="card-hover-admin">
                    <div class="card admin-card h-100 p-4">
                        <div class="card-body position-relative">
                            <i class="bi bi-bar-chart-line card-icon-admin"></i>
                            <h3 class="h4 mb-3">Analytiques</h3>
                            <p class="text-muted">Suivez les statistiques et performances globales</p>
                            <span class="admin-badge bg-success text-white">Voir <i class="bi bi-arrow-up-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <a href="store_operations.php" class="card-hover-admin">
                    <div class="card admin-card h-100 p-4">
                        <div class="card-body position-relative">
                            <i class="bi bi-building-gear card-icon-admin"></i>
                            <h3 class="h4 mb-3">Opérations Magasin</h3>
                            <p class="text-muted">Supervisez les activités et opérations quotidiennes</p>
                            <span class="admin-badge bg-info text-white">Gérer <i class="bi bi-gear"></i></span>
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
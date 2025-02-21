<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

$users = isset($_SESSION['list_users']) ? $_SESSION['list_users'] : null;
if (!$users) {
    header("Location: ../../Gestion_Actions/administrateur/admin_actions.php?action=list_users");
    exit;
}

// Filtrer les utilisateurs par rôle
$selected_role = isset($_GET['role']) ? $_GET['role'] : 'all';
$filtered_users = ($selected_role === 'all') 
    ? $users 
    : array_filter($users, fn($u) => $u['type'] === $selected_role);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
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

.container {
    max-width: 1400px;
    padding: 2rem 0;
}

.user-card {
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.95);
    border: var(--cyber-border);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    overflow: hidden;
    position: relative;
    backdrop-filter: blur(8px);
}

.user-card:hover {
    transform: translateY(-5px) rotateZ(1deg);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.user-avatar {
    height: 120px;
    background: linear-gradient(135deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
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
}

.user-avatar i {
    font-size: 3.5rem;
    color: white;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}

.role-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 0.9rem;
    padding: 5px 15px;
    border-radius: 20px;
    background: var(--cream-citrus);
    color: var(--dark-text);
    font-weight: 600;
}

.filter-control {
    background: rgba(255, 216, 168, 0.2);
    border: var(--cyber-border);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

h1 {
    color: var(--neon-green);
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(125, 206, 148, 0.1);
}

.btn-primary {
    background: var(--neon-green);
    border: none;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--cream-citrus);
    color: var(--dark-text);
    transform: translateY(-2px);
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

@keyframes rotate-beam {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.bg-danger { background: #B22222 !important; }
.bg-warning { background: var(--cyber-gold) !important; }
.bg-success { background: var(--neon-green) !important; }
</style>
</head>
<body class="bg-light">
    <?php include('../Public/navbar.php'); ?>
    
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5 fw-bold text-primary">Gestion des Utilisateurs</h1>
            <a href="add_user.php" class="btn btn-primary btn-lg">
                <i class="bi bi-person-plus"></i> Ajouter
            </a>
        </div>

        <!-- Filtre par rôle -->
        <div class="filter-control">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label class="form-label fw-bold">Filtrer par rôle :</label>
                </div>
                <div class="col-auto">
                    <select name="role" class="form-select" onchange="this.form.submit()">
                        <option value="all" <?= $selected_role === 'all' ? 'selected' : '' ?>>Tous les rôles</option>
                        <option value="admin" <?= $selected_role === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                        <option value="vendeur" <?= $selected_role === 'vendeur' ? 'selected' : '' ?>>Vendeur</option>
                        <option value="client" <?= $selected_role === 'client' ? 'selected' : '' ?>>Client</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="row g-4">
            <?php foreach($filtered_users as $user): ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="user-card position-relative">
                    <div class="user-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div class="card-body p-4">
                        <span class="badge role-badge 
                            <?= match($user['type']) {
                                'admin' => 'bg-danger',
                                'vendeur' => 'bg-warning text-dark',
                                'client' => 'bg-success',
                                default => 'bg-secondary'
                            } ?>">
                            <?= ucfirst($user['type']) ?>
                        </span>
                        
                        <h3 class="h5 mb-3"><?= htmlspecialchars($user['nom']) ?></h3>
                        
                        <div class="user-info mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-envelope me-2"></i>
                                <a href="mailto:<?= htmlspecialchars($user['email']) ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($user['email']) ?>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="../../Gestion_Actions/administrateur/admin_actions.php?action=delete_user&id=<?= $user['id'] ?>&user_type=<?= $user['type'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                <i class="bi bi-trash"></i> Supprimer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include('../Public/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
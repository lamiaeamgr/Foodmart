<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

$promotions = isset($_SESSION['list_promotions']) ? $_SESSION['list_promotions'] : null;

if (!$promotions) {
    header("Location: ../../Gestion_Actions/vendeur/vendeur_actions.php?action=list_promotions");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Promotions</title>
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

.promotion-container {
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

.table-custom {
    border-collapse: separate;
    border-spacing: 0 0.75rem;
    margin: 1.5rem 0;
}

.table-custom thead {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(125, 206, 148, 0.2);
}

.table-custom th {
    border: none;
    padding: 1.2rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.table-custom td {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid var(--cream-citrus);
    padding: 1rem;
    vertical-align: middle;
    color: var(--dark-text);
}

.table-custom tr {
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    border-radius: 10px;
    overflow: hidden;
}

.table-custom tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(125, 206, 148, 0.1);
}

.btn-add {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    color: white;
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(125, 206, 148, 0.3);
    color: var(--dark-text);
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

.btn-delete {
    background: rgba(178, 34, 34, 0.2);
    color: #B22222;
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(125, 206, 148, 0.1);
}

@media (max-width: 768px) {
    .promotion-container {
        margin: 2rem 1rem;
        padding: 1.5rem;
    }
    
    .table-custom thead {
        display: none;
    }
    
    .table-custom tr {
        display: block;
        margin-bottom: 1.5rem;
        background: rgba(255, 255, 255, 0.9);
        border: var(--cyber-border);
        border-radius: 15px;
    }
    
    .table-custom td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.8rem;
        background: transparent;
        border: none;
    }
    
    .table-custom td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--neon-green);
        margin-right: 1rem;
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
    
    <div class="promotion-container">
        <h1><i class="bi bi-percent"></i> Gestion des Promotions</h1>
        
        <a href="add_promotion.php" class="btn btn-add mb-4">
            <i class="bi bi-plus-circle"></i> Ajouter une Promotion
        </a>

        <table class="table table-custom">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produit</th>
                    <th>Réduction</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promotions as $promotion): ?>
                <tr>
                    <td data-label="ID"><?= $promotion['id'] ?></td>
                    <td data-label="Produit"><?= $promotion['produit_id'] ?></td>
                    <td data-label="Réduction"><?= $promotion['reduction'] ?>%</td>
                    <td data-label="Date Début"><?= $promotion['date_debut'] ?></td>
                    <td data-label="Date Fin"><?= $promotion['date_fin'] ?></td>
                    <td data-label="Actions">
                        <a href="../../Gestion_Actions/vendeur/vendeur_actions.php?action=delete_promotion&id=<?= $promotion['id'] ?>" 
                           class="btn btn-action btn-delete">
                            <i class="bi bi-trash"></i> Supprimer
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include('../Public/footer.php'); ?>
</body>
</html>
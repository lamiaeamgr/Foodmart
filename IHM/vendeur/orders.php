<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != 'vendeur') {
    header("Location: ../../IHM/Public/login.php");
    exit;
}

if (empty($_SESSION['list_orders'])) {
    header("Location: ../../Gestion_Actions/vendeur/vendeur_actions.php?action=list_orders");
    exit;
}
$orders = $_SESSION['list_orders'];
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
    
    <div class="orders-container">
        <h1><i class="bi bi-receipt"></i> Gestion des Commandes</h1>

        <table class="table table-custom">
            <thead>
                <tr>
                    <th>ID Commande</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): 
                    $statusClass = match(strtolower($order['statut'])) {
                        'livrée' => 'status-delivered',
                        'annulée' => 'status-cancelled',
                        default => 'status-pending'
                    };
                ?>
                <tr>
                    <td data-label="ID Commande"><?= $order['id'] ?></td>
                    <td data-label="Client"><?= $order['client_id'] ?></td>
                    <td data-label="Date"><?= date('d/m/Y', strtotime($order['date_commande'])) ?></td>
                    <td data-label="Statut">
                        <form action="../../Gestion_Actions/vendeur/vendeur_actions.php?action=update_order_status" method="POST" class="d-inline">
                            <input type="hidden" name="commande_id" value="<?= $order['id'] ?>">
                            <select name="statut" class="form-select" onchange="this.form.submit()">
                                <option value="en attente" <?= $order['statut'] == 'en attente' ? 'selected' : '' ?>>En attente</option>
                                <option value="expédiée" <?= $order['statut'] == 'expédiée' ? 'selected' : '' ?>>Expédiée</option>
                                <option value="livrée" <?= $order['statut'] == 'livrée' ? 'selected' : '' ?>>Livrée</option>
                            </select>
                        </form>
                    </td>
                    <td data-label="Total"><?= number_format($order['total'], 2) ?> DH</td>
                    <td data-label="Actions">
                        <a href='order_details.php?id=<?= $order['id'] ?>' 
                           class='btn btn-action btn-details'>
                            <i class="bi bi-eye"></i> Détails
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
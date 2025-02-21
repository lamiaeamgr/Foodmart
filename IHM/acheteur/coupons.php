<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}

// Retrieve coupons from the session set by the actions layer
$coupons = isset($_SESSION['coupons']) ? $_SESSION['coupons'] : [];

// Optionally, you might want to clear the session variable once it is used:
// unset($_SESSION['coupons']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Coupons</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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

.coupon-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    border: var(--cyber-border);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    backdrop-filter: blur(8px);
}

.neon-text {
    color: var(--neon-green);
    text-shadow: 0 0 15px rgba(125, 206, 148, 0.3);
    animation: flicker 3s infinite;
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 2rem;
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

.coupon-ticket {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    margin-bottom: 2rem;
    padding: 1.5rem;
    position: relative;
    border: var(--cyber-border);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.coupon-ticket:hover {
    transform: translateY(-5px) rotateZ(1deg);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.coupon-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid var(--neon-green);
    padding-bottom: 1rem;
    margin-bottom: 1rem;
}

.coupon-id {
    font-size: 1.5rem;
    color: var(--neon-green);
    font-weight: 700;
}

.coupon-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: rgba(125, 206, 148, 0.05);
    border-radius: 10px;
    border: var(--cyber-border);
}

.stat-label {
    color: var(--dark-text);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--neon-green);
}

.expiration {
    text-align: center;
    font-size: 0.9rem;
    color: var(--cream-citrus);
    margin: 1rem 0;
}

.use-btn {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    color: white;
    width: 100%;
    padding: 1rem;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.use-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(125, 206, 148, 0.3);
    color: var(--dark-text);
}

.coupon-perforation {
    position: absolute;
    left: -10px;
    top: 50%;
    transform: translateY(-50%);
    height: 80%;
    width: 20px;
    background: repeating-linear-gradient(to bottom,
            transparent 0,
            transparent 10px,
            var(--neon-green) 10px,
            var(--neon-green) 20px);
}

.empty-coupons {
    text-align: center;
    padding: 3rem;
    color: var(--cream-citrus);
    font-size: 1.2rem;
    border: 2px dashed var(--neon-green);
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.9);
}

@keyframes flicker {
    0% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
    50% { opacity: 0.9; text-shadow: 0 0 20px rgba(125, 206, 148, 0.4); }
    100% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
}

@media (max-width: 768px) {
    .coupon-container {
        margin: 1rem;
        padding: 1.5rem;
    }
    
    .coupon-stats {
        grid-template-columns: 1fr;
    }
    
    .neon-text {
        font-size: 2rem;
    }
}
</style>
</head>

<body>
    <?php include('../Public/navbar.php'); ?>
    <div class="coupon-container">
        <h1 class="coupon-title"><i class="bi bi-ticket-perforated"></i> Mes Coupons</h1>

        <?php if (empty($coupons)): ?>
            <div class="empty-coupons">
                <i class="bi bi-emoji-frown" style="font-size: 2rem"></i><br>
                Aucun coupon disponible
            </div>
        <?php else: ?>
            <?php foreach ($coupons as $coupon): ?>
                <div class="coupon-ticket">
                    <div class="coupon-perforation"></div>
                    <div class="coupon-header">
                        <div class="coupon-id">#<?= htmlspecialchars($coupon['id']) ?></div>
                        <i class="bi bi-gift" style="color: #c62828; font-size: 1.5rem"></i>
                    </div>

                    <div class="coupon-stats">
                        <div class="stat-item">
                            <div class="stat-label">Points Gagnés</div>
                            <div class="stat-value"><?= htmlspecialchars($coupon['points_gagnes']) ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Points Utilisés</div>
                            <div class="stat-value"><?= htmlspecialchars($coupon['points_utilises']) ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Solde</div>
                            <div class="stat-value">
                                <?= htmlspecialchars($coupon['points_gagnes'] - $coupon['points_utilises']) ?></div>
                        </div>
                    </div>

                    <div class="expiration">
                        <i class="bi bi-clock-history"></i> Expire le <?= htmlspecialchars($coupon['date_expiration']) ?>
                    </div>

                    <a href='Gestion_Actions/acheteur/acheteur_actions.php?action=use_coupon&coupon_id=<?= urlencode($coupon['id']) ?>'
                        class='use-btn'>
                        <i class="bi bi-currency-exchange"></i> Utiliser ce coupon
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>

</html>
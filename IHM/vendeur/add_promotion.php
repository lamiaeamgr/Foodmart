<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}
$products = isset($_SESSION['list_products']) ? $_SESSION['list_products'] : null;

if (!$products) {
    header("Location: ../../Gestion_Actions/vendeur/vendeur_actions.php?action=list_products");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Promotion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

.promotion-container {
    max-width: 700px;
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
    position: relative;
    text-align: center;
    text-shadow: 0 2px 4px rgba(125, 206, 148, 0.1);
}

h1::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
}

.form-group {
    margin-bottom: 1.8rem;
    position: relative;
}

.form-group label {
    color: var(--dark-text);
    font-weight: 600;
    margin-bottom: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.form-control {
    border: 2px solid var(--cream-citrus);
    border-radius: 10px;
    padding: 0.8rem 1.2rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
}

.form-control:focus {
    border-color: var(--neon-green);
    box-shadow: 0 0 0 3px rgba(125, 206, 148, 0.2);
}

.btn-submit {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    width: 100%;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(125, 206, 148, 0.3);
    color: var(--dark-text);
}

.form-group i {
    color: var(--neon-green);
    font-size: 1.2rem;
}

.date-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
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
    .promotion-container {
        margin: 2rem 1rem;
        padding: 1.5rem;
    }
    
    h1 {
        font-size: 1.8rem;
    }
    
    .date-group {
        grid-template-columns: 1fr;
    }
}

@keyframes hologram-pulse {
    0% { opacity: 0.8; }
    50% { opacity: 0.4; }
    100% { opacity: 0.8; }
}
</style>
</head>
<body>
    <?php include('../Public/navbar.php'); ?>
    
    <div class="promotion-container">
        <h1><i class="bi bi-percent"></i> Ajouter une Promotion</h1>
        <form action="../../Gestion_Actions/vendeur/vendeur_actions.php?action=add_promotion" method="POST">
            <div class="form-group">
                <label for="produit_id"><i class="bi bi-box-seam"></i> Produit</label>
                <select class="form-control" id="produit_id" name="produit_id" required>
                    <?php
                    $products = $_SESSION['list_products'];
                    foreach ($products as $product) {
                        echo "<option value='{$product['id']}'>{$product['designation']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="reduction"><i class="bi bi-graph-down"></i> Réduction (%)</label>
                <input type="number" step="0.01" class="form-control" id="reduction" name="reduction" required>
            </div>
            
            <div class="date-group">
                <div class="form-group">
                    <label for="date_debut"><i class="bi bi-calendar-plus"></i> Date Début</label>
                    <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                </div>
                
                <div class="form-group">
                    <label for="date_fin"><i class="bi bi-calendar-x"></i> Date Fin</label>
                    <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-submit mt-3">Activer la Promotion <i class="bi bi-lightning-charge"></i></button>
        </form>
    </div>

    <?php include('../Public/footer.php'); ?>
</body>
</html>
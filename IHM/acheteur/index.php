<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}
$products = isset($_SESSION['list_products']) ? $_SESSION['list_products'] : null;

if (!$products) {
    header("Location: ../../Gestion_Actions/acheteur/acheteur_actions.php?action=list_products");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Acheteur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
    <link rel="stylesheet" type="text/css" href="../Public/css/style.css">
    <style>
        .client-portal {
    background: radial-gradient(circle at center, #f8fff9 0%, #fff5e6 100%);
    min-height: 100vh;
    padding: 4rem 0;
    font-family: 'Poppins', sans-serif;
}

.portal-header {
    text-align: center;
    margin-bottom: 5rem;
    position: relative;
    padding: 2rem;
}

.neon-text {
    font-size: 4rem;
    text-transform: uppercase;
    letter-spacing: 4px;
    color: #7dce94;
    text-shadow: 0 0 15px rgba(125, 206, 148, 0.3),
                 0 0 25px rgba(177, 156, 217, 0.2),
                 0 0 35px rgba(255, 215, 0, 0.1);
    animation: flicker 3s infinite;
}

.glowing-text {
    color: #ffd700;
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
    display: inline-block;
    transition: transform 0.3s ease;
}

.subtitle-shimmer {
    color: #b19cd9;
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
        #7dce94 30%, 
        #b19cd9 70%, 
        transparent 100%);
    transform: translateX(-50%);
    border-radius: 2px;
}

.cyber-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2.5rem;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.cyber-card {
    position: relative;
    height: 400px;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    border: 2px solid #d1c4e9;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
}

.cyber-card::before {
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

.cyber-card:hover {
    transform: translateY(-8px) rotateZ(1deg);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.cyber-card:hover::before {
    opacity: 1;
}

.hologram-icon {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 3rem auto 2rem;
    background: linear-gradient(45deg, 
        #f0fff4 0%, 
        #fff3e0 100%);
    border-radius: 50%;
    display: grid;
    place-items: center;
    box-shadow: 0 0 30px rgba(125, 206, 148, 0.1);
}

.hologram-icon i {
    font-size: 3.5rem;
    color: #81c784;
    z-index: 2;
    transition: transform 0.3s ease;
}

.laser-beam {
    position: absolute;
    width: 140%;
    height: 140%;
    background: conic-gradient(
        from 0deg at 50% 50%,
        transparent 0%,
        #7dce94 15%,
        #ffd700 30%,
        #b19cd9 45%,
        transparent 60%
    );
    animation: rotate-beam 6s linear infinite;
    opacity: 0.2;
    mix-blend-mode: soft-light;
}

.cyber-title {
    text-align: center;
    color: #5d4037;
    font-size: 1.8rem;
    font-weight: 600;
    letter-spacing: 1px;
    position: relative;
    margin-top: 1.5rem;
}

.cyber-title::after {
    content: '';
    position: absolute;
    bottom: -12px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, 
        #7dce94 0%, 
        #ffd700 50%, 
        #b19cd9 100%);
    border-radius: 2px;
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

@media (max-width: 768px) {
    .neon-text {
        font-size: 2.5rem;
    }
    
    .cyber-card {
        height: 350px;
    }
    
    .hologram-icon {
        width: 90px;
        height: 90px;
    }
    
    .hologram-icon i {
        font-size: 2.5rem;
    }
}

.fruit-decoration {
    position: fixed;
    width: 50px;
    height: 50px;
    background: rgba(255, 215, 0, 0.1);
    border-radius: 50%;
    filter: blur(20px);
    z-index: -1;
}
    </style>
</head>

<body class="bg-warning">
    <?php include('../Public/navbar.php'); ?>
    <div class="client-portal">
    <div class="container">
        <!-- En-tête holographique -->
        <div class="portal-header">
            <h1 class="neon-text flicker">Bienvenue, <span class="glowing-text"><?= explode('@', $_SESSION['email'])[0] ?></span></h1>
            <p class="subtitle-shimmer">Votre espace personnel</p>
        </div>

        <!-- Cartes d'interface futuristes -->
        <div class="cyber-grid">
            <a href="orders.php" class="cyber-card orders-card">
                <div class="card-glow"></div>
                <div class="card-content">
                    <div class="hologram-icon">
                        <div class="laser-beam"></div>
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h3 class="cyber-title">Commandes</h3>
                </div>
            </a>

            <a href="cart.php" class="cyber-card cart-card">
                <div class="card-glow"></div>
                <div class="card-content">
                    <div class="hologram-icon">
                        <div class="laser-beam"></div>
                        <i class="bi bi-cart3"></i>
                    </div>
                    <h3 class="cyber-title">Panier</h3>
                </div>
            </a>

            <a href="coupons.php" class="cyber-card coupons-card">
                <div class="card-glow"></div>
                <div class="card-content">
                    <div class="hologram-icon">
                        <div class="laser-beam"></div>
                        <i class="bi bi-percent"></i>
                    </div>
                    <h3 class="cyber-title">Coupons</h3>
                </div>
            </a>
        </div>
    </div>
</div>




    <section class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bootstrap-tabs product-tabs">
                        <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                            <h3>Nos Produits</h3>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-all" role="tabpanel">
                                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                    <?php foreach ($products as $product): ?>
                                        <div class="col">
                                            <div class="product-item" data-product-id="<?= $product['id']; ?>">
                                                <?php if ($product['promotion'] > 0): ?>
                                                    <span class="badge bg-success position-absolute m-3">-<?= intval($product['promotion']) ?>%</span>
                                                <?php endif; ?>
                                                <figure>
                                                    <a href="#" title="<?= htmlspecialchars($product['designation']); ?>">
                                                        <img src="<?= htmlspecialchars($product['image_path']); ?>" alt="<?= htmlspecialchars($product['designation']); ?>" class="tab-image">
                                                    </a>
                                                </figure>
                                                <h3><?= htmlspecialchars($product['designation']); ?></h3>
                                                <span class="qty">Quantité: <?= htmlspecialchars($product['quantite_stock']); ?></span>
                                                <span class="price">Prix: <?= htmlspecialchars($product['prix']); ?> MAD</span>
                                                <form action="../../Gestion_Actions/acheteur/acheteur_actions.php?action=add_to_cart" method="POST">
                                                    <input type="hidden" name="produit_id" value="<?= $product['id']; ?>">
                                                    <div class="input-group product-qty">
                                                        <!-- <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">-</button> -->
                                                        <input type="number" name="quantite" class="form-control input-number" min="1">
                                                        <!-- <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">+</button> -->
                                                    </div>
                                                    <button type="submit" class="btn btn-success mt-2 w-100">Ajouter au panier</button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('../Public/footer.php'); ?>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.cyber-card');
    
    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.setProperty('--x', `${x}px`);
            card.style.setProperty('--y', `${y}px`);
        });
    });
});
</script>
    <!-- <script>
        document.querySelectorAll('.quantity-right-plus').forEach(button => {
            button.addEventListener('click', function () {
                const quantityInput = this.closest('.product-qty').querySelector('input');
                let currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });
        });

        document.querySelectorAll('.quantity-left-minus').forEach(button => {
            button.addEventListener('click', function () {
                const quantityInput = this.closest('.product-qty').querySelector('input');
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
        });
    </script> -->
</body>

</html>
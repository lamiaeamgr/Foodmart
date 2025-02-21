<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}
$cart = $_SESSION['cart'] ?? [];

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/style.css">
    <style>
:root {
    --sunshine: #FFD700;
    --gold: #FFC107;
    --cream: #FFF8E1;
    --earth: #5D4037;
    --amber: #FFA000;
}

body {
    background: linear-gradient(135deg, var(--cream) 0%, #FFFDE7 100%);
    min-height: 100vh;
}

.cart-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
    animation: fadeIn 0.6s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.cart-title {
    font-size: 2.8rem;
    text-align: center;
    background: linear-gradient(45deg, var(--gold), var(--amber));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-bottom: 3rem;
}

.cart-item {
    background: white;
    border-radius: 15px;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    border-left: 4px solid var(--sunshine);
}

.cart-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: linear-gradient(to bottom, var(--gold), var(--amber));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.cart-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(255, 160, 0, 0.15);
}

.cart-item:hover::before {
    opacity: 1;
}

.product-image {
    width: 100px;
    height: 100px;
    border-radius: 12px;
    object-fit: cover;
    margin-right: 2rem;
    border: 2px solid var(--gold);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
}

.item-details {
    flex-grow: 1;
}

.quantity-badge {
    background: var(--sunshine);
    color: var(--earth);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-weight: 600;
}

.delete-btn {
    background: var(--amber);
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    transition: transform 0.2s ease;
    color: white;
}

.delete-btn:hover {
    transform: scale(1.05) rotate(-3deg);
}

.total-price {
    font-size: 1.4rem;
    color: var(--earth);
    font-weight: 700;
    background: rgba(255, 193, 7, 0.15);
    padding: 0.75rem 1.5rem;
    border-radius: 30px;
    display: inline-block;
}

.checkout-btn {
    background: linear-gradient(45deg, var(--gold), var(--amber));
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 30px;
    font-size: 1.1rem;
    color: white;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 160, 0, 0.3);
}

.checkout-btn:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 6px 20px rgba(255, 160, 0, 0.4);
}

.modal-content {
    border-radius: 20px;
    border: 2px solid var(--gold);
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(45deg, var(--gold), var(--amber));
    color: white;
}

.form-control:focus {
    border-color: var(--amber);
    box-shadow: 0 0 0 0.25rem rgba(255, 160, 0, 0.25);
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

.floating-icon {
    animation: float 3s ease-in-out infinite;
    color: var(--amber);
}

.text-ocean {
    color: var(--earth) !important;
}
</style>
</head>

<body class="bg-light">
    <?php include('../Public/navbar.php'); ?>
    <div class="cart-container">
    <h1 class="cart-title"><i class="bi bi-cart3 floating-icon"></i> Mon Panier</h1>

    <?php foreach ($cart as $item): ?>
    <div class="cart-item">
        <img src="<?= $item['image_path'] ?>" class="product-image" alt="Produit">
        <div class="item-details">
            <h4 class="mb-3"><?= $item['designation'] ?></h4>
            <div class="d-flex align-items-center gap-4">
                <div>
                    <span class="quantity-badge">
                        <i class="bi bi-layer-forward"></i> <?= $item['quantite'] ?>
                    </span>
                </div>
                <div class="text-ocean">
                    <i class="bi bi-tag"></i> <?= $item['prix'] ?> DH
                </div>
                <div class="total-price">
                    Total : <?= $item['quantite'] * $item['prix'] ?> DH
                </div>
            </div>
        </div>
        <a href='../../Gestion_Actions/acheteur/acheteur_actions.php?action=remove_from_cart&product_id=<?= $item['id'] ?>'
           class='btn delete-btn'>
           <i class="bi bi-trash3"></i> Supprimer
        </a>
    </div>
    <?php endforeach; ?>

    <div class="text-center mt-5">
        <button class="btn checkout-btn" data-bs-toggle="modal" data-bs-target="#checkoutModal">
            <i class="bi bi-lightning-charge"></i> Commander Maintenant
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-truck"></i> Détails de Livraison</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="checkoutForm" action="../../Gestion_Actions/acheteur/acheteur_actions.php?action=add_order" method="POST">
                        <!-- Hidden fields for product IDs and quantities -->
                        <input type="hidden" name="id_cart" value="">

                        <?php foreach ($cart as $item): ?>
                            <input type="hidden" name="produit_id[]" value="<?= $item['id'] ?>">
                            <input type="hidden" name="quantite[]" value="<?= $item['quantite'] ?>">
                            <input type="hidden" name="prices[]" value="<?= $item['prix']*$item['quantite'] ?>">
                        <?php endforeach; ?>

                        <!-- Shared delivery details -->
                        <div class="mb-3">
                            <label for="date_livraison" class="form-label">Date de Livraison</label>
                            <input type="date" class="form-control" id="date_livraison" name="date_livraison" required>
                        </div>
                        <div class="mb-3">
                            <label for="type_livraison" class="form-label">Type de Livraison</label>
                            <select class="form-select" id="type_livraison" name="type_livraison" required>
                                <option value="au magasin">Au magasin</option>
                                <option value="a domicile">A domicile</option>
                            </select>
                        </div>
                    </form>            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Annuler
                </button>
                <button type="submit" form="checkoutForm" class="btn btn-primary">
                    <i class="bi bi-check2-circle"></i> Confirmer
                </button>
            </div>
        </div>
    </div>
</div>



    <?php include('../Public/footer.php'); ?>

    <!-- Link to Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
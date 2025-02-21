<?php
session_start();
if (!isset($_SESSION['email'])) {
    // header("Location: ../../index.php");
    echo "lhabs";
    exit;
}

$product_id = $_GET['id'] ?? '';
if (!$product_id) {
    header("Location: products.php");
    exit;
}

$product_to_edit = isset($_SESSION['product_to_edit']) ? $_SESSION['product_to_edit'] : null;
// var_dump($_SESSION['product_to_edit']);
if (!$product_to_edit || $product_to_edit['id'] != $product_id) {
    header("Location: ../../Gestion_Actions/vendeur/vendeur_actions.php?action=get_product&&id=$product_id");
    exit;
}



// Fetch product details
// $product = getProduitById($product_id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Produit</title>
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

.edit-container {
    max-width: 800px;
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
    position: relative;
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
    margin-bottom: 1.5rem;
    position: relative;
}

.form-group label {
    color: var(--dark-text);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
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
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(125, 206, 148, 0.3);
    color: var(--dark-text);
}

.current-image {
    border: 3px solid var(--cream-citrus);
    border-radius: 10px;
    padding: 5px;
    margin-top: 1rem;
    max-width: 250px;
    transition: transform 0.3s ease;
}

.current-image:hover {
    transform: scale(1.02);
}

.file-upload {
    border: 2px dashed var(--cream-citrus);
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    background: rgba(255, 216, 168, 0.05);
    cursor: pointer;
    transition: all 0.3s ease;
}

.file-upload:hover {
    background: rgba(125, 206, 148, 0.1);
    border-color: var(--neon-green);
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
    .edit-container {
        margin: 2rem 1rem;
        padding: 1.5rem;
    }
    
    h1 {
        font-size: 1.8rem;
    }
}

.form-group i {
    color: var(--neon-green);
    font-size: 1.2rem;
}
</style>
</head>
<body>
    <?php include('../Public/navbar.php'); ?>
    
    <div class="edit-container">
        <h1><i class="bi bi-pencil-square"></i> Modifier le Produit</h1>
        
        <form action="../../Gestion_Actions/vendeur/vendeur_actions.php?action=update_product" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product_to_edit['id']; ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="reference"><i class="bi bi-upc-scan"></i> Référence</label>
                        <input type="text" class="form-control" id="reference" name="reference" 
                               value="<?= $product_to_edit['reference']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="designation"><i class="bi bi-card-text"></i> Désignation</label>
                        <input type="text" class="form-control" id="designation" name="designation" 
                               value="<?= $product_to_edit['designation']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="prix"><i class="bi bi-tag"></i> Prix</label>
                        <input type="number" step="0.01" class="form-control" id="prix" name="prix" 
                               value="<?= $product_to_edit['prix']; ?>" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantite_stock"><i class="bi bi-box-seam"></i> Quantité</label>
                        <input type="number" class="form-control" id="quantite_stock" name="quantite_stock" 
                               value="<?= $product_to_edit['quantite_stock']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="categorie"><i class="bi bi-bookmarks"></i> Catégorie</label>
                        <input type="text" class="form-control" id="categorie" name="categorie" 
                               value="<?= $product_to_edit['categorie']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_peremption"><i class="bi bi-calendar-x"></i> Date Péremption</label>
                        <input type="date" class="form-control" id="date_peremption" name="date_peremption" 
                               value="<?= $product_to_edit['date_peremption']; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="promotion"><i class="bi bi-percent"></i> Promotion</label>
                <input type="number" step="0.01" class="form-control" id="promotion" name="promotion" 
                       value="<?= $product_to_edit['promotion']; ?>">
            </div>

            <div class="form-group">
                <label for="image_upload"><i class="bi bi-image"></i> Image</label>
                <div class="file-upload">
                    <input type="file" class="form-control-file" id="image_upload" name="image_upload">
                    <?php if (isset($product_to_edit['image_path'])): ?>
                        <div class="mt-3">
                            <img src="<?= htmlspecialchars($product_to_edit['image_path']) ?>" 
                                 alt="Image actuelle" 
                                 class="current-image">
                            <input type="hidden" name="existing_image"
                                   value="<?= htmlspecialchars($product_to_edit['image_path']) ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-submit mt-4">
                <i class="bi bi-save"></i> Enregistrer
            </button>
        </form>
    </div>

    <?php include('../Public/footer.php'); ?>
</body>
</html>
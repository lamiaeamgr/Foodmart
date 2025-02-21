<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit;
}

$client = isset($_SESSION['client']) ? $_SESSION['client'] : null;

if (!$client) {
    header("Location: ../../Gestion_Actions/acheteur/acheteur_actions.php?action=view_profile");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
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

.profile-container {
    display: flex;
    margin: 50px auto;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    border: var(--cyber-border);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    backdrop-filter: blur(8px);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.profile-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.profile-image-section {
    flex: 40%;
    background: var(--cream-citrus);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.profile-image-section::before {
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

.profile-image-section:hover::before {
    opacity: 1;
}

.profile-image-section img {
    width: 70%;
    border-radius: 50%;
    border: 3px solid var(--neon-green);
    box-shadow: 0 0 20px rgba(125, 206, 148, 0.2);
    z-index: 1;
}

.profile-details-section {
    flex: 60%;
    padding: 2rem;
    background: transparent;
}

.neon-text {
    color: var(--neon-green);
    text-shadow: 0 0 15px rgba(125, 206, 148, 0.3);
    animation: flicker 3s infinite;
    margin-bottom: 1.5rem;
}

.profile-details-section p {
    font-size: 1.1rem;
    color: var(--dark-text);
    margin-bottom: 1rem;
    padding: 0.5rem;
    border-bottom: 1px solid var(--cream-citrus);
}

.profile-details-section strong {
    color: var(--neon-green);
    margin-right: 0.5rem;
}

.btn-edit-profile {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    z-index: 1;
}

.btn-edit-profile:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(125, 206, 148, 0.3);
    color: var(--dark-text);
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

@keyframes flicker {
    0% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
    50% { opacity: 0.9; text-shadow: 0 0 20px rgba(125, 206, 148, 0.4); }
    100% { opacity: 1; text-shadow: 0 0 15px rgba(125, 206, 148, 0.3); }
}

@media (max-width: 768px) {
    .profile-container {
        flex-direction: column;
        margin: 2rem 1rem;
    }
    
    .profile-image-section {
        padding: 1.5rem;
    }
    
    .profile-image-section img {
        width: 50%;
    }
    
    .neon-text {
        font-size: 2rem;
    }
}
</style>

</head>
<body>
    <?php include('../Public/navbar.php'); ?>
    <div class="container profile-container">
        <!-- Section Image et Bouton -->
        <div class="profile-image-section">
            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Profile Image">
            <div class="vertical-line"></div>
            <a href="edit_profile.php" class="btn btn-edit-profile">Modifier le Profil</a>
        </div>
        <!-- Section Détails du Profil -->
        <div class="profile-details-section">
            <h2>Mon Profil</h2>
            <p><strong>ID:</strong> <?= htmlspecialchars($client['id']); ?></p>
            <p><strong>Nom:</strong> <?= htmlspecialchars($client['nom']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($client['email']); ?></p>
            <p><strong>Mot de passe:</strong> ********</p>
            <?php if ($_SESSION['user_type'] !=="admin" && $_SESSION['user_type'] !=="vendeur"){ ?>
            <p><strong>Téléphone:</strong> <?= htmlspecialchars($client['telephone']); ?></p>
            <p><strong>Adresse:</strong> <?= htmlspecialchars($client['adresse']); ?></p>
            <p><strong>Points:</strong> <?= htmlspecialchars($client['points']); ?></p>
            <?php } ?>
        </div>
    </div>
    <?php include('../Public/footer.php'); ?>
</body>
</html>

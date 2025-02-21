<?php
session_start();
// require_once '../ACCES_BD/Models/client.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit;
}

$client = isset($_SESSION['client']) ? $_SESSION['client'] : null;

if (!$client) {
    header("Location: ../../Gestion_Actions/acheteur/acheteur_actions.php?action=view_profile");
    exit;
}

// Fetch client details
// $client = getClientById(id: $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
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
    display: flex;
    margin: 50px auto;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    border: var(--cyber-border);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    backdrop-filter: blur(8px);
    overflow: hidden;
    max-width: 1200px;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.edit-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(125, 206, 148, 0.15);
}

.profile-section {
    flex: 40%;
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.profile-section::before {
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

.profile-section:hover::before {
    opacity: 1;
}

.profile-icon {
    font-size: 120px;
    color: white;
    margin-bottom: 20px;
    filter: drop-shadow(0 0 10px rgba(125, 206, 148, 0.3));
}

.profile-info {
    color: white;
    font-size: 1.1rem;
    z-index: 1;
}

.profile-info strong {
    color: var(--cyber-gold);
}

.form-section {
    flex: 60%;
    padding: 2rem 3rem;
    background: transparent;
}

.form-title {
    color: var(--neon-green);
    font-weight: 700;
    margin-bottom: 2rem;
    text-shadow: 0 2px 4px rgba(125, 206, 148, 0.1);
    position: relative;
}

.form-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
}

.form-control-custom {
    border: 2px solid var(--cream-citrus);
    border-radius: 12px;
    padding: 12px 20px;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    background: rgba(255, 255, 255, 0.9);
}

.form-control-custom:focus {
    border-color: var(--neon-green);
    box-shadow: 0 0 0 3px rgba(125, 206, 148, 0.2);
}

.btn-gold {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    color: white;
    padding: 12px 30px;
    border-radius: 30px;
    border: none;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.btn-gold:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(125, 206, 148, 0.3);
    color: var(--dark-text);
}

.input-group-text {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid var(--cream-citrus);
    border-right: none;
    color: var(--neon-green);
}

.password-toggle {
    cursor: pointer;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--cream-citrus);
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: var(--neon-green);
}

@media (max-width: 768px) {
    .edit-container {
        flex-direction: column;
        margin: 2rem 1rem;
    }
    
    .profile-section {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .profile-icon {
        font-size: 80px;
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
    
    <div class="edit-container">
        <!-- Section Profil (Lecture seule) -->
        <div class="profile-section">
            <i class="bi bi-person-circle profile-icon"></i>
            <div class="profile-info">
                <p><strong>Nom :</strong> <?= htmlspecialchars($client['nom']); ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($client['email']); ?></p>
                <?php if ($_SESSION['user_type'] !=="admin" && $_SESSION['user_type'] !=="vendeur"){ ?>
                <p><strong>Points :</strong> <?= htmlspecialchars($client['points']); ?></p>
                <?php } ?>
            </div>
        </div>

        <!-- Section Formulaire -->
        <div class="form-section">
            <h2 class="form-title">Édition du Profil</h2>
            <form id="editProfileForm" action="../../Gestion_Actions/acheteur/acheteur_actions.php?action=update_profile" method="POST">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Nom complet</label>
                            <input type="text" class="form-control-custom w-100" name="nom" value="<?= htmlspecialchars($client['nom']); ?>" required>
                        </div>
                    </div>
                    <?php if ($_SESSION['user_type'] !=="admin" && $_SESSION['user_type'] !=="vendeur"){ ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Téléphone</label>
                            <input type="text" class="form-control-custom w-100" name="telephone" value="<?= htmlspecialchars($client['telephone']); ?>">
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control-custom" name="email" value="<?= htmlspecialchars($client['email']); ?>" required>
                            </div>
                        </div>
                    </div>
                    <?php if ($_SESSION['user_type'] !=="admin" && $_SESSION['user_type'] !=="vendeur"){ ?>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">Adresse</label>
                            <textarea class="form-control-custom w-100" name="adresse" rows="2"><?= htmlspecialchars($client['adresse']); ?></textarea>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label class="form-label fw-bold">Nouveau mot de passe</label>
                            <input type="password" class="form-control-custom w-100" id="mot_de_passe" name="mot_de_passe">
                            <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('mot_de_passe', this)"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label class="form-label fw-bold">Confirmation</label>
                            <input type="password" class="form-control-custom w-100" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe">
                            <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('confirmation_mot_de_passe', this)"></i>
                        </div>
                    </div>
                    <div id="pwdError" class="error-message text-center"></div>
                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn-gold px-5">
                            <i class="bi bi-save me-2"></i>Sauvegarder
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, icon) {
            const field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                field.type = "password";
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>
    <?php include('../Public/footer.php'); ?>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
/* Updated Cyber-Fresh Variables */
:root {
    --neon-green: #7dce94;
    --cyber-gold: #ffd700;
    --cream-citrus: #FFD8A8;  /* New cream citrus color */
    --cyber-bg-gradient: radial-gradient(circle at center, #f8fff9 0%, #fff5e6 100%);
    --cyber-border: 2px solid #FFE4C4;
}

.auth-container {
    background: var(--cyber-bg-gradient);
    min-height: 100vh;
    padding: 4rem 0;
}

.form-wrapper {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    border: var(--cyber-border);
    box-shadow: 0 8px 32px rgba(125, 206, 148, 0.05);
    backdrop-filter: blur(8px);
    overflow: hidden;
    transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.form-header {
    background: linear-gradient(45deg, var(--neon-green) 0%, var(--cream-citrus) 100%);
    padding: 2rem;
    text-align: center;
    position: relative;
}

.form-header h1 {
    font-size: 2.5rem;
    color: #5d4037;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.input-group-custom {
    position: relative;
    margin-bottom: 1.5rem;
}

.input-icon {
    color: var(--neon-green);
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
}

.form-control-custom {
    padding-left: 45px;
    height: 50px;
    border: 2px solid var(--cream-citrus);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
}

.form-control-custom:focus {
    border-color: var(--neon-green);
    box-shadow: 0 0 15px rgba(125, 206, 148, 0.2);
}

.password-toggle {
    color: var(--cream-citrus);
    right: 15px;
    cursor: pointer;
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: var(--neon-green);
}

.role-selector .btn-check:checked + .btn {
    background: var(--neon-green) !important;
    border-color: var(--neon-green) !important;
    color: white !important;
}

.btn-outline-primary {
    border-color: var(--cream-citrus);
    color: #5d4037;
}

.btn-outline-primary:hover {
    background: rgba(255, 216, 168, 0.2);
}

.btn-primary {
    background: var(--neon-green);
    border: none;
    padding: 1rem 2rem;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}

.btn-primary:hover {
    background: var(--cream-citrus);
    color: #5d4037;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(125, 206, 148, 0.3);
}

.file-upload-wrapper {
    border: 2px dashed var(--cream-citrus);
    background: rgba(255, 255, 255, 0.9);
    transition: border-color 0.3s ease;
}

.file-upload-wrapper:hover {
    border-color: var(--neon-green);
}

.progress {
    background: rgba(255, 216, 168, 0.2);
    height: 8px;
}

.progress-bar {
    background: var(--neon-green);
    transition: width 0.3s ease;
}

@keyframes hologram-pulse {
    0% { opacity: 0.8; }
    50% { opacity: 0.4; }
    100% { opacity: 0.8; }
}

.floating-icon {
    animation: hologram-pulse 2s ease-in-out infinite;
    color: var(--cream-citrus);
    filter: drop-shadow(0 0 5px rgba(125, 206, 148, 0.3));
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
</style>
</head>

<body>
    <?php include('../Public/navbar.php'); ?>

    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-wrapper">
                        <div class="form-header">
                            <h1 class="display-5 fw-bold mb-3"><i class="bi bi-person-plus floating-icon"></i> Nouvel
                                Utilisateur</h1>
                            <p class="lead">Créez un nouveau compte utilisateur</p>
                        </div>

                        <form action="../../Gestion_Actions/administrateur/admin_actions.php?action=add_user"
                            method="POST" class="form-body" enctype="multipart/form-data">

                            <!-- Nom Complet -->
                            <div class="input-group-custom">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text" class="form-control form-control-custom" name="nom" required>
                                <span class="animated-label">Nom complet</span>
                            </div>

                            <!-- Email -->
                            <div class="input-group-custom">
                                <i class="bi bi-envelope input-icon"></i>
                                <input type="email" class="form-control form-control-custom" name="email" required>
                                <span class="animated-label">Adresse email</span>
                            </div>

                            <!-- Mot de passe -->
                            <div class="input-group-custom">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" class="form-control form-control-custom" name="mot_de_passe"
                                    id="password" required>
                                <span class="animated-label">Mot de passe</span>
                                <i class="bi bi-eye-slash password-toggle" id="togglePassword"></i>
                            </div>

                            <!-- Force du mot de passe -->
                            <div class="progress mb-4" style="height: 8px;">
                                <div class="progress-bar" id="password-strength" role="progressbar"></div>
                            </div>

                            <!-- Type d'utilisateur -->
                            <div class="mb-4 role-selector">
                                <h6 class="mb-3">Type de compte</h6>
                                <div class="d-flex gap-2 flex-wrap">
                                    <div class="flex-fill">
                                        <input type="radio" class="btn-check" name="user_type" id="admin" value="admin"
                                            required>
                                        <label class="btn btn-outline-primary w-100" for="admin">
                                            <i class="bi bi-shield-lock"></i> Administrateur
                                        </label>
                                    </div>
                                    <div class="flex-fill">
                                        <input type="radio" class="btn-check" name="user_type" id="vendeur" value="vendeur">
                                        <label class="btn btn-outline-primary w-100" for="vendeur">
                                            <i class="bi bi-shop"></i> Vendeur
                                        </label>
                                    </div>
                                    <div class="flex-fill">
                                        <input type="radio" class="btn-check" name="user_type" id="client" value="client">
                                        <label class="btn btn-outline-primary w-100" for="client">
                                            <i class="bi bi-person"></i> Client
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save"></i> Créer le compte
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('../Public/footer.php'); ?>

    <script>
        // Password Visibility Toggle
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        // Password Strength Checker
        password.addEventListener('input', function () {
            const strength = calculatePasswordStrength(this.value);
            const strengthBar = document.getElementById('password-strength');

            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = 'progress-bar ' + strength.class;
        });

        function calculatePasswordStrength(password) {
            let strength = 0;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[$@#&!]+/)) strength += 1;
            if (password.length > 7) strength += 1;

            const classes = ['bg-danger', 'bg-warning', 'bg-info', 'bg-primary', 'bg-success'];
            const percentages = [20, 40, 60, 80, 100];

            return {
                class: classes[strength - 1] || 'bg-danger',
                percentage: percentages[strength - 1] || 20
            };
        }

        // Image Preview
        document.querySelector('input[type="file"]').addEventListener('change', function (e) {
            const preview = document.querySelector('.preview-area');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
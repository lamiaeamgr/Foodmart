<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodMart</title>
    <link rel="stylesheet" href="./IHM/Public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #FF6B35;
            --secondary: #FFD400;
            --accent: #004E89;
            --dark: #2E282A;
            --light: #FFF8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            overflow: hidden;
        }

        .background {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .background-image {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.8);
            transform: scale(1.1);
            transition: all 1s ease;
        }

        .welcome-text {
            position: relative;
            color: var(--light);
            font-size: 4rem;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 2;
            padding: 2rem 4rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            transition: all 0.3s ease;
            animation: float 3s ease-in-out infinite;
        }

        .welcome-text:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.15);
        }

        .welcome-text .icon {
            font-size: 3rem;
            color: var(--secondary);
            transition: transform 0.3s ease;
        }

        .welcome-text:hover .icon {
            transform: translateX(10px);
        }

        .login-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 400px;
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 1000;
        }

        .login-form.active {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        .form-heading {
            color: var(--dark);
            font-size: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
        }

        .form-heading::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary);
        }

        .form-control {
            border: 2px solid var(--primary);
            border-radius: 10px;
            padding: 0.8rem 1.2rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.3);
            border-color: var(--primary);
        }

        .btn-warning {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            color: var(--light);
            font-weight: 600;
            padding: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes slideIn {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @media (max-width: 768px) {
            .welcome-text {
                font-size: 2.5rem;
                padding: 1.5rem 2rem;
            }
            
            .login-form {
                width: 90%;
                padding: 1.5rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background">
        <img src="./IHM/Public/images/home.jpg" alt="Background" class="background-image">
        <div class="welcome-text" onclick="showLoginForm()">
            <span>Welcome to FoodMart</span>
            <span class="icon">
                <i class="bi bi-arrow-right-circle-fill"></i>
            </span>
        </div>
    </div>

    <div class="login-form" id="loginForm">
        <h4 class="form-heading">Login</h4>
        <form action="./Gestion_Actions/login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Login</button>
        </form>
    </div>

    <script>
        function showLoginForm() {
            document.getElementById('loginForm').classList.add('active');
            document.querySelector('.background-image').style.transform = 'scale(1)';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
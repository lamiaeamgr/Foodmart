<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodMart</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="./IHM/Public/css/style.css">
    <!-- Bootstrap CSS for Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Login</button>
        </form>
    </div>

    <!-- Link to JS -->
    <script src="./IHM/Public/js/main.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

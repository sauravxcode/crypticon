<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title of the page -->
    <title>Login | Cryptic Hunt</title>

    <!-- External CSS file for styling -->
    <link rel="stylesheet" href="css/login.css">

    <!-- External library for icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <!-- Container for the login form -->
    <div class="container-box">
        <!-- Form for user input -->
        <form id="LoginForm" method="post">
            <h1>Login</h1>

            <!-- Input box for username -->
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>

            <!-- Input box for password -->
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class='bx bxs-hide' id="togglePassword"></i>
            </div>

            <!-- Section for "Remember me" checkbox and "Forgot Password" link -->
            <div class="remember-forgot">
                <label><input type="checkbox"> Remember me </label>
                <a href="forgot_pass.php">Forgot Password?</a>
            </div>

            <!-- Button for form submission -->
            <button type="submit" class="btn" name="submit">Login</button>

            <div class="register-link">
                <p>Have question?
                    <a href="#">Join Discord</a>
                </p>
            </div>
        </form>
    </div>
    <script src="js/password.js"></script>
</body>
</html>

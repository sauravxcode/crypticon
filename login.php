<?php
require_once 'includes/config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT UserID, Username, Password FROM userlogin WHERE Username = ? OR Email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['Password'])) {
            if($row['Username'] === 'admin') {
                // Redirect to admin page
                $_SESSION['user_id'] = $row['UserID'];
                $_SESSION['username'] = $row['Username'];
                header("Location: admin/dashboard.php");
                exit;
            }

            // Check number of active sessions
            $sessionCount = mysqli_query($conn, "SELECT COUNT(*) FROM usersessions WHERE UserID = " . $row['UserID']);
            $sessionCount = mysqli_fetch_array($sessionCount)[0];

            if ($sessionCount >= 3) {
                // Remove oldest session if limit reached
                $removeOldestSession = "DELETE FROM usersessions WHERE UserID = " . $row['UserID'] . " ORDER BY LoginTime ASC LIMIT 1";
                mysqli_query($conn, $removeOldestSession);
                // Now proceed with login
                }


            $_SESSION['user_id'] = $row['UserID'];
            $_SESSION['username'] = $row['Username'];

            $sessionID = session_id();
            $query = "INSERT INTO usersessions (SessionID, UserID) 
                      VALUES ('$sessionID', " . $row['UserID'] . ") 
                      ON DUPLICATE KEY UPDATE LoginTime = CURRENT_TIMESTAMP";
            mysqli_query($conn, $query);

            header("Location: ../includes/homepage.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Crypticon 2024</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="css/loaders/loader.css">
</head>
<body>   
        <div class="loader">
    <div class="loader__container">
        <div class="pyramid-loader">
            <div class="wrapper">
                <span class="side side1"></span>
                <span class="side side2"></span>
                <span class="side side3"></span>
                <span class="side side4"></span>
                <span class="shadow"></span>
            </div>  
        </div>
    </div>
</div>
    <div id="container">
        <div class="login-container">
            <div class="login-form">
                <div class="text">
                   USER LOGIN
                </div>
                <form id="login-form" method="POST" action="">
                   <div class="field">
                      <div class="fas fa-envelope"></div>
                      <input type="text" name="username" placeholder="Username or Email" required>
                   </div>
                   <div class="field">
                      <div class="fas fa-lock"></div>
                      <input type="password" name="password" placeholder="Password" required>
                   </div>
                   <?php if (isset($error)) { ?>
                       <div class="error"><?php echo $error; ?></div>
                   <?php } ?>
                   <button type="submit">LOGIN 🡥</button>
                   <div class="link">
                      Have a Question?
                      <a href="https://discord.gg/nXJ7pv5Zw4">Join Discord</a>
                   </div>
                </form>
             </div>
        </div>
    </div>
    <script>
    window.addEventListener("load", function () {
        const loader = document.querySelector(".loader");
        setTimeout(function () {
            loader.classList.add("loaded");
            loader.style.display = "none";
        }, 1000);
    });
    </script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js'></script>
</body>
</html>

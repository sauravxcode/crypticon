<?php
require_once 'u/config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check game status
$sql = "SELECT CompetitionDate, CompetitionEndDate, CompetitionStartTime, CompetitionEndTime FROM competitionInfo ORDER BY CompetitionID DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$competitionStart = new DateTime($row['CompetitionDate'] . ' ' . $row['CompetitionStartTime'], new DateTimeZone('Asia/Kolkata'));
$competitionEnd = new DateTime($row['CompetitionEndDate'] . ' ' . $row['CompetitionEndTime'], new DateTimeZone('Asia/Kolkata'));
$now = new DateTime('now', new DateTimeZone('Asia/Kolkata'));

$gameStatus = '';
if ($now < $competitionStart) {
    $gameStatus = 'not_started';
} elseif ($now > $competitionEnd) {
    $gameStatus = 'ended';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT UserID, Username, Password FROM userlogin WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if ($row['Username'] !== 'admin') {
            if ($gameStatus === 'not_started') {
                $error = "Game has not started yet.";
            } elseif ($gameStatus === 'ended') {
                $error = "Game has ended.";
            } elseif (password_verify($password, $row['Password'])) {
                $_SESSION['user_id'] = $row['UserID'];
                $_SESSION['username'] = $row['Username'];

                $sessionCount = mysqli_query($conn, "SELECT COUNT(*) FROM usersessions WHERE UserID = " . $row['UserID']);
                $sessionCount = mysqli_fetch_array($sessionCount)[0];

                if ($sessionCount >= 3) {
                    $removeOldestSession = "DELETE FROM usersessions WHERE UserID = " . $row['UserID'] . " ORDER BY LoginTime ASC LIMIT 1";
                    mysqli_query($conn, $removeOldestSession);
                }

                $sessionID = session_id();
                $query = "INSERT INTO usersessions (SessionID, UserID) 
                          VALUES ('$sessionID', " . $row['UserID'] . ") 
                          ON DUPLICATE KEY UPDATE LoginTime = CURRENT_TIMESTAMP";
                mysqli_query($conn, $query);

                header("Location: ../u/homepage.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            if (password_verify($password, $row['Password'])) {
                $_SESSION['user_id'] = $row['UserID'];
                $_SESSION['username'] = $row['Username'];
                header("Location: admin/admin-dashboard.php");
                exit;
            } else {
                $error = "Invalid username or password";
            }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>   
    <div id="container">
        <div class="login-container">
            <div class="login-form">
                <div class="text">
                   USER LOGIN
                </div>
                <form id="login-form" method="POST" action="">
                   <div class="field">
                      <div class="fas fa-envelope"></div>
                      <input type="text" name="username" placeholder="Username" required>
                   </div>
                   <div class="field">
                      <div class="fas fa-lock"></div>
                      <input type="password" name="password" placeholder="Password" required>
                   </div>
                   <button type="submit">LOGIN 🡥</button>
                   <div class="link">
                      Have a Question?
                      <a href="https://discord.gg/nXJ7pv5Zw4">Join Discord</a>
                   </div>
                </form>
             </div>
        </div>
    </div>
    <div id="error-popup" class="popup">
        <div class="popup-content">
            <p id="error-message"></p>
            <button onclick="closePopup()">Close</button>
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

    function showPopup(message) {
        document.getElementById('error-message').textContent = message;
        document.getElementById('error-popup').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('error-popup').style.display = 'none';
    }

    <?php
    if (isset($error)) {
        echo "showPopup('$error');";
    }
    ?>
    </script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js'></script>
</body>
</html>

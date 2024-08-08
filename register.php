<?php
require_once 'u/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $member1 = mysqli_real_escape_string($conn, $_POST['member1']);
    $member2 = mysqli_real_escape_string($conn, $_POST['member2']);
    $member3 = mysqli_real_escape_string($conn, $_POST['member3']);

    // Check if username exists
    $check_username = "SELECT * FROM userlogin WHERE Username = ?";
    $stmt = mysqli_prepare($conn, $check_username);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $error = "Username already exists. Please choose a different one.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        mysqli_begin_transaction($conn);

        try {
            // Insert into schooldata
            $sql = "INSERT INTO schooldata (SchoolName, SchoolAddress, SchoolContactInfo, UserProfilePicLink) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            $schoolName = "Maharaja Surajmal Institute";
            $schoolAddress = "C-4, Janakpuri, New Delhi, Delhi 110058";
            $schoolContactInfo = "011 25552667";
            $userProfilePicLink = "https://bootdey.com/img/Content/avatar/avatar1.png";
            mysqli_stmt_bind_param($stmt, "ssss", $schoolName, $schoolAddress, $schoolContactInfo, $userProfilePicLink);
            mysqli_stmt_execute($stmt);
            $schoolId = mysqli_insert_id($conn);

            // Insert into userlogin
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO userlogin (SchoolID, Username, Password, Email) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            $email = "user" . $schoolId . "@example.com";
            mysqli_stmt_bind_param($stmt, "isss", $schoolId, $username, $hashed_password, $email);
            mysqli_stmt_execute($stmt);

            // Insert into teammembers
            $members = [$member1, $member2, $member3];
            $sql = "INSERT INTO teammembers (SchoolID, MemberName) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            foreach ($members as $member) {
                if (!empty($member)) {
                    mysqli_stmt_bind_param($stmt, "is", $schoolId, $member);
                    mysqli_stmt_execute($stmt);
                }
            }

            // Insert into Leaderboard
            $sql = "INSERT INTO leaderboard (SchoolID, Score, sRank) VALUES (?, 0, NULL)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $schoolId);
            mysqli_stmt_execute($stmt);

            mysqli_commit($conn);
            $success = "Registration successful. You can now login.";
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Crypticon 2024</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>   
    <div id="container">
        <div class="login-container">
            <div class="register-form">
                <div class="text">
                   REGISTER
                </div>
                <form id="register-form" method="POST" action="">
                   <div class="field">
                      <div class="fas fa-user"></div>
                      <input type="text" id="username" name="username" placeholder="Username" required>
                   </div>
                   <div class="field">
                      <div class="fas fa-lock"></div>
                      <input type="password" id="password" name="password" placeholder="Password" required>
                   </div>
                   <div class="field">
                      <div class="fas fa-lock"></div>
                      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                   </div>
                   <div class="field">
                      <div class="fas fa-user"></div>
                      <input type="text" id="member1" name="member1" placeholder="Name + CET Rank" required>
                   </div>
                   <div class="field">
                      <div class="fas fa-user"></div>
                      <input type="text" id="member2" name="member2" placeholder="Name + CET Rank" required>
                   </div>
                   <div class="field">
                      <div class="fas fa-user"></div>
                      <input type="text" id="member3" name="member3" placeholder="Member 3 (optional)" >
                   </div>
                   <button type="submit">REGISTER 🡥</button>
                   <div class="link">
                      Already have an account? <a href="login.php">Login here</a>
                   </div>
                </form>
             </div>
        </div>
    </div>
    <div id="message-popup" class="popup">
        <div class="popup-content">
            <p id="message"></p>
            <button onclick="closePopup()">Close</button>
        </div>
    </div>
    <script>
    function showPopup(message) {
        document.getElementById('message').textContent = message;
        document.getElementById('message-popup').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('message-popup').style.display = 'none';
        // redircet to login page
        window.location.href = 'login.php';
    }

    <?php
    if (isset($error)) {
        echo "showPopup('$error');";
    } elseif (isset($success)) {
        echo "showPopup('$success');";
    }
    ?>
    </script>
</body>
</html>

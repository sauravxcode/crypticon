<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT u.UserID, u.Username, u.Email, s.SchoolID, s.SchoolName, s.SchoolAddress, s.SchoolContactInfo, s.UserProfilePicLink 
          FROM UserLogin u 
          JOIN SchoolData s ON u.SchoolID = s.SchoolID 
          WHERE u.UserID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_data = mysqli_fetch_assoc($result);

$query = "SELECT MemberName, MemberEmail, MemberRole FROM TeamMembers WHERE SchoolID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_data['SchoolID']);
mysqli_stmt_execute($stmt);
$team_members_result = mysqli_stmt_get_result($stmt);
$team_members = mysqli_fetch_all($team_members_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
</head>
<body>
    <?php include ("header.php"); ?>
    <div class="container">
        <div class="form-container">
            <!-- Private Info -->
            <div class="form-section">
    <h2 class="section-title">Private Info</h2>
    <form>
        <div class="form-group">
            <label for="inputUserID">User ID</label>
            <input type="text" id="inputUserID" value="<?php echo $user_data['UserID']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="inputSchoolName">School Name</label>
            <input type="text" id="inputSchoolName" value="<?php echo $user_data['SchoolName']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" id="inputEmail" value="<?php echo $user_data['Email']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="inputAddress">Address</label>
            <input type="text" id="inputAddress" value="<?php echo $user_data['SchoolAddress']; ?>" readonly>
        </div>
        <div class="form-group">
            <h2 class="section-title">Member Info</h2>
            <?php 
            for ($i = 0; $i < 3; $i++) {
                if (isset($team_members[$i])) {
                    $member = $team_members[$i];
                    $value = $member['MemberName'] . ' - ' . $member['MemberRole'];
                } else {
                    $value = '';
                }
                echo '<div class="form-group"> <input type="text" id="inputMember' . ($i + 1) . '" value="' . $value . '" readonly></div>';
            }
            ?>
                </div>
            </form>
        </div>
        <div class="form-section">
            <h2 class="section-title">Public Info</h2>
            <form>
                <div class="form-group">
                    <label for="inputUsername">Username</label>
                    <input type="text" id="inputUsername" value="<?php echo $user_data['Username']; ?>" readonly>
                </div>
                <!-- <div class="form-group">
                    <label for="inputBio">Team Slogan</label>
                    <textarea id="inputBio" rows="4" readonly></textarea>
                </div> -->
                <div class="form-group image-upload">
                    <label for="preview">Your Profile Picture</label>
                    <img id="preview" src="<?php echo $user_data['UserProfilePicLink'] ?: 'https://bootdey.com/img/Content/avatar/avatar1.png'; ?>" alt="Profile Picture">
                </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>

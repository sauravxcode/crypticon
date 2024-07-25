<?php
session_start();
include("../includes/config.php");

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../logout.php");
    exit();
}

$schoolId = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $schoolName = $_POST['schoolName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $userphoto = $_POST['userphoto'];
    $member1 = $_POST['member1'];
    $member2 = $_POST['member2'];
    $member3 = $_POST['member3'];

    // Update schooldata table
    $sql = "UPDATE schooldata SET SchoolName = ?, SchoolAddress = ?, SchoolContactInfo = ?, UserProfilePicLink = ? WHERE SchoolID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $schoolName, $address, $contact, $userphoto, $schoolId);
    mysqli_stmt_execute($stmt);

    // Update userlogin table
    $sql = "UPDATE userlogin SET Username = ?, Email = ? WHERE SchoolID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $username, $email, $schoolId);
    mysqli_stmt_execute($stmt);

    // Update teammembers table
    $sql = "DELETE FROM teammembers WHERE SchoolID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $schoolId);
    mysqli_stmt_execute($stmt);

    $members = [$member1, $member2, $member3];
    $sql = "INSERT INTO teammembers (SchoolID, MemberName) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    foreach ($members as $member) {
        mysqli_stmt_bind_param($stmt, "is", $schoolId, $member);
        mysqli_stmt_execute($stmt);
    }

    // Redirect back to user-detail.php with success message
    header("Location: user-detail.php?message=User updated successfully");
    exit();
}


$sql = "SELECT sd.*, ul.Email, ul.Username, 
        GROUP_CONCAT(tm.MemberName SEPARATOR '|') as Members
        FROM schooldata sd
        JOIN userlogin ul ON sd.SchoolID = ul.SchoolID
        LEFT JOIN teammembers tm ON sd.SchoolID = tm.SchoolID
        WHERE sd.SchoolID = ?
        GROUP BY sd.SchoolID, sd.SchoolName, sd.SchoolAddress, sd.SchoolContactInfo, sd.UserProfilePicLink, ul.Email, ul.Username";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $schoolId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$userData = mysqli_fetch_assoc($result);

$members = explode('|', $userData['Members']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="edit-user.css">
</head>
<body>
<?php include ("admin-navbar.php"); ?>
    <div class="container">
        <h1 class="page-title">Edit User</h1>
        <div class="form-container">
            <div class="form-section">
                <form method="POST" action="">
                    <div class="input-container">
                        <div class="private-info">
                            <h2 class="section-title">Private Info</h2>
                            <div class="form-group">
                                <input type="text" id="inputSchoolName" name="schoolName" placeholder="School Name" value="<?php echo $userData['SchoolName']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputUsername" name="username" placeholder="Username" value="<?php echo $userData['Username']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="email" id="inputEmail" name="email" placeholder="Email" value="<?php echo $userData['Email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputAddress" name="address" placeholder="Address: 1234 Main St" value="<?php echo $userData['SchoolAddress']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputContact" name="contact" placeholder="+91 99xxx 99xxx" value="<?php echo $userData['SchoolContactInfo']; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputUserphoto" name="userphoto" placeholder="Insert the link.." value="<?php echo $userData['UserProfilePicLink']; ?>">
                            </div>
                        </div>
                        <div class="member-info">
                            <h2 class="section-title">Member Info</h2>
                            <?php for ($i = 0; $i < 3; $i++) : ?>
                            <div class="form-group">
                                <input type="text" id="inputMember<?php echo $i+1; ?>" name="member<?php echo $i+1; ?>" placeholder="Member <?php echo $i+1; ?>" value="<?php echo isset($members[$i]) ? $members[$i] : ''; ?>" required>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <button type="submit" class="btn"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

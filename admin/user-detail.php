<?php
session_start();
include("../u/config.php");

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../u/logout.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $schoolName = $_POST['schoolName'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $userphoto = $_POST['userphoto'];
    $member1 = $_POST['member1'];
    $member2 = $_POST['member2'];
    $member3 = $_POST['member3'];

    mysqli_begin_transaction($conn);

    try {
        // Insert into schooldata
        $sql = "INSERT INTO schooldata (SchoolName, SchoolAddress, SchoolContactInfo, UserProfilePicLink) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $schoolName, $address, $contact, $userphoto);
        mysqli_stmt_execute($stmt);
        $schoolId = mysqli_insert_id($conn);

        // Insert into userlogin
        $sql = "INSERT INTO userlogin (SchoolID, Username, Password, Email) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $schoolId, $username, $password, $email);
        mysqli_stmt_execute($stmt);

        // Insert into teammembers
        $members = [$member1, $member2, $member3];
        $sql = "INSERT INTO teammembers (SchoolID, MemberName) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        foreach ($members as $member) {
            mysqli_stmt_bind_param($stmt, "is", $schoolId, $member);
            mysqli_stmt_execute($stmt);
        }

        // Insert into Leaderboard
        $sql = "INSERT INTO leaderboard (SchoolID, Score, sRank) VALUES (?, 0, NULL)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $schoolId);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}

$sql = "SELECT sd.SchoolID, sd.SchoolName, MAX(ul.Username) as Username, sd.SchoolAddress, 
        GROUP_CONCAT(tm.MemberName SEPARATOR ', ') as Members, l.Score, l.sRank
        FROM schooldata sd
        JOIN userlogin ul ON sd.SchoolID = ul.SchoolID
        LEFT JOIN teammembers tm ON sd.SchoolID = tm.SchoolID
        LEFT JOIN leaderboard l ON sd.SchoolID = l.SchoolID
        WHERE ul.Username != 'admin'
        GROUP BY sd.SchoolID, sd.SchoolName, sd.SchoolAddress, l.Score, l.sRank";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="edit-user.css"> 
</head>
<body>
<?php include ("admin-navbar.php"); ?>
    <div class="container">
        <h1 class="page-title">Manage Users</h1>
        <div class="form-container">
            <div class="form-section">
                <form method="POST" action="">
                    <div class="input-container">
                        <div class="private-info">
                            <h2 class="section-title">Private Info</h2>
                            <div class="form-group">
                                <input type="text" id="inputSchoolName" name="schoolName" placeholder="School Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputUsername" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" id="inputPassword" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <input type="email" id="inputEmail" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputAddress" name="address" placeholder="Address: 1234 Main St" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputContact" name="contact" placeholder="+91 99xxx 99xxx" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputUserphoto" name="userphoto" placeholder="Insert the link..">
                            </div>
                        </div>
                        <div class="member-info">
                            <h2 class="section-title">Member Info</h2>
                            <div class="form-group">
                                <input type="text" id="inputMember1" name="member1" placeholder="Member 1" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputMember2" name="member2" placeholder="Member 2" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputMember3" name="member3" placeholder="Member 3" required>
                            </div>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <button type="submit" class="btn"><i class="fas fa-save"></i> Add User</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="user-table-container">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>UserID</th>
                        <th>School Name</th>
                        <th>Username</th>
                        <th>Address</th>
                        <th>Members</th>
                        <th>Score</th>
                        <th>Rank</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['SchoolID']; ?></td>
                        <td><?php echo $row['SchoolName']; ?></td>
                        <td><?php echo $row['Username']; ?></td>
                        <td><?php echo $row['SchoolAddress']; ?></td>
                        <td><?php echo $row['Members']; ?></td>
                        <td><?php echo $row['Score']; ?></td>
                        <td><?php echo $row['sRank'] ? $row['sRank'] : 'N/A'; ?></td>
                        <td>
                            <a href="edit-user.php?id=<?php echo $row['SchoolID']; ?>" class="action-btn"><i class="fas fa-edit"></i></a>
                            <button onclick="confirmDelete(<?php echo $row['SchoolID']; ?>)" class="action-btn"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    function confirmDelete(schoolId) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "delete-user.php?id=" + schoolId;
        }
    }
    </script>
</body>
</html>

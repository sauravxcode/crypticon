<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch leaderboard data
$leaderboard_query = "SELECT s.SchoolName, u.Username, l.Score, l.sRank 
                      FROM leaderboard l 
                      JOIN schooldata s ON l.SchoolID = s.SchoolID 
                      JOIN userlogin u ON s.SchoolID = u.SchoolID
                      WHERE u.Username != 'admin'
                      ORDER BY l.Score DESC, l.sRank ASC";

$leaderboard_result = mysqli_query($conn, $leaderboard_query);
$leaderboard_data = mysqli_fetch_all($leaderboard_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="leaderboard.css">
</head>
<body>
<?php include_once "header.php" ?>
    <main>
        <div class="leaderboard">
            <h1>Leaderboard</h1>
            <table>
                <thead>
                    <tr>
                        <th class="rank">Rank</th>
                        <th class="username">Username</th>
                        <th class="school-name">School Name</th>
                        <th class="score">Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leaderboard_data as $rank => $team): ?>
                        <tr>
                            <td class="rank"><?php echo $rank + 1; ?></td>
                            <td class="username"><?php echo htmlspecialchars($team['Username']); ?></td>
                            <td class="school-name"><?php echo htmlspecialchars($team['SchoolName']); ?></td>
                            <td class="score"><?php echo number_format($team['Score']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

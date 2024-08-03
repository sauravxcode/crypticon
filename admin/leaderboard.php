<?php
session_start();
require_once '../includes/config.php';

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
                      ORDER BY l.Score DESC, l.sRank ASC 
                      LIMIT 10";

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
<?php include_once "admin-navbar.php" ?>
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

    <script>
    function updateLeaderboard() {
        fetch('update_leaderboard.php')
            .then(response => response.json())
            .then(data => {
                const leaderboardBody = document.querySelector('.leaderboard table tbody');
                leaderboardBody.innerHTML = '';
                data.forEach((team, index) => {
                    const row = `
                        <tr>
                            <td class="rank">${index + 1}</td>
                            <td class="username">${team.Username}</td>
                            <td class="school-name">${team.SchoolName}</td>
                            <td class="score">${Number(team.Score)}</td>
                        </tr>
                    `;
                    leaderboardBody.innerHTML += row;
                });
            })
            .catch(error => console.error('Error:', error));
    }

    setInterval(updateLeaderboard, 3000); // Update every 3 seconds
    </script>
</body>
</html>

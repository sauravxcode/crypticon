<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current level and question
$query = "SELECT s.SchoolID, s.SchoolName, s.CurrentLevel, g.QuestionID, g.Question, g.Link, l.Score, l.sRank 
          FROM SchoolData s 
          JOIN UserLogin u ON s.SchoolID = u.SchoolID
          JOIN Leaderboard l ON s.SchoolID = l.SchoolID
          JOIN GameDetails g ON s.CurrentLevel = g.Level
          WHERE u.UserID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$game_data = mysqli_fetch_assoc($result);

// Handle answer submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $query = "SELECT Answer FROM GameDetails WHERE QuestionID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $game_data['QuestionID']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $correct_answer = mysqli_fetch_assoc($result)['Answer'];

    if (strtolower($answer) === strtolower($correct_answer)) {
        // Update score and move to next level
        $new_score = $game_data['Score'] + 200;
        $new_level = $game_data['CurrentLevel'] + 1;
        $update_query = "UPDATE Leaderboard SET Score = ? WHERE SchoolID = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ii", $new_score, $game_data['SchoolID']);
        mysqli_stmt_execute($stmt);

        // Update CurrentLevel in SchoolData
        $update_level_query = "UPDATE SchoolData SET CurrentLevel = ? WHERE SchoolID = ?";
        $stmt = mysqli_prepare($conn, $update_level_query);
        mysqli_stmt_bind_param($stmt, "ii", $new_level, $game_data['SchoolID']);
        mysqli_stmt_execute($stmt);

        // Redirect to refresh the page and show next question
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Incorrect answer. Try again after the 5 second cooldown.";
    }
}

// Fetch leaderboard data
$leaderboard_query = "SELECT s.SchoolName, l.Score, l.sRank 
                      FROM Leaderboard l 
                      JOIN SchoolData s ON l.SchoolID = s.SchoolID 
                      ORDER BY l.Score DESC, l.sRank ASC 
                      LIMIT 10";
$leaderboard_result = mysqli_query($conn, $leaderboard_query);
$leaderboard_data = mysqli_fetch_all($leaderboard_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="../css/loaders/loader.css">
    <title>Game Arena | Crypticon 2024</title>
</head>
<body>
    <?php include_once("header.php") ?>
    <main>
        <div class="game-area">
            <div class="question-box">
                <h2>Level : <?php echo $game_data['CurrentLevel']; ?></h2>
                <p><?php echo $game_data['Question']; ?></p>
                <?php if ($game_data['Link']): ?>
                    <p>Link: <a href="<?php echo $game_data['Link']; ?>" target="_blank"><?php echo $game_data['Link']; ?></a></p>
                <?php endif; ?>
            </div>
            <div class="answer-input">
                <form id="answer-form" method="POST">
                    <input type="text" id="answer" name="answer" placeholder="Your answer" required>
                    <button type="submit" id="submit-answer">Submit</button>
                </form>
                <?php if (isset($error_message)): ?>
                    <p class="error"><?php echo $error_message; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="leaderboard-timer">
            <div class="leaderboard">
                <h1>Ranking</h1>
                <table>
                    <tbody>
                    <?php foreach ($leaderboard_data as $rank => $team): ?>
                        <tr>
                            <td class="number"><?php echo $rank + 1; ?></td>
                            <td class="name"><?php echo $team['SchoolName']; ?></td>
                            <td class="points"><?php echo $team['Score']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="user-rank">
                    <span class="rank-number"><?php echo $game_data['sRank']; ?></span>
                    <span class="rank-name"><?php echo $game_data['SchoolName']; ?></span>
                    <span class="rank-points"><?php echo $game_data['Score']; ?></span>
                </div>
            </div>
            <div class="timer">
                <div id="countdown">
                    <?php include_once("timer.php") ?>
                </div>
            </div>
        </div>
    </main>
    <script>
    // Add cooldown functionality
    const submitButton = document.getElementById('submit-answer');
    const answerForm = document.getElementById('answer-form');

    answerForm.addEventListener('submit', (e) => {
        e.preventDefault();
        submitButton.disabled = true;
        setTimeout(() => {
            submitButton.disabled = false;
        }, 5000); // 5 second cooldown
        answerForm.submit();
    });

    function updateLeaderboard() {
    fetch('update_leaderboard.php')
        .then(response => response.json())
        .then(data => {
            const leaderboardBody = document.querySelector('.leaderboard table tbody');
            leaderboardBody.innerHTML = '';
            data.forEach((team, index) => {
                const row = `
                    <tr>
                        <td class="number">${index + 1}</td>
                        <td class="name">${team.SchoolName}</td>
                        <td class="points">${team.Score}</td>
                    </tr>
                `;
                leaderboardBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error:', error));
        }

        setInterval(updateLeaderboard, 5000);

    </script>
</body>
</html>


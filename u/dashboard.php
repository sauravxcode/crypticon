<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

function getDashboardData($conn, $user_id) {
    // Get current question and level
    $query = "SELECT g.QuestionID, g.Question, g.Link, s.CurrentLevel, s.SchoolID, u.Username, l.Score, l.sRank 
              FROM schooldata s 
              JOIN userlogin u ON s.SchoolID = u.SchoolID
              JOIN leaderboard l ON s.SchoolID = l.SchoolID
              LEFT JOIN gamedetails g ON s.CurrentLevel = g.Level
              WHERE u.UserID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $game_data = mysqli_fetch_assoc($result);

    // Check if max level is reached
    $max_level_query = "SELECT MAX(Level) as max_level FROM gamedetails";
    $result = mysqli_query($conn, $max_level_query);
    $max_level_row = mysqli_fetch_assoc($result);
    $max_level = $max_level_row['max_level'];
    $max_level_reached = $game_data['CurrentLevel'] > $max_level;

    // Get leaderboard data
    $leaderboard_query = "SELECT s.SchoolName, u.Username, l.Score, l.sRank 
                          FROM leaderboard l 
                          JOIN schooldata s ON l.SchoolID = s.SchoolID 
                          JOIN userlogin u ON s.SchoolID = u.SchoolID
                          WHERE u.Username != 'admin'
                          ORDER BY l.Score DESC, l.sRank ASC";
    $leaderboard_result = mysqli_query($conn, $leaderboard_query);
    $leaderboard_data = mysqli_fetch_all($leaderboard_result, MYSQLI_ASSOC);

    // Check competition status
    $sql = "SELECT CompetitionEndDate, CompetitionEndTime FROM competitionInfo ORDER BY CompetitionID DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $competitionEnd = new DateTime($row['CompetitionEndDate'] . ' ' . $row['CompetitionEndTime'], new DateTimeZone('Asia/Kolkata'));
    $now = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
    $competition_ended = $now > $competitionEnd;

    // Validate session
    $query = "SELECT * FROM usersessions WHERE UserID = ? AND SessionID = ?";
    $stmt = mysqli_prepare($conn, $query);
    $session_id = session_id();
    mysqli_stmt_bind_param($stmt, "is", $user_id, $session_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $session_valid = mysqli_num_rows($result) > 0;

    return [
        'game_data' => $game_data,
        'leaderboard_data' => $leaderboard_data,
        'competition_ended' => $competition_ended,
        'session_valid' => $session_valid,
        'max_level_reached' => $max_level_reached
    ];
}

if (isset($_GET['action']) && $_GET['action'] === 'update') {
    header('Content-Type: application/json');
    echo json_encode(getDashboardData($conn, $user_id));
    exit();
}

$dashboard_data = getDashboardData($conn, $user_id);
$game_data = $dashboard_data['game_data'];
$leaderboard_data = $dashboard_data['leaderboard_data'];
$competition_ended = $dashboard_data['competition_ended'];
$session_valid = $dashboard_data['session_valid'];
$max_level_reached = $dashboard_data['max_level_reached'];

// Handle answer submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $query = "SELECT Answer FROM gamedetails WHERE QuestionID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $game_data['QuestionID']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $correct_answer = mysqli_fetch_assoc($result)['Answer'];

    if (strtolower($answer) === strtolower($correct_answer)) {
        // Update score and move to next level
        $new_score = $game_data['Score'] + 200;
        $new_level = $game_data['CurrentLevel'] + 1;
        $update_query = "UPDATE leaderboard SET Score = ? WHERE SchoolID = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ii", $new_score, $game_data['SchoolID']);
        mysqli_stmt_execute($stmt);

        // Update CurrentLevel in schooldata
        $update_level_query = "UPDATE schooldata SET CurrentLevel = ? WHERE SchoolID = ?";
        $stmt = mysqli_prepare($conn, $update_level_query);
        mysqli_stmt_bind_param($stmt, "ii", $new_level, $game_data['SchoolID']);
        mysqli_stmt_execute($stmt);

        // Recalculate ranks
        $rank_query = "SET @rank = 0; 
                       UPDATE leaderboard 
                       SET sRank = (@rank := @rank + 1) 
                       ORDER BY Score DESC, LastUpdated ASC";
        mysqli_multi_query($conn, $rank_query);

        // Redirect to refresh the page and show next question
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Incorrect answer. Try again after the 5 second cooldown.";
    }
}
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
    <title>Game Arena | Crypticon 2024</title>
</head>
<body>
    <?php include_once("header.php") ?>
    <main>
        <div class="game-area">
            <div class="question-box">
                <h2>Level : <?php echo $game_data['CurrentLevel']; ?></h2>
                <?php if ($max_level_reached): ?>
                    <p>Congratulations! You've completed all levels!</p>
                <?php else: ?>
                    <p><?php echo $game_data['Question'] ?? 'No question available'; ?></p>
                    <?php if (isset($game_data['Link']) && $game_data['Link']): ?>
                        <p>Link: <a href="<?php echo $game_data['Link']; ?>" target="_blank"><?php echo $game_data['Link']; ?></a></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if (!$max_level_reached): ?>
                <div class="answer-input">
                    <form id="answer-form" method="POST">
                        <input type="text" id="answer" name="answer" placeholder="Your answer" required>
                        <button type="submit" id="submit-answer">Submit</button>
                    </form>
                    <?php if (isset($error_message)): ?>
                        <p class="error"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="leaderboard-timer">
            <div class="leaderboard">
                <h1>Ranking</h1>
                <table>
                    <tbody>
                    <?php foreach ($leaderboard_data as $rank => $team): ?>
                        <tr>
                            <td class="number"><?php echo $rank + 1; ?></td>
                            <td class="name"><?php echo $team['Username']; ?></td>
                            <td class="points"><?php echo $team['Score']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="user-rank">
                    <span class="rank-number"><?php echo $game_data['sRank']; ?></span>
                    <span class="rank-name"><?php echo $game_data['Username']; ?></span>
                    <span class="rank-points"><?php echo $game_data['Score']; ?></span>
                </div>
            </div>
            <div class="timer">
                <?php include_once("timer.php") ?>
            </div>
        </div>
    </main>
    <script>
    const submitButton = document.getElementById('submit-answer');
    const answerForm = document.getElementById('answer-form');

    if (answerForm) {
        answerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            submitButton.disabled = true;
            setTimeout(() => {
                submitButton.disabled = false;
            }, 5000);
            answerForm.submit();
        });
    }

    function updateDashboard() {
        fetch('dashboard.php?action=update')
            .then(response => response.json())
            .then(data => {
                updateLeaderboard(data.leaderboard_data);
                updateQuestion(data.game_data);
                checkCompetitionStatus(data.competition_ended);
                checkSession(data.session_valid);
                checkMaxLevelReached(data.max_level_reached);
            })
            .catch(error => console.error('Error:', error));
    }

    function updateLeaderboard(leaderboardData) {
        const leaderboardBody = document.querySelector('.leaderboard table tbody');
        leaderboardBody.innerHTML = '';
        leaderboardData.forEach((team, index) => {
            const row = `
                <tr>
                    <td class="number">${index + 1}</td>
                    <td class="name">${team.Username}</td>
                    <td class="points">${team.Score}</td>
                </tr>
            `;
            leaderboardBody.innerHTML += row;
        });
    }

    function updateQuestion(gameData) {
        const questionBox = document.querySelector('.question-box');
        questionBox.innerHTML = `
            <h2>Level : ${gameData.CurrentLevel}</h2>
            <p>${gameData.Question || 'No question available'}</p>
            ${gameData.Link ? `<p>Link: <a href="${gameData.Link}" target="_blank">${gameData.Link}</a></p>` : ''}
        `;
    }

    function checkCompetitionStatus(ended) {
        if (ended) {
            showCompetitionEndedPopup();
        }
    }

    function checkSession(valid) {
        if (!valid) {
            window.location.href = '../login.php';
        }
    }

    function checkMaxLevelReached(reached) {
        if (reached) {
            showCongratulationsPopup();
        }
    }

    function showCompetitionEndedPopup() {
        const popup = document.createElement('div');
        popup.innerHTML = `
            <div class="competition-ended-overlay">
                <div class="competition-ended-popup">
                    <h2>Competition Ended</h2>
                    <p>The competition has ended. You will be logged out in <span id="logoutTimer">5</span> seconds.</p>
                    <button onclick="logout()">Logout Now</button>
                </div>
            </div>
        `;
        document.body.appendChild(popup);
        startLogoutTimer();
    }

    function showCongratulationsPopup() {
        const popup = document.createElement('div');
        popup.innerHTML = `
            <div class="congratulations-overlay">
                <div class="congratulations-popup">
                    <h2>Congratulations!</h2>
                    <p>You've completed all levels!</p>
                    <p>You will be logged out in <span id="logoutTimer">5</span> seconds.</p>
                </div>
            </div>
        `;
        document.body.appendChild(popup);
        startLogoutTimer();
    }

    function startLogoutTimer() {
        let seconds = 5;
        const timerElement = document.getElementById('logoutTimer');
        const timer = setInterval(() => {
            seconds--;
            timerElement.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                logout();
            }
        }, 1000);
    }

    function logout() {
        window.location.href = 'logout.php';
    }

    setInterval(updateDashboard, 20000);
    updateDashboard(); // Initial update
    </script>
</body>
</html>

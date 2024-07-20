<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Interface</title>
    <link rel="stylesheet" href="game2.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Player'); ?></h1>
            <div class="profile-dropdown">
                <button class="profile-button">Profile</button>
                <div class="dropdown-content">
                    <a href="leaderboard.php">Leaderboard</a>
                    <a href="#profile">My Profile</a>
                    <a href="../index.php">Logout</a>
                </div>
            </div>
        </header>
        <main>
            <div class="game-area">
                <div class="question-box">
                    <!-- Question content will be loaded here -->
                    <?php
                    // Example question display
                    echo "<h2>Question:</h2>";
                    echo "<p>" . htmlspecialchars($currentQuestion ?? 'Loading question...') . "</p>";
                    // If there's an image, you can display it here
                    if (isset($questionImage)) {
                        echo "<img src='" . htmlspecialchars($questionImage) . "' alt='Question Image'>";
                    }
                    ?>
                </div>
                <div class="answer-input">
                    <input type="text" id="answer" placeholder="Your answer">
                    <button onclick="submitAnswer()">Submit</button>
                </div>
            </div>
            <div class="leaderboard">
                <iframe src="leaderboard.php" frameborder="0"></iframe>
            </div>
        </main>
        <footer>
            <div class="timer">
                Time Left: 
                <span id="time-left">
                    <?php
                    // PHP code to calculate and display the time left
                    $endTime = $_SESSION['game_end_time'] ?? time() + 3600; // Default 1 hour game time
                    $timeLeft = max(0, $endTime - time());
                    echo sprintf('%02d:%02d:%02d', ($timeLeft/3600),($timeLeft/60%60), $timeLeft%60);
                    ?>
                </span>
            </div>
            <div class="score">
                Your Points: <span id="player-score"><?php echo $_SESSION['score'] ?? 0; ?></span>
            </div>
        </footer>
    </div>

    <script>
        // Dropdown functionality
        document.querySelector('.profile-button').addEventListener('click', function() {
            document.querySelector('.dropdown-content').style.display = 
                document.querySelector('.dropdown-content').style.display === 'block' ? 'none' : 'block';
        });

        // Close the dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.profile-button')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === 'block') {
                        openDropdown.style.display = 'none';
                    }
                }
            }
        }

        // Timer functionality
        function updateTimer() {
            var timerElement = document.getElementById('time-left');
            var timeParts = timerElement.innerHTML.split(':');
            var seconds = parseInt(timeParts[0]) * 3600 + parseInt(timeParts[1]) * 60 + parseInt(timeParts[2]);
            
            if (seconds > 0) {
                seconds--;
                var hours = Math.floor(seconds / 3600);
                var minutes = Math.floor((seconds % 3600) / 60);
                var remainingSeconds = seconds % 60;
                timerElement.innerHTML = 
                    (hours < 10 ? '0' : '') + hours + ':' +
                    (minutes < 10 ? '0' : '') + minutes + ':' +
                    (remainingSeconds < 10 ? '0' : '') + remainingSeconds;
            }
        }

        setInterval(updateTimer, 1000);

        function submitAnswer() {
            // Implement answer submission logic here
            console.log("Answer submitted: " + document.getElementById('answer').value);
            // You would typically send this to the server via AJAX
        }
    </script>
</body>
</html>
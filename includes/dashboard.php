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
            <h2>Question:</h2>
            <p>Text</p>
            <p>Link :<a href="#">link text</a></p>
        </div>
        <div class="answer-input">
            <input type="text" id="answer" placeholder="Your answer">
            <button onclick="submitAnswer()">Submit</button>
        </div>
    </div>
    <div class="leaderboard-timer">
        <div class="leaderboard">
            <h1>Ranking</h1>
            <table>
                <tbody>
                <tr>
                    <td class="number">1</td>
                    <td class="name">Lee Taeyong 🏅</td>
                    <td class="points">258.244</td>
                </tr>
                <tr>
                    <td class="number">2</td>
                    <td class="name">Mark Lee</td>
                    <td class="points">258.242</td>
                </tr>
                <tr>
                    <td class="number">3</td>
                    <td class="name">Xiao Dejun</td>
                    <td class="points">258.223</td>
                </tr>
                <tr>
                    <td class="number">4</td>
                    <td class="name">Qian Kun</td>
                    <td class="points">258.212</td>
                </tr>
                <tr>
                    <td class="number">4</td>
                    <td class="name">Qian Kun</td>
                    <td class="points">258.212</td>
                </tr>
                <tr>
                    <td class="number">4</td>
                    <td class="name">Qian Kun</td>
                    <td class="points">258.212</td>
                </tr>
                <tr>
                    <td class="number">4</td>
                    <td class="name">Qian Kun</td>
                    <td class="points">258.212</td>
                </tr>
                <tr>
                    <td class="number">5</td>
                    <td class="name">Johnny Suh</td>
                    <td class="points">258.208</td>
                </tr>
                <tr>
                    <td class="number">5</td>
                    <td class="name">Johnny Suh</td>
                    <td class="points">258.208</td>
                </tr>
                <tr>
                    <td class="number">5</td>
                    <td class="name">Johnny Suh</td>
                    <td class="points">258.208</td>
                </tr>
                <tr>
                    <td class="number">5</td>
                    <td class="name">Johnny Suh</td>
                    <td class="points">258.208</td>
                </tr>
                <tr>
                    <td class="number">5</td>
                    <td class="name">Johnny Suh</td>
                    <td class="points">258.208</td>
                </tr>

                </tbody>
            </table>
            <div class="user-rank">
                <span class="rank-number">8</span>
                <span class="rank-name">Your Name</span>
                <span class="rank-points">245.123</span>
            </div>
        </div>
        <div class="timer">
            <div id="countdown">
                <?php include_once("timer.php") ?>
            </div>
        </div>
    </div>
</main>
</body>
</html>
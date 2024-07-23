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
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto suscipit minima ut molestias molestiae quae voluptate fugit. Ipsa, recusandae repellat nobis quidem asperiores, quam reprehenderit exercitationem vel obcaecati voluptates veniam! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi architecto eos laudantium recusandae consectetur quaerat adipisci itaque, numquam ipsam voluptates obcaecati dicta libero laboriosam ut! Voluptatibus adipisci nesciunt, officiis vitae eum tempora facilis modi veniam unde, inventore beatae obcaecati sit rerum excepturi cupiditate distinctio quod, cumque voluptatem! Voluptas amet enim perferendis tempora! Nihil nisi perferendis omnis voluptatibus fuga dignissimos eius quibusdam consectetur quisquam, cupiditate odio quod neque ullam iste officia! Animi exercitationem quod sit incidunt, ullam aspernatur eos, porro recusandae expedita possimus quos nesciunt explicabo tempora beatae eum veritatis, quasi libero deserunt nemo cum officiis cupiditate doloribus tenetur? Earum, aspernatur.</p>
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
            <div id="countdown">05:00</div>
        </div>
    </div>
</main>
</body>
<script>
window.addEventListener("load", function () {
    const loader = document.querySelector(".loader");
    setTimeout(function () {
        loader.classList.add("loaded");
        loader.style.display = "none";
    }, 1000);
});</script>
</html>
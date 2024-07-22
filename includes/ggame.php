<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>Responsive Navigation Menu Bar</title>
    <link rel="stylesheet" href="ggame.css">
</head>
<body>
    <header>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen'></i>
            <span class="logo navLogo"><a href="#">CrypticHunt</a></span>

            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="#">CrypticHunt</a></span>
                    <i class='bx bx-x siderbarClose'></i>
                </div>

                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Leaderboard</a></li>
                    <li><a href="#">Discord</a></li>
                    <!-- <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li> -->
                </ul>
            </div>

            <div class="darkLight-searchBox">
                <div class="dark-light">
                    <i class='bx bx-moon moon'></i>
                    <i class='bx bx-sun sun'></i>
                </div>

                <div class="searchBox">
                    <div class="searchToggle">
                        <i class='bx bx-x cancel'></i>
                        <i class='bx bx-search search'></i>
                    </div>

                    <div class="search-field">
                        <input type="text" placeholder="Search...">
                        <i class='bx bx-search'></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main content -->
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
        <div class="footer-logo">
            <img src="https://via.placeholder.com/100x40" alt="Logo" />
        </div>
        <div class="footer-copyright">
            &copy; 2024 Crypticon
        </div>
    </footer>

    <script>
        const body = document.querySelector("body"),
            nav = document.querySelector("nav"),
            modeToggle = document.querySelector(".dark-light"),
            searchToggle = document.querySelector(".searchToggle"),
            sidebarOpen = document.querySelector(".sidebarOpen"),
            siderbarClose = document.querySelector(".siderbarClose");

        let getMode = localStorage.getItem("mode");
        if (getMode && getMode === "dark-mode") {
            body.classList.add("dark");
        }

        // JavaScript to toggle dark and light mode
        modeToggle.addEventListener("click", () => {
            modeToggle.classList.toggle("active");
            body.classList.toggle("dark");

            // JavaScript to keep user-selected mode even after page refresh or file reopen
            if (!body.classList.contains("dark")) {
                localStorage.setItem("mode", "light-mode");
            } else {
                localStorage.setItem("mode", "dark-mode");
            }
        });

        // JavaScript to toggle search box
        searchToggle.addEventListener("click", () => {
            searchToggle.classList.toggle("active");
        });

        // JavaScript to toggle sidebar
        sidebarOpen.addEventListener("click", () => {
            nav.classList.add("active");
        });

        body.addEventListener("click", e => {
            let clickedElm = e.target;

            if (!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")) {
                nav.classList.remove("active");
            }
        });
    </script>
</body>
</html>

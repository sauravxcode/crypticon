<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../includes/header.css">
    <style>
        body {
            width: 100%;
            height: 100vh;
            font-family: "Space Grotesk", sans-serif;
            background-color: #0a0e17;
            color: #eaeaea;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            display: flex;
            flex-direction: row;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }

        .option {
            background-color: #1a1f2d;
            padding: 30px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            text-align: center;
            width: 250px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .option:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
        }

        .option i {
            font-size: 60px;
            color: #7289da;
            margin-bottom: 15px;
        }

        .option h2 {
            font-size: 24px;
            margin: 0;
            color: #eaeaea;
        }

        @media (max-width: 600px) {
            .option {
                flex: 1 1 100%;
                max-width: none;
            }
        }

        @media (max-width: 450px) {
            .container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen'></i>
            <span class="logo navLogo"><a href="dashboard.php">Admin Panel</a></span>

            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="#">Admin Panel</a></span>
                    <i class='bx bx-x siderbarClose'></i>
                </div>

                <ul class="nav-links">
                    <!-- <li><a href="dashboard.php">Home</a></li> -->
                    <li><a href="leaderboard.php">Leaderboard</a></li>
                    <!-- <li><a href="https://discord.gg/nXJ7pv5Zw4">Discord</a></li> -->
                </ul>
            </div>

    
            <div class="darkLight-searchBox searchToggle">
            <div class="profile-dropdown">
                <i class='bx bxs-user-circle' id="profile"></i>
                <div class="dropdown-content">
                    <a href="profile.php">My Profile</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
</div>
        </div>
    </nav>

    
    <div class="container">
        <div class="option" id="edit-user">
            <i class="fas fa-user-edit"></i>
            <h2>Edit User</h2>
        </div>
        <div class="option" id="edit-level">
            <i class="fas fa-tasks"></i>
            <h2>Edit Levels</h2>
        </div>
    </div>
    <script>
        const body = document.querySelector("body"),
            nav = document.querySelector("nav"),
            modeToggle = document.querySelector(".dark-light"),
            searchToggle = document.querySelector(".searchToggle"),
            sidebarOpen = document.querySelector(".sidebarOpen"),
            siderbarClose = document.querySelector(".siderbarClose");

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

        document.getElementById("edit-user").addEventListener("click", () => {
    window.location.href = "user-detail.php";
});

document.getElementById("edit-level").addEventListener("click", () => {
    window.location.href = "level-detail.php";
});

    </script>
</body>
</html>

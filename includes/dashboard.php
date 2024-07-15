<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Game Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            margin: 10px 0;
            font-size: 1em;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            width: 100%;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #f0f0f0;
        }

        .sidebar a.active {
            background-color: #e0f7e9;
            color: #333;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .logo {
            font-size: 1.5em;
            font-weight: 600;
            color: #333;
        }

        .profile-button {
            background-color: #32b768;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .profile-button i {
            margin-left: 10px;
        }

        .main-content {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .question-section {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 65%;
        }

        .question-section h2 {
            margin-top: 0;
        }

        .question-section input, .question-section button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .question-section button {
            background-color: #32b768;
            color: #ffffff;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .question-section button:hover {
            background-color: #28a745;
        }

        .leaderboard {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 30%;
        }

        .leaderboard h2 {
            margin-top: 0;
        }

        .leaderboard .entry {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .leaderboard .entry:last-child {
            border-bottom: none;
        }

        .leaderboard .entry span {
            font-weight: 600;
        }

        .leaderboard .entry .points {
            color: #888;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .question-section, .leaderboard {
                width: 100%;
                margin-top: 20px;
            }

            .sidebar {
                width: 100%;
                height: auto;
                box-shadow: none;
            }

            .content {
                padding: 10px;
            }

            .navbar {
                padding: 10px;
            }

            .main-content {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#dashboard" class="active"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
        <a href="#levels"><i class="fas fa-layer-group"></i>Levels</a>
        <a href="#boards"><i class="fas fa-th-large"></i>Boards</a>
        <a href="#settings"><i class="fas fa-cog"></i>Settings</a>
    </div>
    <div class="content">
        <nav class="navbar">
            <div class="logo">QuizGame</div>
            <button class="profile-button">Profile<i class="fas fa-user-circle"></i></button>
        </nav>
        <div class="main-content">
            <div class="question-section">
                <h2>Submit Your Answer</h2>
                <input type="text" placeholder="Question" />
                <input type="text" placeholder="Answer" />
                <button type="submit">Submit</button>
            </div>
            <div class="leaderboard">
                <h2>Leaderboards</h2>
                <div class="entry">
                    <span>1. RoadWarrior1</span>
                    <span class="points">1230 pts</span>
                </div>
                <div class="entry">
                    <span>2. Myst10</span>
                    <span class="points">1200 pts</span>
                </div>
                <div class="entry">
                    <span>3. WarriorWolf0</span>
                    <span class="points">1100 pts</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

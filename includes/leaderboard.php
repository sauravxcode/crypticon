<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            overflow: hidden; /* Prevents body overflow */
        }

        .leaderboard-container {
            width: 100%;
            max-width: 1000px;
            max-height: 90vh; /* Limits height to 90% of viewport height */
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            box-sizing: border-box;
            overflow: auto; /* Adds scroll if content overflows */
        }

        .leaderboard-container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }

        .top-three {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .top-three .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 30%;
            margin-bottom: 20px;
        }

        .top-three .profile img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        .top-three .profile .name {
            font-size: 1.5em;
            font-weight: 600;
            margin: 10px 0;
            color: #444;
        }

        .top-three .profile .points {
            font-size: 1.2em;
            color: #888;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            text-align: left;
        }

        th {
            background-color: #f9f9f9;
            font-weight: 600;
        }

        .position {
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .top-three {
                flex-direction: column;
                align-items: center;
            }

            .top-three .profile {
                width: 80%;
                margin-bottom: 20px;
            }

            th, td {
                padding: 10px;
            }

            .leaderboard-container {
                padding: 15px;
                max-height: 80vh; /* Adjust for smaller screens */
            }
        }

        @media (max-width: 480px) {
            .leaderboard-container {
                padding: 10px;
                max-height: 70vh; /* Further adjust for very small screens */
            }

            .top-three .profile img {
                width: 100px;
                height: 100px;
            }

            .top-three .profile .name {
                font-size: 1.2em;
            }

            .top-three .profile .points {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="leaderboard-container">
        <h1>Leaderboard</h1>
        <div class="top-three">
            <div class="profile" id="second">
                <img src="https://via.placeholder.com/120" alt="Profile Image for Second Place">
                <div class="name">Name</div>
                <div class="points">Points</div>
            </div>
            <div class="profile" id="first">
                <img src="https://via.placeholder.com/120" alt="Profile Image for First Place">
                <div class="name">Name</div>
                <div class="points">Points</div>
            </div>
            <div class="profile" id="third">
                <img src="https://via.placeholder.com/120" alt="Profile Image for Third Place">
                <div class="name">Name</div>
                <div class="points">Points</div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Name</th>
                    <th>School</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody id="leaderboard">
                <!-- Leaderboard rows will be inserted here -->
            </tbody>
        </table>
    </div>

    <script>
        const leaderboardData = [
            { name: "Amit Sharma", school: "Delhi Public School", points: 1200 },
            { name: "Priya Singh", school: "Kendriya Vidyalaya", points: 1150 },
            { name: "Rahul Verma", school: "Sainik School", points: 1100 },
            { name: "Sneha Patil", school: "St. Xavier's School", points: 1050 },
            { name: "Anil Kumar", school: "Loreto Convent", points: 1000 },
            { name: "Ritu Choudhary", school: "Bal Bharti Public School", points: 950 },
            { name: "Nisha Jain", school: "Ryan International School", points: 900 },
            { name: "Karan Gupta", school: "Modern School", points: 850 },
        ];

        function populateLeaderboard() {
            const topThreeProfiles = document.querySelectorAll('.top-three .profile');
            const leaderboardBody = document.getElementById('leaderboard');

            leaderboardData.sort((a, b) => b.points - a.points);

            leaderboardData.slice(0, 3).forEach((profile, index) => {
                topThreeProfiles[index].querySelector('img').src = `https://randomuser.me/api/portraits/men/${index + 1}.jpg`; // Realistic image URLs
                topThreeProfiles[index].querySelector('.name').textContent = profile.name;
                topThreeProfiles[index].querySelector('.points').textContent = `${profile.points} pts`;
            });

            leaderboardData.slice(3).forEach((profile, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="position">${index + 4}</td>
                    <td>${profile.name}</td>
                    <td>${profile.school}</td>
                    <td>${profile.points} pts</td>
                `;
                leaderboardBody.appendChild(row);
            });
        }

        populateLeaderboard();
    </script>
</body>
</html>

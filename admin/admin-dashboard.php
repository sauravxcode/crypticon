<?php
session_start();
include("../u/config.php");

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../u/logout.php");
    exit();
}

// Fetch existing competition data
$sql = "SELECT * FROM competitionInfo ORDER BY CompetitionID DESC LIMIT 1";
$result = $conn->query($sql);
$competitionData = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../u/header.css">
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

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            animation: fadeIn 0.3s;
        }

        .modal-content {
            background-color: #1a1f2d;
            margin: 15% auto;
            padding: 20px;
            border-radius: 15px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            animation: slideIn 0.3s;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #7289da;
            text-decoration: none;
        }

        #competitionForm label {
            display: block;
            margin-top: 10px;
            color: #eaeaea;
        }

        #competitionForm input {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: none;
            border-radius: 5px;
            background-color: #2c3141;
            color: #eaeaea;
        }

        #competitionForm button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #7289da;
            color: #eaeaea;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #competitionForm button:hover {
            background-color: #5a6eaf;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @keyframes slideIn {
            from {transform: translateY(-50px);}
            to {transform: translateY(0);}
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
<?php include('admin-navbar.php'); ?>
    
    <div class="container">
        <div class="option" id="edit-user">
            <i class="fas fa-user-edit"></i>
            <h2>Edit User</h2>
        </div>
        <div class="option" id="edit-level">
            <i class="fas fa-tasks"></i>
            <h2>Edit Levels</h2>
        </div>
        <div class="option" id="edit-competition">
            <i class="fas fa-trophy"></i>
            <h2>Edit Game</h2>
        </div>
    </div>

    <div id="competitionModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Competition Info</h2>
            <form id="competitionForm">
                <label for="competitionDate">Competition Start Date:</label>
                <input type="date" id="competitionDate" name="competitionDate" value="<?php echo $competitionData['CompetitionDate']; ?>" required>
                
                <label for="startTime">Start Time:</label>
                <input type="time" id="startTime" name="startTime" value="<?php echo $competitionData['CompetitionStartTime']; ?>" required>

                <label for="competitionDate">Competition End Date:</label>
                <input type="date" id="competitionDate" name="competitionEndDate" value="<?php echo $competitionData['CompetitionEndDate']; ?>" required>
                
                <label for="endTime">End Time:</label>
                <input type="time" id="endTime" name="endTime" value="<?php echo $competitionData['CompetitionEndTime']; ?>" required>
                
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
</body>
<script>
    document.getElementById("edit-user").addEventListener("click", () => {
        window.location.href = "user-detail.php";
    });

    document.getElementById("edit-level").addEventListener("click", () => {
        window.location.href = "level-detail.php";
    });

    document.getElementById("edit-competition").addEventListener("click", () => {
        document.getElementById("competitionModal").style.display = "block";
    });

    document.getElementsByClassName("close")[0].addEventListener("click", () => {
        document.getElementById("competitionModal").style.display = "none";
    });

    document.getElementById("competitionForm").addEventListener("submit", (e) => {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        
        fetch('update_competition.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Competition info updated successfully!');
                document.getElementById("competitionModal").style.display = "none";
            } else {
                alert('Error updating competition info. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
</script>

</html>

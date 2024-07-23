<?php
session_start();
include("../includes/config.php");

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
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
    </div>
</body>
<script>
    document.getElementById("edit-user").addEventListener("click", () => {
        window.location.href = "user-detail.php";
    });

    document.getElementById("edit-level").addEventListener("click", () => {
        window.location.href = "level-detail.php";
    });
</script>

</html>

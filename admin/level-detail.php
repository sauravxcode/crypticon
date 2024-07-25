<?php
session_start();
include("../includes/config.php");

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../logout.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $level = $_POST['level'];
    $question = $_POST['question'];
    $link = $_POST['link'];
    $answer = $_POST['answer'];

    $sql = "INSERT INTO gamedetails (Level, Question, Link, Answer) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $level, $question, $link, $answer);
    mysqli_stmt_execute($stmt);
}

$sql = "SELECT * FROM gamedetails ORDER BY Level";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Levels</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="edit-level.css">
    <script>
    function confirmDelete(questionId) {
        if (confirm("Are you sure you want to delete this question?")) {
            window.location.href = "delete-level.php?id=" + questionId;
        }
    }
    </script>
</head>
<body>
<?php include ("admin-navbar.php"); ?>
    <div class="container">
        <h1 class="page-title">Manage Levels</h1>
        <div class="form-container">
            <div class="form-section">
                <form method="POST" action="">
                    <div class="input-container">
                        <div class="level-info">
                            <h2 class="section-title">Level Info</h2>
                            <div class="form-group">
                                <input type="number" id="inputLevelNo" name="level" placeholder="Level No." required>
                            </div>
                            <div class="form-group">
                                <textarea id="inputQuestion" name="question" placeholder="Question" required></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputLink" name="link" placeholder="Link">
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputAnswer" name="answer" placeholder="Answer" required>
                            </div>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <button type="submit" class="btn"><i class="fas fa-save"></i> Add Level</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="level-table-container">
            <table class="level-table">
                <thead>
                    <tr>
                        <th>Level No.</th>
                        <th>Question</th>
                        <th>Link</th>
                        <th>Answer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['Level']; ?></td>
                        <td><?php echo $row['Question']; ?></td>
                        <td><a href="<?php echo $row['Link']; ?>" target="_blank">Link</a></td>
                        <td><?php echo $row['Answer']; ?></td>
                        <td>
                            <a href="edit-level.php?id=<?php echo $row['QuestionID']; ?>" class="action-btn"><i class="fas fa-edit"></i></a>
                            <button onclick="confirmDelete(<?php echo $row['QuestionID']; ?>)" class="action-btn"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

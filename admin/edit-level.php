<?php
session_start();
include("../u/config.php");

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../u/logout.php");
    exit();
}

$questionId = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $level = $_POST['level'];
    $question = $_POST['question'];
    $link = $_POST['link'];
    $answer = $_POST['answer'];

    $sql = "UPDATE gamedetails SET Level = ?, Question = ?, Link = ?, Answer = ? WHERE QuestionID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssi", $level, $question, $link, $answer, $questionId);
    mysqli_stmt_execute($stmt);

    header("Location: level-detail.php?message=Level updated successfully");
    exit();
}

$sql = "SELECT * FROM gamedetails WHERE QuestionID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $questionId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$levelData = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Level</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="edit-level.css">
</head>
<body>
<?php include ("admin-navbar.php"); ?>
    <div class="container">
        <h1 class="page-title">Edit Level</h1>
        <div class="form-container">
            <div class="form-section">
                <form method="POST" action="">
                    <div class="input-container">
                        <div class="level-info">
                            <h2 class="section-title">Level Info</h2>
                            <div class="form-group">
                                <input type="number" id="inputLevelNo" name="level" placeholder="Level No." value="<?php echo $levelData['Level']; ?>" required>
                            </div>
                            <div class="form-group">
                                <textarea id="inputQuestion" name="question" placeholder="Question" required><?php echo $levelData['Question']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputLink" name="link" placeholder="Link" value="<?php echo $levelData['Link']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputAnswer" name="answer" placeholder="Answer" value="<?php echo $levelData['Answer']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <button type="submit" class="btn"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

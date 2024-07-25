<?php
session_start();
include("../includes/config.php");

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../logout.php");
    exit();
}

if (isset($_GET['id'])) {
    $questionId = $_GET['id'];

    $sql = "DELETE FROM gamedetails WHERE QuestionID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $questionId);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: level-detail.php?message=Level deleted successfully");
    } else {
        header("Location: level-detail.php?error=Failed to delete level");
    }
    exit();
} else {
    header("Location: level-detail.php");
    exit();
}

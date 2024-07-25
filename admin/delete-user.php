<?php
session_start();
include("../includes/config.php");

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../logout.php");
    exit();
}

if (isset($_GET['id'])) {
    $schoolId = $_GET['id'];

    mysqli_begin_transaction($conn);

    try {
        // Get the UserID from userlogin
        $sql = "SELECT UserID FROM userlogin WHERE SchoolID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $schoolId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $userRow = mysqli_fetch_assoc($result);
        $userId = $userRow['UserID'];

        // Delete from usersessions table
        $sql = "DELETE FROM usersessions WHERE UserID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);

        // Delete from teammembers table
        $sql = "DELETE FROM teammembers WHERE SchoolID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $schoolId);
        mysqli_stmt_execute($stmt);

        // Delete from Leaderboard table
        $sql = "DELETE FROM leaderboard WHERE SchoolID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $schoolId);
        mysqli_stmt_execute($stmt);

        // Delete from userlogin table
        $sql = "DELETE FROM userlogin WHERE SchoolID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $schoolId);
        mysqli_stmt_execute($stmt);

        // Delete from schooldata table
        $sql = "DELETE FROM schooldata WHERE SchoolID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $schoolId);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);

        header("Location: user-detail.php?message=User deleted successfully");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: user-detail.php?error=Failed to delete user: " . $e->getMessage());
        exit();
    }
} else {
    header("Location: user-detail.php");
    exit();
}

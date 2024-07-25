<?php
require_once 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

$query = "SELECT g.QuestionID, g.Question, g.Link 
          FROM schooldata s 
          JOIN userlogin u ON s.SchoolID = u.SchoolID
          JOIN gamedetails g ON s.CurrentLevel = g.Level
          WHERE u.UserID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$game_data = mysqli_fetch_assoc($result);

echo json_encode($game_data);
?>

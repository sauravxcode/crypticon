<?php
require_once '../includes/config.php';

$leaderboard_query = "SELECT s.SchoolName, u.Username, l.Score, l.sRank 
                      FROM leaderboard l 
                      JOIN schooldata s ON l.SchoolID = s.SchoolID 
                      JOIN userlogin u ON s.SchoolID = u.SchoolID
                      WHERE u.Username != 'admin'
                      ORDER BY l.Score DESC, l.sRank ASC 
                      LIMIT 10";

$leaderboard_result = mysqli_query($conn, $leaderboard_query);
$leaderboard_data = mysqli_fetch_all($leaderboard_result, MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($leaderboard_data);

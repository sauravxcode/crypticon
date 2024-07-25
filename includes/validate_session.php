<?php
require_once 'config.php';
session_start();

function validateSession($conn, $user_id, $session_id) {
    $query = "SELECT * FROM usersessions WHERE UserID = ? AND SessionID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $session_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}

if (!validateSession($conn, $_SESSION['user_id'], session_id())) {
    echo json_encode(['valid' => false]);
} else {
    echo json_encode(['valid' => true]);
}
?>

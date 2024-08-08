<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json');

include("../u/config.php");

try {
    $competitionDate = $_POST['competitionDate'];
    $startTime = $_POST['startTime'];
    $competitionEndDate = $_POST['competitionEndDate'];
    $endTime = $_POST['endTime'];

    $sql = "UPDATE competitionInfo SET 
            CompetitionDate = ?, 
            CompetitionStartTime = ?, 
            competitionEndDate = ?,
            CompetitionEndTime = ? 
            WHERE CompetitionID = (SELECT MAX(CompetitionID) FROM (SELECT CompetitionID FROM competitionInfo) AS temp)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $competitionDate, $startTime, $competitionEndDate, $endTime);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception($conn->error);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $conn->close();
}

exit();

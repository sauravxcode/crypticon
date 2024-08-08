<?php
require_once 'config.php';

// Fetch competition info from database
$sql = "SELECT CompetitionDate, CompetitionEndDate, CompetitionStartTime, CompetitionEndTime FROM competitionInfo ORDER BY CompetitionID DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$competitionStart = new DateTime($row['CompetitionDate'] . ' ' . $row['CompetitionStartTime'], new DateTimeZone('Asia/Kolkata'));
$competitionEnd = new DateTime($row['CompetitionEndDate'] . ' ' . $row['CompetitionEndTime'], new DateTimeZone('Asia/Kolkata'));
$now = new DateTime('now', new DateTimeZone('Asia/Kolkata'));

// Calculate total duration in seconds
$duration = $competitionEnd->getTimestamp() - $competitionStart->getTimestamp();
?>

<div id="countdown"></div>

<script>
function updateCountdown() {
    var now = new Date().getTime();
    var start = new Date("<?php echo $competitionStart->format('Y-m-d H:i:s'); ?>").getTime();
    var end = new Date("<?php echo $competitionEnd->format('Y-m-d H:i:s'); ?>").getTime();
    var totalDuration = <?php echo $duration; ?> * 1000; // Convert to milliseconds

    var countdownElement = document.getElementById("countdown");

    if (now < start) {
        var timeLeft = start - now;
        var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        var hours = Math.floor(timeLeft / (1000 * 60 * 60));
        var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        if (days >= 2) {
            countdownElement.innerHTML = days + " days";
        } else {
            countdownElement.innerHTML = hours.toString().padStart(2, '0') + ":" +
                                         minutes.toString().padStart(2, '0') + ":" +
                                         seconds.toString().padStart(2, '0');
        }
        countdownElement.style.color = "white";
    } else if (now < end) {
        var timeLeft = end - now;
        var percentageLeft = (timeLeft / totalDuration) * 100;

        var hours = Math.floor(timeLeft / (1000 * 60 * 60));
        var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        if (percentageLeft <= 5) {
            countdownElement.style.color = "#FF000D";
        } else if (percentageLeft <= 30) {
            countdownElement.style.color = "#FFFF00";
        } else {
            countdownElement.style.color = "white";
        }

        countdownElement.innerHTML = hours.toString().padStart(2, '0') + ":" + 
                                     minutes.toString().padStart(2, '0') + ":" + 
                                     seconds.toString().padStart(2, '0');
    } else {
        countdownElement.innerHTML = "Ended";
        countdownElement.style.color = "#AAFF00";
    }
}

setInterval(updateCountdown, 1000);
updateCountdown();
</script>

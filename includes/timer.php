<?php
$targetDate = new DateTime('24-08-2024 02:00:00', new DateTimeZone('Asia/Kolkata'));
$now = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
?>

<div id="countdown"></div>

<script>
function updateCountdown() {
    var now = new Date().getTime();
    var target = new Date("<?php echo $targetDate->format('Y-m-d H:i:s'); ?>").getTime();
    var distance = target - now;

    var countdownElement = document.getElementById("countdown");

    if (distance > 0) {
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (distance <= 2 * 60 * 60 * 1000) {
            countdownElement.style.color = "#FF000D";
        } else if (distance <= 10 * 60 * 60 * 1000) {
            countdownElement.style.color = "#FFFF00";
        } else {
            countdownElement.style.color = "white";
        }
        countdownElement.innerHTML = days + " days ";
    } else {
        var elapsedTime = Math.abs(distance);
        var remainingTime = 24 * 60 * 60 * 1000 - (elapsedTime % (24 * 60 * 60 * 1000));
        
        var hours = Math.floor(remainingTime / (1000 * 60 * 60));
        var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
        
        if (hours >= 10) {
            countdownElement.style.color = "#AAFF00";
        } else if (hours >= 2) {
            countdownElement.style.color = "#FFFF00";
        } else {
            countdownElement.style.color = "#FF000D";
        }
        
        countdownElement.innerHTML = hours.toString().padStart(2, '0') + ":" + 
                                     minutes.toString().padStart(2, '0') + ":" + 
                                     seconds.toString().padStart(2, '0');
    }
}

setInterval(updateCountdown, 1000);
updateCountdown();
</script>

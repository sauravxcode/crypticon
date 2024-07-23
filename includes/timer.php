<?php
    $targetDate = new DateTime('2024-08-24 12:00:00', new DateTimeZone('Asia/Kolkata'));
    $now = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
    $interval = $now->diff($targetDate);

    if ($interval->days > 0) {
        echo $interval->format('%a days');
    } else {
        $remainingSeconds = $interval->h * 3600 + $interval->i * 60 + $interval->s;
        echo sprintf('%02d:%02d:%02d', ($remainingSeconds/3600), ($remainingSeconds/60%60), $remainingSeconds%60);
    }
?>
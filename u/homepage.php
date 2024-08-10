<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    header("Location: logout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Let's play | Crypticon 2024</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="../css/loaders/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
     <!-- Loader Start -->
        <div class="loader">
    <div class="loader__container">
        <div class="pyramid-loader">
            <div class="wrapper">
                <span class="side side1"></span>
                <span class="side side2"></span>
                <span class="side side3"></span>
                <span class="side side4"></span>
                <span class="shadow"></span>
            </div>  
        </div>
    </div>
</div>
        <!-- Loader End -->
    <button class="logout-btn" id="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> LOGOUT</button>
    <div class="content">
        <div class="section">
            <div>
                Crypticon 2024
            </div>
            <button id="gameplay"> LET'S PLAY 🡥</button>
        </div>
    </div>

    <canvas id="neuro"></canvas>

    <script type="x-shader/x-fragment" id="vertShader">
        precision mediump float;

        varying vec2 vUv;
        attribute vec2 a_position;

        void main() {
            vUv = .5 * (a_position + 1.);
            gl_Position = vec4(a_position, 0.0, 1.0);
        }
    </script>

    <script type="x-shader/x-fragment" id="fragShader">
        precision mediump float;

        varying vec2 vUv;
        uniform float u_time;
        uniform float u_ratio;
        uniform vec2 u_pointer_position;
        uniform float u_scroll_progress;

        vec2 rotate(vec2 uv, float th) {
            return mat2(cos(th), sin(th), -sin(th), cos(th)) * uv;
        }

        float neuro_shape(vec2 uv, float t, float p) {
            vec2 sine_acc = vec2(0.);
            vec2 res = vec2(0.);
            float scale = 8.;

            for (int j = 0; j < 15; j++) {
                uv = rotate(uv, 1.);
                sine_acc = rotate(sine_acc, 1.);
                vec2 layer = uv * scale + float(j) + sine_acc - t;
                sine_acc += sin(layer);
                res += (.5 + .5 * cos(layer)) / scale;
                scale *= (1.2 - .07 * p);
            }
            return res.x + res.y;
        }

        void main() {
            vec2 uv = .5 * vUv;
            uv.x *= u_ratio;

            vec2 pointer = vUv - u_pointer_position;
            pointer.x *= u_ratio;
            float p = clamp(length(pointer), 0., 1.);
            p = .5 * pow(1. - p, 2.);

            float t = .001 * u_time;
            vec3 color = vec3(0.);

            float noise = neuro_shape(uv, t, p);

            noise = 1.2 * pow(noise, 3.);
            noise += pow(noise, 10.);
            noise = max(.0, noise - .5);
            noise *= (1. - length(vUv - .5));

          color = normalize(vec3(0.6, 0.1 + 0.2 * cos(3. * u_scroll_progress), 0.9 + 0.4 * sin(3. * u_scroll_progress)));




            color = color * noise;

            gl_FragColor = vec4(color, noise);
        }
    </script>

    <script src="homepage.js"></script>
</body>
</html>

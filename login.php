<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CodePen - Mouse Orbit</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="login.css">
</head>
<body>   
<div id="container">
  <canvas id="canvas"></canvas>
  <div class="login-container">
    <div class="login-form">
        <div class="text">
           USER LOGIN
        </div>
        <form id="login-form">
           <div class="field">
              <div class="fas fa-envelope"></div>
              <input type="text" placeholder="Email or Phone">
           </div>
           <div class="field">
              <div class="fas fa-lock"></div>
              <input type="password" placeholder="Password">
           </div>
           <button type="submit" id="login-game">LOGIN 🡥</button>
           <div class="link">
              Have a Question?
              <a href="https://www.google.com">Join Discord</a>
           </div>
        </form>
     </div>
    </div>
</div>
<!-- partial -->
<script>
document.getElementById("login-form").addEventListener("submit", (event) => {
    event.preventDefault();
    window.location.href = "../includes/game.php";
});
</script>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js'></script>
<script src="login.js"></script>
</body>
</html>

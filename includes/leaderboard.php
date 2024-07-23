<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="leaderboard.css">
  </head>
  <body>
  <?php
   include ("header.php"); 
   ?>
    <main>
      <div id="header">
        <h1>Ranking</h1>
      </div>
      <div id="leaderboard">
        <div class="ribbon"></div>
        <table>
          <tbody> 
          <tr>
            <td class="number">1</td>
            <td class="name">Lee Taeyong</td>
            <td class="points">
              258.244 <img class="gold-medal" src="https://github.com/malunaridev/Challenges-iCodeThis/blob/master/4-leaderboard/assets/gold-medal.png?raw=true" alt="gold medal"/>
            </td>
          </tr>
          <tr>
            <td class="number">2</td>
            <td class="name">Mark Lee</td>
            <td class="points">258.242</td>
          </tr>
          <tr>
            <td class="number">3</td>
            <td class="name">Xiao Dejun</td>
            <td class="points">258.223</td>
          </tr>
          <tr>
            <td class="number">4</td>
            <td class="name">Qian Kun</td>
            <td class="points">258.212</td>
          </tr>
          <tr>
            <td class="number">5</td>
            <td class="name">Johnny Suh</td>
            <td class="points">258.208</td>
          </tr>
          </tbody>
        </table>
        <div id="buttons">
        </div>
      </div>
    </main>
  </body>
</html>
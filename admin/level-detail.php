<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Levels</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="edit-level.css"> <!-- Link to the CSS file -->
</head>
<body>
<?php
   include ("admin-navbar.php"); 
   ?>
    <div class="container">
        <h1 class="page-title">Manage Levels</h1>
        <div class="form-container">
            <div class="form-section">
                <form>
                    <div class="input-container">
                        <div class="level-info">
                            <h2 class="section-title">Level Info</h2>
                            <div class="form-group">
                                <input type="text" id="inputLevelNo" placeholder="Level No.">
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputQuestion" placeholder="Question">
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputLink" placeholder="Link">
                            </div>
                            <div class="form-group">
                                <input type="text" id="inputAnswer" placeholder="Answer">
                            </div>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <button type="submit" class="btn"><i class="fas fa-save"></i>  Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="level-table-container">
            <table class="level-table">
                <thead>
                    <tr>
                        <th>Level No.</th>
                        <th>Question</th>
                        <th>Link</th>
                        <th>Answer</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>What is the capital of France?</td>
                        <td><a href="#">Link</a></td>
                        <td>Paris</td>
                        <td>
                            <button class="action-btn"><i class="fas fa-edit"></i></button>
                            <button class="action-btn"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

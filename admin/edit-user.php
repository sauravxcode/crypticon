<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;700&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="edit-user.css"> <!-- Link to the CSS file -->
</head>
<body>
<?php
   include ("admin-navbar.php"); 
   ?>
    <div class="container">
        <h1 class="page-title">Manage Users</h1>
        <div class="form-container">
            <div class="form-section">
                <form>
                    <div class="input-container">
                    <div class="private-info">
                    <h2 class="section-title">Private Info</h2>
                    <div class="form-group">
                        <input type="text" id="inputSchoolName" placeholder="School Name">
                    </div>
                    <div class="form-group">
                        <input type="email" id="inputEmail" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="text" id="inputAddress" placeholder="Address: 1234 Main St">
                    </div>
                    <div class="form-group">
                        <input type="text" id="inputContact" placeholder="9999999999">
                    </div>
                    <div class="form-group">
                        <input type="text" id="inputUserphoto" placeholder="Insert the link..">
                    </div>
                    </div>
                    <div class="member-info">
                    <h2 class="section-title">Member Info</h2>
                    <div class="form-group">
                        <input type="text" id="inputMember1" placeholder="Member 1">
                    </div>
                    <div class="form-group">
                        <input type="text" id="inputMember2" placeholder="Member 2">
                    </div>
                    <div class="form-group">
                        <input type="text" id="inputMember3" placeholder="Member 3">
                    </div>
                    </div>
                    </div>
                    <div class="submit-btn">
                    <button type="submit" class="btn"><i class="fas fa-save"></i>  Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

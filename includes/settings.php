<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="settings.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Private Info -->
            <div class="form-section">
                <h2 class="section-title">Private Info</h2>
                <form>
                    <div class="form-group">
                        <label for="inputFirstName">First Name</label>
                        <input type="text" id="inputFirstName" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <label for="inputLastName">Last Name</label>
                        <input type="text" id="inputLastName" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" id="inputEmail" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <input type="text" id="inputAddress" placeholder="1234 Main St">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Address 2</label>
                        <input type="text" id="inputAddress2" placeholder="Apartment, studio, or floor">
                    </div>
                    <div class="form-group">
                        <label for="inputCity">City</label>
                        <input type="text" id="inputCity">
                    </div>
                    <div class="form-group">
                        <label for="inputState">State</label>
                        <select id="inputState">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputZip">Zip</label>
                        <input type="text" id="inputZip">
                    </div>
                    <button type="submit" class="btn">Save Changes</button>
                </form>
            </div>
            <!-- Public Info -->
            <div class="form-section">
                <h2 class="section-title">Public Info</h2>
                <form>
                    <div class="form-group">
                        <label for="inputUsername">Username</label>
                        <input type="text" id="inputUsername" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="inputBio">Biography</label>
                        <textarea id="inputBio" rows="4" placeholder="Tell something about yourself"></textarea>
                    </div>
                    <div class="form-group image-upload">
                        <label for="imageUpload" class="upload-label">Profile Picture</label>
                        <input type="file" id="imageUpload" class="file-input">
                        <img id="preview" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="Profile Picture">
                        <small>For best results, use an image at least 128px by 128px in .jpg format</small>
                    </div>
                    <button type="submit" class="btn">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

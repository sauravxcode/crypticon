<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamer Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0a0e17;
            --text-color: #e0e0e0;
            --input-bg: #1a1f2e;
            --border-color: #3a4a5c;
            --accent-color: #00ff00;
            --accent-hover: #00cc00;
            --remove-color: #ff3333;
            --remove-hover: #cc0000;
            --neon-glow: 0 0 5px #00ff00, 0 0 10px #00ff00, 0 0 15px #00ff00;
        }

        body {
            font-family: 'Orbitron', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(0, 255, 0, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(0, 255, 255, 0.05) 0%, transparent 20%);
            background-attachment: fixed;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: rgba(26, 31, 46, 0.8);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.2);
        }

        h1, h2 {
            color: var(--accent-color);
            text-shadow: var(--neon-glow);
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: var(--accent-color);
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            box-sizing: border-box;
            background-color: var(--input-bg);
            color: var(--text-color);
            font-family: 'Orbitron', sans-serif;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            box-shadow: 0 0 5px var(--accent-color);
        }

        .profile-photo {
            text-align: center;
        }

        .profile-photo-placeholder {
            width: 200px;
            height: 200px;
            background-color: var(--input-bg);
            border: 2px solid var(--accent-color);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 10px var(--accent-color);
        }

        .profile-photo-placeholder::after {
            content: '\1F464';
            font-size: 100px;
            color: var(--accent-color);
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-upload {
            background-color: var(--accent-color);
            color: var(--bg-color);
        }

        .btn-upload:hover {
            background-color: var(--accent-hover);
            box-shadow: var(--neon-glow);
        }

        .btn-remove {
            background-color: var(--remove-color);
            color: var(--text-color);
        }

        .btn-remove:hover {
            background-color: var(--remove-hover);
            box-shadow: 0 0 5px var(--remove-color), 0 0 10px var(--remove-color);
        }

        .photo-note {
            font-size: 12px;
            color: var(--text-color);
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gamer Profile</h1>
        <div class="profile-grid">
            <div class="contact-details">
                <h2>Contact Info</h2>
                <div class="form-group">
                    <label for="firstName">First Name *</label>
                    <input type="text" id="firstName" value="Scaralet">
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name *</label>
                    <input type="text" id="lastName" value="Doe">
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone number *</label>
                    <input type="text" id="phoneNumber" value="(333) 000 555">
                </div>
                <div class="form-group">
                    <label for="mobileNumber">Mobile number *</label>
                    <input type="text" id="mobileNumber" value="+91 9852 8855 252">
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" value="example@homerealty.com">
                </div>
                <div class="form-group">
                    <label for="skype">Skype *</label>
                    <input type="text" id="skype" value="Scaralet D">
                </div>
            </div>
            <div class="profile-photo">
                <h2>Avatar Upload</h2>
                <div class="profile-photo-placeholder"></div>
                <button class="btn btn-upload">Upload</button>
                <button class="btn btn-remove">Remove</button>
                <p class="photo-note">Note: Minimum size 300px x 300px</p>
            </div>
        </div>
    </div>
</body>
</html>
<?php
session_start(); // Start the session

// Handle form submission (if needed for contact form)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add form handling logic here if required
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Health Axis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #525B44;
            color: #E1E1E1;
            text-align: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .home-button {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 28px;
            color: #E1E1E1;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .home-button:hover {
            color: #85A98F;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #E1E1E1;
        }

        .contact-info {
            background-color: #fff;
            color: #525B44;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            text-align: left;
        }

        .contact-info p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .contact-info a {
            color: #85A98F;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .contact-info a:hover {
            color: #6A7F61;
        }
    </style>
</head>
<body>
    <!-- Home Button -->
    <a href="welcome.php" class="home-button" aria-label="Go to Home">
        <i class="fas fa-home"></i>
    </a>

    <h2>Contact Us</h2>

    <div class="contact-info">
        <p>If you have any questions or need assistance, feel free to reach out to us:</p>
        
        <p><strong>Phone Number:</strong> 01845091417</p>
        <p><strong>WhatsApp:</strong> <a href="https://wa.me/01845091417" target="_blank">01845091417</a></p>
        <p><strong>Facebook:</strong> <a href="https://www.facebook.com/healthaxis" target="_blank">Health Axis</a></p>
    </div>

</body>
</html>

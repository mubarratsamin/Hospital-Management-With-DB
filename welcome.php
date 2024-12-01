<?php
session_start(); // Start the session to access user data

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$user_name = $_SESSION['name']; // Fetch the user's name from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Health Axis</title>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #525B44; /* Dark olive background color */
            background-image: 
                /* Subtle noise texture */
                linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%), 
                linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%);
            background-size: 10px 10px; /* Adjust size for desired texture intensity */
            background-position: 0 0, 5px 5px; /* Shift the second layer for effect */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #E1E1E1; /* Light text color for readability */
            text-align: center;
            position: relative; /* Required for positioning the logout and contact buttons */
        }

        h2 {
            font-size: 28px;
            color: #E1E1E1; /* Light text color */
            margin-bottom: 20px;
            font-weight: bold;
        }

        .welcome-message {
            font-size: 20px;
            margin-bottom: 30px;
            color: #E1E1E1; /* Light text color */
            font-weight: lighter;
        }

        .button-group {
            display: flex;
            flex-direction: row; /* Change to horizontal layout */
            gap: 15px;
            justify-content: center; /* Center the buttons horizontally */
            margin-bottom: 30px;
        }

        .button-group a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            background-color: #85A98F; /* Soft green button color */
            color: #fff;
            border-radius: 50px; /* More rounded buttons */
            font-size: 18px;
            text-decoration: none;
            text-align: center;
            width: auto; /* Allow width to adjust to content */
            box-sizing: border-box;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            border: 1px solid transparent;
        }

        .button-group a i {
            margin-right: 10px; /* Space between the icon and text */
            font-size: 22px;
        }

        .button-group a:hover {
            background-color: #6A7F61; /* Slightly darker on hover */
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Soft shadow effect */
        }

        .button-group a:active {
            transform: translateY(1px); /* Slight depression on click */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Logout button style */
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background-color: #85A98F; /* Red-orange color */
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #6A7F61;
        }

        .logout-btn:active {
            transform: translateY(1px); /* Slight depression on click */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Contact Us button style */
        .contact-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 15px;
            background-color: #85A98F; /* Teal color */
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .contact-btn:hover {
            background-color: #6A7F61;
        }

        .contact-btn:active {
            transform: translateY(1px); /* Slight depression on click */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 16px;
            margin-top: 20px;
        }

        a {
            color: #E1E1E1; /* Light color for links */
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <button class="contact-btn" onclick="window.location.href='contact.php';">
        <i class="fas fa-envelope"></i> Contact Us
    </button>
    <button class="logout-btn" onclick="window.location.href='login.php';">
        <i class="fas fa-sign-out-alt"></i> Logout
    </button>
    
    <div>
        <h2>Welcome to Health Axis</h2>
        <p class="welcome-message">Hello, <?php echo htmlspecialchars($user_name); ?>! Welcome back to your Health Axis dashboard.</p>

        <div class="button-group">
            <a href="doctors.php">
                <i class="fas fa-stethoscope"></i> Doctor's List
            </a>
            <a href="medical_shop.php">
                <i class="fas fa-shopping-cart"></i> Medical Shop
            </a>
            <a href="review.php">
                <i class="fas fa-pencil-alt"></i> Leave a Review
            </a>
        </div>
    </div>
</body>
</html>

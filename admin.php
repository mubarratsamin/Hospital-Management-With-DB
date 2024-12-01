<?php
session_start(); // Start the session to access admin data



$admin_name = $_SESSION['name']; // Fetch the admin's name from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Health Axis</title>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add similar CSS styles as in the original user dashboard */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #525B44; /* Dark olive background color */
            background-image: 
                linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%), 
                linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%);
            background-size: 10px 10px; /* Adjust size for desired texture intensity */
            background-position: 0 0, 5px 5px; /* Shift the second layer for effect */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #E1E1E1;
            text-align: center;
            position: relative;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .welcome-message {
            font-size: 20px;
            margin-bottom: 30px;
            font-weight: lighter;
        }

        .button-group {
            display: flex;
            flex-direction: row;
            gap: 15px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .button-group a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            background-color: #85A98F; /* Soft green button color */
            color: #fff;
            border-radius: 50px;
            font-size: 18px;
            text-decoration: none;
            text-align: center;
            width: auto;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .button-group a i {
            margin-right: 10px;
            font-size: 22px;
        }

        .button-group a:hover {
            background-color: #6A7F61;
            transform: translateY(-2px);
        }

        

        p {
            font-size: 16px;
            margin-top: 20px;
        }

        a {
            color: #E1E1E1;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div>
        <h2>Admin Dashboard - Health Axis</h2>
        <p class="welcome-message">Welcome back, Admin You can manage the doctors, reviews, and medical shop here.</p>

        <div class="button-group">
            <!-- Manage Doctors Button -->
            <a href="add_doctor.php">
                <i class="fas fa-stethoscope"></i> Manage Doctors
            </a>

            <!-- Manage Reviews Button -->
            <a href="manage_reviews.php">
                <i class="fas fa-pencil-alt"></i> Manage Reviews
            </a>

            <!-- Manage Medical Shop Button -->
            <a href="manage_shop.php">
                <i class="fas fa-cogs"></i> Manage Shop
            </a>
        </div>
    </div>
</body>
</html>

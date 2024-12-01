<?php
session_start(); // Start session handling

$servername = "localhost:3306"; // Adjust if necessary
$username = "root";
$password = "";
$dbname = "healthaxis"; // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process registration if the form is submitted
if (isset($_POST['register-button'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if the passwords match
    if ($password !== $confirm_password) {
        // Handle error (for example, display a message)
    } else {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT Email FROM users WHERE Email = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error . " SQL: SELECT Email FROM users WHERE Email = ?");
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Handle error (email already exists)
        } else {
            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO users (Name, Email, Password, registration_date) VALUES (?, ?, ?, NOW())");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error . " SQL: INSERT INTO users (Name, Email, Password, registration_date) VALUES (?, ?, ?, NOW())");
            }
            $stmt->bind_param("sss", $name, $email, $password); // Store plain password

            if ($stmt->execute()) {
                header('Location: login.php'); // Redirect to login page after successful registration
                exit;
            } else {
                // Handle error during insert
            }
        }
    }

    // Redirect back to the registration page
    header('Location: registration.php');
    exit;
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Health Axis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #85A98F;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #525B44;
            color: #E0E8D0;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input {
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            padding: 12px;
            background-color: #85A98F;
            color: #525B44;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        button:hover {
            background-color: #E0E8D0;
        }

        a {
            color: #85A98F;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register for Health Axis</h2>
        <form action="registration.php" method="POST">
            <input type="text" id="name" name="name" placeholder="Full Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
            <button type="submit" name="register-button">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>

<?php
session_start(); // Start session to store user information

$servername = "localhost:3306"; // Adjust if necessary
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "healthaxis"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login if form is submitted
if (isset($_POST['login-button'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute query to check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check if passwords match
        if ($user['password'] === $password) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            
            // Redirect to dashboard after successful login
            header('Location: welcome.php');
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Health Axis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #85A98F; /* Light Green */
            color: #525B44; /* Dark Olive */
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 400px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 100px auto;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        label {
            text-align: left;
            font-weight: bold;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #85A98F;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #6A7F61;
        }

        .error {
            color: #ff0000;
            margin-top: 10px;
        }

        p {
            margin-top: 20px;
        }

        a {
            color: #525B44;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login to Health Axis</h2>
        <form action="login.php" method="POST">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login-button">Login</button>
        </form>

        <?php
        // Display error message if there is any
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <p>Don't have an account? <a href="registration.php">Sign up here</a>.</p>
    </div>
</body>
</html>

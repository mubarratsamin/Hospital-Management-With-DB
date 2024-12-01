<?php
session_start(); // Start session to check user access

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "healthaxis"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the search query
$search_query = "";

// Check if the search form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_query = $conn->real_escape_string($_POST['search']); // Escape user input

    // SQL query to search by name or sector
    $sql = "SELECT id, name, sector FROM doctors 
            WHERE name LIKE '%$search_query%' 
            OR sector LIKE '%$search_query%'";
} else {
    // Default query to display all doctors
    $sql = "SELECT id, name, sector FROM doctors";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's List - Health Axis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #525B44;
            color: #E1E1E1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 32px;
        }

        .search-form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 300px;
        }

        .search-form button {
            padding: 10px 15px;
            background-color: #85A98F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-form button:hover {
            background-color: #6A7F61;
        }

        .doctor-list {
            width: 80%;
            max-width: 600px;
            background-color: #6A7F61;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .doctor {
            display: flex;
            justify-content: space-between;
            padding: 12px 20px;
            border-bottom: 1px solid #85A98F;
        }

        .doctor:last-child {
            border-bottom: none;
        }

        .doctor span {
            font-weight: bold;
        }

        .appointment-btn {
            padding: 8px 15px;
            background-color: #85A98F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .appointment-btn:hover {
            background-color: #6A7F61;
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
    </style>
</head>
<body>
<a href="welcome.php" class="home-button" aria-label="Go to Home">
        <i class="fas fa-home"></i>
    </a>
    <h2>Our Doctors</h2>

    <!-- Search Form -->
    <form class="search-form" method="POST" action="doctors.php">
        <input type="text" name="search" placeholder="Search by name or sector" value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Doctor List -->
    <div class="doctor-list">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each doctor
            while ($row = $result->fetch_assoc()) {
                echo '<div class="doctor">';
                echo '<span>' . htmlspecialchars($row['name']) . '</span>';
                echo '<span>' . htmlspecialchars($row['sector']) . '</span>';
                // Appointment button with a link to an appointment page, passing the doctor's ID
                echo '<a href="appointment.php?doctor_id=' . $row['id'] . '" class="appointment-btn">Book Appointment</a>';
                echo '</div>';
            }
        } else {
            echo "<p>No doctors found.</p>";
        }
        $conn->close(); // Close the connection
        ?>
    </div>
</body>
</html>

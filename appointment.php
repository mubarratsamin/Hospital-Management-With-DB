<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "healthaxis");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if doctor_id is provided
if (isset($_GET['doctor_id'])) {
    $doctor_id = intval($_GET['doctor_id']);  // Ensure the ID is an integer for security
    $sql = "SELECT name, sector, photo, number, start_time, end_time FROM doctors WHERE id = ?";
    
    // Use a prepared statement for security
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $doctor = $result->fetch_assoc();
    } else {
        echo "Doctor not found.";
        exit;
    }
} else {
    echo "No doctor selected.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - <?php echo htmlspecialchars($doctor['name']); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .doctor-details {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        img {
            max-width: 150px;
            border-radius: 50%;
        }
        .details {
            margin-top: 15px;
        }
        .details p {
            margin: 8px 0;
        }
        .back-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 15px;
            background-color: #85A98F;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="doctor-details">
        <img src="<?php echo htmlspecialchars($doctor['photo']); ?>" alt="Doctor's Photo">
        <h2><?php echo htmlspecialchars($doctor['name']); ?></h2>
        <div class="details">
            <p><strong>Sector:</strong> <?php echo htmlspecialchars($doctor['sector']); ?></p>
            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($doctor['number']); ?></p>
            <p><strong>Available:</strong> <?php echo htmlspecialchars($doctor['start_time']); ?> - <?php echo htmlspecialchars($doctor['end_time']); ?></p>
        </div>
        <a href="doctors.php" class="back-btn">Back to Doctor List</a>
    </div>
</body>
</html>

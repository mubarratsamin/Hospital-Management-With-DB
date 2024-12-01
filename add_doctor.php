<?php
session_start(); // Start session to check user access

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

// Handle form submission to add doctor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_doctor'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $sector = $conn->real_escape_string($_POST['sector']);
    $number = $conn->real_escape_string($_POST['number']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    
    // Handle photo upload
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_name = $_FILES['photo']['name'];
        $photo_ext = pathinfo($photo_name, PATHINFO_EXTENSION);
        
        // Generate a unique name for the photo to prevent overwriting
        $photo_name_new = uniqid('', true) . '.' . $photo_ext;
        
        // Define the target directory
        $upload_dir = 'uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $photo_path = $upload_dir . $photo_name_new;
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($photo_tmp, $photo_path)) {
            $photo = $photo_path; // Save the path of the uploaded photo
        } else {
            $message = "Error uploading photo.";
        }
    }

    // Insert doctor data into the database
    $sql = "INSERT INTO doctors (name, sector, number, start_time, end_time, photo) 
            VALUES ('$name', '$sector', '$number', '$start_time', '$end_time', '$photo')";

    if ($conn->query($sql) === TRUE) {
        $message = "Doctor added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Get doctor ID to delete
    $delete_sql = "DELETE FROM doctors WHERE id = $delete_id";

    if ($conn->query($delete_sql) === TRUE) {
        $message = "Doctor deleted successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch doctors list from the database
$result = $conn->query("SELECT * FROM doctors");

$conn->close(); // Close the connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add & Manage Doctors - Health Axis</title>
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

        .container {
            background-color: #6A7F61;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input, button {
            margin-bottom: 15px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        input {
            background-color: #E1E1E1;
            color: #333;
        }

        button {
            background-color: #85A98F;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #5C7458;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #85A98F;
            color: white;
        }

        .delete-btn {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .delete-btn:hover {
            background-color: #c9302c;
        }

        .message {
            text-align: center;
            color: yellow;
            margin-bottom: 15px;
        }

        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
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
<a href="admin.php" class="home-button" aria-label="Go to Home">
        <i class="fas fa-home"></i>
    </a>
    <div class="container">
        <h2>Add Doctor</h2>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="add_doctor.php" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Doctor's Name" required>
            <input type="text" name="sector" placeholder="Sector" required>
            <input type="text" name="number" placeholder="Contact Number" required>
            <input type="time" name="start_time" required>
            <input type="time" name="end_time" required>
            <input type="file" name="photo" accept="image/*"> <!-- Photo Upload -->
            <button type="submit" name="add_doctor">Add Doctor</button>
        </form>

        <h2>Doctor List</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Sector</th>
                    <th>Contact Number</th>
                    <th>Working Hours</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['sector']); ?></td>
                        <td><?php echo htmlspecialchars($row['number']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_time']) . " - " . htmlspecialchars($row['end_time']); ?></td>
                        <td>
                            <?php if (!empty($row['photo'])): ?>
                                <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Doctor Photo">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this doctor?');">
                                <button class="delete-btn">Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

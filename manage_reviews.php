<?php
session_start();


// Database connection settings
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "healthaxis"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle review deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $message = "Review deleted successfully.";
    } else {
        $message = "Error deleting review.";
    }
    $stmt->close();
}

// Fetch all reviews
$reviews = $conn->query("SELECT reviews.id, users.name, reviews.review, reviews.rating, reviews.created_at
                         FROM reviews 
                         JOIN users ON reviews.user_id = users.id
                         ORDER BY reviews.created_at DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews - Health Axis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add the previous styling here or modify as needed */
        body {
            font-family: Arial, sans-serif;
            background-color: #525B44;
            color: #E1E1E1;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #6A7F61;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .reviews-section {
            background-color: #6A7F61;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: left;
        }
        .review-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .review-item:last-child {
            border-bottom: none;
        }
        .review-item strong {
            color: #FFD700;
        }
        .actions a {
            color: #FFD700;
            text-decoration: none;
            margin-right: 15px;
        }
        .message {
            font-weight: bold;
            color: #FFD700;
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
    <h2>Manage Reviews</h2>
    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
</div>

<div class="reviews-section">
    <h2>All Reviews</h2>
    <?php if ($reviews->num_rows > 0): ?>
        <?php while($row = $reviews->fetch_assoc()): ?>
            <div class="review-item">
                <p><strong><?php echo htmlspecialchars($row['name']); ?>:</strong></p>
                <p><?php echo htmlspecialchars($row['review']); ?></p>
                <p>Rating: <?php echo $row['rating']; ?>/5</p>
                <p><small>Reviewed on: <?php echo $row['created_at']; ?></small></p>
                <div class="actions">
                    <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No reviews yet.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>

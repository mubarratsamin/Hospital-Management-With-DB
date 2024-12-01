<?php
session_start(); // Start the session to access user data

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Database connection settings
$servername = "localhost";
$username = "root";    // Replace with your MySQL username
$password = "";    // Replace with your MySQL password
$dbname = "healthaxis";         // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $review = htmlspecialchars(trim($_POST['review']));
    $rating = intval($_POST['rating']);

    if (!empty($review) && $rating >= 1 && $rating <= 5) {
        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, review, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $_SESSION['user_id'], $review, $rating);

        // Execute and check if successful
        if ($stmt->execute()) {
            $message = "Review submitted successfully!";
        } else {
            $message = "Error submitting review.";
        }
        $stmt->close();
    } else {
        $message = "Please fill in the review and provide a valid rating.";
    }
}

// Fetch and display reviews
$reviews = $conn->query("SELECT users.name, reviews.review, reviews.rating, reviews.created_at 
                         FROM reviews 
                         JOIN users ON reviews.user_id = users.id 
                         ORDER BY reviews.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave a Review - Health Axis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
            max-width: 500px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        textarea, select {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            resize: vertical;
        }
        button {
            padding: 10px 20px;
            background-color: #85A98F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #5E7460;
        }
        .message {
            margin-top: 10px;
            font-weight: bold;
            color: #FFD700;
        }
        .reviews-section {
            background-color: #6A7F61;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
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
    <div class="container">
        <h2>Leave a Review</h2>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
        <form action="review.php" method="POST">
            <textarea name="review" rows="5" placeholder="Write your review here..." required></textarea>
            <select name="rating" required>
                <option value="">Select Rating</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Very Poor</option>
            </select>
            <button type="submit">Submit Review</button>
        </form>
    </div>

    <div class="reviews-section">
        <h2>User Reviews</h2>
        <?php if ($reviews->num_rows > 0): ?>
            <?php while($row = $reviews->fetch_assoc()): ?>
                <div class="review-item">
                    <p><strong><?php echo htmlspecialchars($row['name']); ?>:</strong></p>
                    <p><?php echo htmlspecialchars($row['review']); ?></p>
                    <p>Rating: <?php echo $row['rating']; ?>/5</p>
                    <p><small><?php echo $row['created_at']; ?></small></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to leave one!</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>

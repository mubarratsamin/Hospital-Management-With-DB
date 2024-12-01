<?php
// Database connection
$servername = "localhost"; // Change if necessary
$username = "root";             // Your MySQL username
$password = "";                 // Your MySQL password
$dbname = "healthaxis";         // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding a new product
if (isset($_POST['submit_add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);

    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';  // Directory to save uploaded images
        $file_tmp_name = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_path = $upload_dir . $file_name;

        // Check if the directory exists, if not create it
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($file_tmp_name, $file_path)) {
            $image = $file_path;  // Store the relative path in the database
        } else {
            echo "<p style='color: red;'>Error uploading image.</p>";
        }
    }

    // Insert product into the products table
    $sql = "INSERT INTO products (name, description, price, image) 
            VALUES ('$name', '$description', '$price', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Product added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Handle deleting a product
if (isset($_GET['delete_product_id'])) {
    $product_id = intval($_GET['delete_product_id']);

    // Delete product from the products table
    $sql = "DELETE FROM products WHERE id = $product_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Product deleted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

// Fetch all products to display for deletion
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Shop - HealthAxis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset and Global Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background: linear-gradient(to right, #174f3c, #000000);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 20px;
            text-align: center;
        }

        h1 {
            color: #fff;
            margin-bottom: 30px;
        }

        .form-container, .product-list {
            width: 80%;
            margin-bottom: 30px;
        }

        .form-container input, .form-container textarea, .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form-container input[type="submit"] {
            background: #003565;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background: #0062bc;
        }

        .product-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-item button {
            background: #e60000;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .product-item button:hover {
            background: #ff3333;
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
<h1>Manage Shop - HealthAxis</h1>

<!-- Add Product Form -->
<div class="form-container">
    <h2>Add New Product</h2>
    <form action="manage_shop.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Product Description" required></textarea>
        <input type="number" name="price" step="0.01" placeholder="Price" required>
        
        <!-- File Upload Input -->
        <input type="file" name="image" accept="image/*" required>
        
        <input type="submit" name="submit_add_product" value="Add Product">
    </form>
</div>

<!-- Display Existing Products -->
<div class="product-list">
    <h2>Existing Products</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-item">';
            echo '<span>' . $row["name"] . ' - ৳' . $row["price"] . '</span>';
            // Display the uploaded image
            if ($row["image"]) {
                echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '" width="100">';
            }
            echo '<button onclick="window.location.href=\'manage_shop.php?delete_product_id=' . $row["id"] . '\'">Delete</button>';
            echo '</div>';
        }
    } else {
        echo '<p>No products available.</p>';
    }
    ?>
</div>

</body>
</html>

<?php
$conn->close();
?>

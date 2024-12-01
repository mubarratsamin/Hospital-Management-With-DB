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

// Handle form submission (purchase process)
if (isset($_POST['submit_purchase'])) {
    $product_id = $_POST['product_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $quantity = intval($_POST['quantity']);
    $total = floatval($_POST['product_price']) * $quantity;
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $transaction_id = $conn->real_escape_string($_POST['transaction_id']);
    $sender_number = $conn->real_escape_string($_POST['sender_number']);

    // Insert the data into the purchase table
    $sql = "INSERT INTO purchases (product_id, name, payment_method, transaction_id, sender_number, quantity, total) 
            VALUES ('$product_id', '$name', '$payment_method', '$transaction_id', '$sender_number', '$quantity', '$total')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Purchase recorded successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Fetch products based on search input
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM products WHERE name LIKE '%$search%' OR type LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Axis - Medical Shop</title>
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
            background: #525B44;
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

        /* Search bar */
        .search-bar {
            margin-bottom: 30px;
        }

        .search-input {
            padding: 10px;
            width: 300px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .search-button {
            padding: 10px;
            background: #003565;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .search-button:hover {
            background: #0062bc;
        }

        /* Product grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Adjusted minimum width for items */
            gap: 20px;
            width: 85%; /* Limit width to 85% of the parent container */
            margin-top: 30px;
        }

        /* Product item size */
        .product-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px; /* Reduced padding to make items more compact */
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            max-width: 320px; /* Set a max width for better consistency */
            margin: 0 auto; /* Center the items inside their container */
        }

        .product-item img {
            max-width: 100%;
            height: auto; /* Ensure the image maintains its aspect ratio */
            border-radius: 5px;
        }

        .product-item h3 {
            margin-top: 10px;
            font-size: 1.2rem; /* Make the product name slightly smaller */
        }

        .product-item span {
            font-weight: bold;
            display: block;
            margin: 10px 0;
            font-size: 1rem; /* Adjust font size */
        }

        .buy-btn {
            background: #85A98F;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .buy-btn:hover {
            background: #5E7460;
        }

        /* Buy Box Modal */
        .buy-box {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7); /* Dark background */
            justify-content: center;
            align-items: center;
            z-index: 1000; /* Ensure it's above all other content */
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        /* When the modal is active, show it with fade-in effect */
        .buy-box.show {
            display: flex;
            opacity: 1;
        }

        /* Buy Box Content Styling */
        .buy-box-content {
            background: #b4c797;
            padding: 30px;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out;
            transform: scale(0.9);
        }

        /* When the modal is active, scale up the content */
        .buy-box.show .buy-box-content {
            transform: scale(1);
        }

        /* Close button styling */
        .buy-box-content button {
            background: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s ease;
            margin-top: 20px;
            width: 100%;
            font-size: 16px;
        }

        .buy-box-content button:hover {
            background: #c0392b;
        }

        /* Input Fields */
        .buy-box-content input,
        .buy-box-content select {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        /* Label Styling */
        .buy-box-content label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        /* Total Amount Styling */
        .buy-box-content label span {
            font-size: 1.2rem;
            font-weight: bold;
            color: #27ae60; /* Green for the total */
        }

        /* Button in the form */
        .buy-box-content button[type="submit"] {
            background: #0a4a39;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            padding: 12px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .buy-box-content button[type="submit"]:hover {
            background: #6ab569;
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
    <h1>Health Axis - Medical Shop</h1>

    <!-- Search Bar -->
    <div class="search-bar">
        <form action="medical_shop.php" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Search Health Products">
            <button type="submit" class="search-button"><i class="fas fa-search"></i> Search</button>
        </form>
    </div>

    <!-- Products Display -->
    <div class="product-grid">
        <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="product-item">
            <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
            <h3><?php echo $row['name']; ?></h3>
            <span>Price: ৳<?php echo number_format($row['price'], 2); ?></span>
            <button class="buy-btn" onclick="openBuyBox(<?php echo $row['id']; ?>, <?php echo $row['price']; ?>)">Buy Now</button>
        </div>
        <?php } ?>
    </div>

    <!-- Buy Box Modal -->
    <div id="buy-box" class="buy-box">
        <div class="buy-box-content">
            <h3>Complete Your Purchase</h3>
            <x> Recipient's Number: 01545091417 </x>
            <br>
            <form action="medical_shop.php" method="POST">
                <input type="hidden" name="product_id" id="product_id">
                <input type="hidden" name="product_price" id="product_price">
                <label for="name">Your Name</label>
                <input type="text" name="name" required>
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" min="1" value="1" id="quantity" oninput="updateTotal()" required>
                <label for="payment_method">Payment Method</label>
                <select name="payment_method" required>
                    <option value="bKash">bKash</option>
                    <option value="Nagad">Nagad</option>
                    <option value="Rocket">Rocket</option>
                </select>
                <label for="transaction_id">Transaction ID</label>
                <input type="text" name="transaction_id" required>
                <label for="sender_number">Sender's Number</label>
                <input type="text" name="sender_number" required>
                <label>Total: <span id="total-amount">৳0.00</span></label>
                <button type="submit" name="submit_purchase">Confirm Purchase</button>
                <button type="button" onclick="closeBuyBox()">Close</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Open the buy box modal
    function openBuyBox(productId, productPrice) {
        document.getElementById("product_id").value = productId;
        document.getElementById("product_price").value = productPrice;
        document.getElementById("buy-box").classList.add('show');
        updateTotal(); // Update total when opening the buy box
    }

    // Close the buy box modal
    function closeBuyBox() {
        document.getElementById("buy-box").classList.remove('show');
    }

    // Update the total amount when quantity changes
    function updateTotal() {
        const price = parseFloat(document.getElementById("product_price").value);
        const quantity = parseInt(document.getElementById("quantity").value);
        const total = price * quantity;
        document.getElementById("total-amount").textContent = '৳' + total.toFixed(2);
    }
</script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>

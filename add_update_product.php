<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$dbname = "inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$quantity = $_POST['quantity'];
$cost = $_POST['cost'];

// SQL to add or update product (based on name)
$sql = "INSERT INTO Inventory (product_name, quantity, price) VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE quantity = VALUES(quantity), price = VALUES(price)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $name, $quantity, $cost);

if ($stmt->execute()) {
    echo "Product added/updated successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

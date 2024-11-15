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
$quantity = (int)$_POST['quantity'];

// SQL to check current quantity
$sql = "SELECT quantity FROM Inventory WHERE product_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentQuantity = $row['quantity'];

    if ($currentQuantity <= $quantity) {
        // Delete the product if quantity to delete is equal to or greater than current quantity
        $sql = "DELETE FROM Inventory WHERE product_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        echo "Product deleted successfully";
    } else {
        // Update the quantity
        $newQuantity = $currentQuantity - $quantity;
        $sql = "UPDATE Inventory SET quantity = ? WHERE product_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $newQuantity, $name);
        $stmt->execute();
        echo "Product quantity updated successfully";
    }
} else {
    echo "Product not found";
}

$stmt->close();
$conn->close();
?>

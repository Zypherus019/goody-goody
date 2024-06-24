<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_support_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

    $sql = "UPDATE $category SET quantity = ? WHERE name = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $quantity, $name);

    if ($stmt->execute()) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

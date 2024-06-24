<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_support_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$table = $_POST['table'];
$name = $_POST['name'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$valid_tables = ['beverages_categories', 'can_goods_categories','cigarettes_categories','household_supplies_categories','snacks_categories','school_supplies_categories'];
if (!in_array($table, $valid_tables)) {
    die("Invalid table selected.");
}

$stmt = $conn->prepare("INSERT INTO $table (name, quantity, price) VALUES (?, ?, ?)");
$stmt->bind_param("sdd", $name, $quantity, $price);

if ($stmt->execute()) {
    echo "<script>alert('Data inserted successfully'); window.location.href = document.referrer;</script>";
} else {
    echo "<script>alert('Error: " . $stmt->error . "');</script>";
}

$stmt->close();
$conn->close();
?>

<?php
$servername = "sql213.infinityfree.com";
$username = "if0_36778106";
$password = "judemax123";
$dbname = "if0_36778106_inventory_support_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if all required POST parameters are present
if (!isset($_POST['table'], $_POST['name'], $_POST['quantity'], $_POST['price'])) {
    die("Missing POST parameters.");
}

// Sanitize input
$table = $_POST['table'];
$name = $_POST['name'];
$quantity = floatval($_POST['quantity']); // Convert to float if necessary
$price = floatval($_POST['price']); // Convert to float if necessary

// Valid tables array
$valid_tables = ['beverages_categories', 'can_goods_categories', 'cigarettes_categories', 'household_supplies_categories', 'snacks_categories', 'school_supplies_categories'];

// Check if table is valid
if (!in_array($table, $valid_tables)) {
    die("Invalid table selected.");
}

// Check if the product name already exists in the table
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM $table WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    // Product name already exists, show alert and redirect
    echo "<script>alert('Product name already exists.'); window.location.href = document.referrer;</script>";
    exit;
}

// If product name does not exist, proceed to insert
$stmt = $conn->prepare("INSERT INTO $table (name, quantity, price) VALUES (?, ?, ?)");
$stmt->bind_param("sdd", $name, $quantity, $price);

if ($stmt->execute()) {
    echo "<script>alert('Data inserted successfully.'); window.location.href = document.referrer;</script>";
} else {
    echo "<script>alert('Error: " . $stmt->error . "');</script>";
}

$stmt->close();
$conn->close();
?>

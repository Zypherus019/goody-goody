<?php
header('Content-Type: application/json');


$input = file_get_contents('php://input');
$data = json_decode($input, true);

$servername = "sql213.infinityfree.com";
$username = "if0_36778106";
$password = "judemax123";
$dbname = "if0_36778106_inventory_support_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Extract data from the JSON payload
$id = isset($data['id']) ? $data['id'] : null;
$name = isset($data['name']) ? $data['name'] : null;
$category = isset($data['category']) ? $data['category'] : null;
$price = isset($data['price']) ? $data['price'] : null;

// Check if all required data is present
if ($id === null || $name === null || $category === null || $price === null) {
    die(json_encode(['success' => false, 'message' => 'Missing required data']));
}

// Prepare SQL statement to update the item
$sql = "UPDATE your_table_name SET name='$name', category='$category', price=$price WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Item updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating item: ' . $conn->error]);
}

$conn->close();
?>

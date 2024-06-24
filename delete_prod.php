<?php
header('Content-Type: application/json');

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

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category = isset($_GET['category']) ? $_GET['category'] : '';

$tables = [
    'beverages' => 'beverages_categories',
    'can_goods' => 'can_goods_categories',
    'cigarettes' => 'cigarettes_categories',
    'household supplies' => 'household_supplies_categories',
    'snacks' => 'snacks_categories',
    'school_supplies' => 'school_supplies_categories'
];

if ($id && isset($tables[$category])) {
    $table = $tables[$category];
    $sql = "DELETE FROM $table WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Record deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting record: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'Invalid parameters']);
}

$conn->close();
?>

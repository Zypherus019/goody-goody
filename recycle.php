<?php
header('Content-Type: application/json');

// Get the data sent from the client-side JavaScript
$input = file_get_contents('php://input');
file_put_contents('debug.log', "Raw input: " . $input . PHP_EOL, FILE_APPEND); // Debugging line
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    file_put_contents('debug.log', 'JSON error: ' . json_last_error_msg() . PHP_EOL, FILE_APPEND); // Debugging line
    die(json_encode(['success' => false, 'message' => 'Invalid JSON payload: ' . json_last_error_msg()]));
}

if (!isset($data['id'], $data['category'], $data['name'], $data['quantity'], $data['price'])) {
    file_put_contents('debug.log', 'Missing parameters' . PHP_EOL, FILE_APPEND); // Debugging line
    die(json_encode(['success' => false, 'message' => 'Missing required parameters']));
}

$id = $data['id'];
$category = $data['category'];
$name = $data['name'];
$quantity = $data['quantity'];
$price = $data['price'];

// Database connection parameters
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

// Determine the source table based on the category
$source_table = "";
switch ($category) {
    case 'Beverages':
        $source_table = 'beverages_categories';
        break;
    case 'Can goods':
        $source_table = 'can_goods_categories';
        break;
    case 'Cigarettes':
        $source_table = 'cigarettes_categories';
        break;
    case 'Household supplies':
        $source_table = 'household_supplies_categories';
        break;
    case 'Snacks':
        $source_table = 'snacks_categories';
        break;
    case 'School supplies':
        $source_table = 'school_supplies_categories';
        break;
    default:
        die(json_encode(['success' => false, 'message' => 'Invalid category']));
}

// Transfer the item to the archive table
$sql = "INSERT INTO archive (name, category, price, quantity)
        VALUES ('$name', '$category', $price, $quantity)";
if ($conn->query($sql) === TRUE) {
    // Delete the item from the source table
    $conn->query("DELETE FROM $source_table WHERE id = $id");
    echo json_encode(['success' => true, 'message' => 'Item archived successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error transferring item to archive: ' . $conn->error]);
}

$conn->close();
?>

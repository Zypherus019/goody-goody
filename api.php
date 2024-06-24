<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_support_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category = isset($_GET['category']) ? $_GET['category'] : 'beverages';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$offset = ($page - 1) * $limit;

$tables = [
    'Beverages' => 'beverages_categories',
    'Can goods' => 'can_goods_categories',
    'Cigarettes' => 'cigarettes_categories',
    'Household supplies' => 'household_supplies_categories',
    'Snacks' => 'snacks_categories',
    'School supplies' => 'school_supplies_categories'
];

$data = [];
$sql = "";

if ($category === 'all') {
    foreach ($tables as $key => $table) {
        $sql .= "SELECT id, name, '$key' as category, price FROM $table UNION ";
    }
    $sql = rtrim($sql, " UNION ") . " LIMIT $limit OFFSET $offset";
} else {
    if (isset($tables[$category])) {
        $table = $tables[$category];
        $sql = "SELECT id, name, '$category' as category, price FROM $table LIMIT $limit OFFSET $offset";
    } else {
        // Handle the case where an invalid category is specified
        echo json_encode([]);
        $conn->close();
        exit();
    }
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
echo json_encode($data);

$conn->close();
?>

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

$query = $_POST['query'];

// Initialize results array
$results = [];

// Tables to search in (without "categories" suffix)
$tables = [
    'beverages',
    'can_goods',
    'cigarettes',
    'household_supplies',
    'snacks',
    'school_supplies'
];

$query = strtolower($query);

// Check if the query matches any table name
if (in_array($query, $tables)) {
    $table = $query . "_categories";
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = [
                'table' => str_replace('_categories', '', $table), // Remove "_categories" suffix
                'name' => $row['name'],
                'price' => isset($row['price']) ? $row['price'] : 'N/A',
                'quantity' => isset($row['quantity']) ? $row['quantity'] : 'N/A'
            ];
        }
    }
} else {
    // If query does not match any table, search within item names
    foreach ($tables as $table) {
        $sql = "SELECT * FROM {$table}_categories WHERE name LIKE '%$query%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $results[] = [
                    'table' => str_replace('_categories', '', $table), // Remove "_categories" suffix
                    'name' => $row['name'],
                    'price' => isset($row['price']) ? $row['price'] : 'N/A',
                    'quantity' => isset($row['quantity']) ? $row['quantity'] : 'N/A'
                ];
            }
        }
    }
}

// Display the results
if (count($results) > 0) {
    foreach ($results as $item) {
        echo "<div class='search-item'>";
        echo "<h3>" . htmlspecialchars($item['name']) . "</h3>";
        echo "<p>Category: " . htmlspecialchars($item['table']) . "</p>";
        echo "<p>Price: " . htmlspecialchars($item['price']) . "</p>";
        echo "<p>Quantity: " . htmlspecialchars($item['quantity']) . "</p>";
        echo "</div>";
    }
} else {
    echo "No results found";
}

$conn->close();
?>

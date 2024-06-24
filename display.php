<?php
// display.php

// Database connection
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

// Pagination setup
$items_per_page = 9;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Filter by category
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch products based on category and pagination
$products = [];

if (!empty($category_filter)) {
    $sql_count = "SELECT COUNT(*) AS total FROM $category_filter";
    $sql_products = "SELECT name, price, quantity, '$category_filter' AS category FROM $category_filter LIMIT $items_per_page OFFSET $offset";
} else {
    // Total count across all categories
    $sql_count = "SELECT COUNT(*) AS total FROM (
        SELECT * FROM beverages_categories
        UNION ALL
        SELECT * FROM can_goods_categories
        UNION ALL
        SELECT * FROM cigarettes_categories
        UNION ALL
        SELECT * FROM household_supplies_categories
        UNION ALL
        SELECT * FROM snacks_categories
        UNION ALL
        SELECT * FROM school_supplies_categories
    ) AS total_products";

    // Query to fetch from all categories (similar to your UNION ALL query)
    $sql_products = "SELECT name, price, quantity, 'beverages_categories' AS category FROM beverages_categories
            UNION ALL
            SELECT name, price, quantity, 'can_goods_categories' AS category FROM can_goods_categories
            UNION ALL
            SELECT name, price, quantity, 'cigarettes_categories' AS category FROM cigarettes_categories
            UNION ALL
            SELECT name, price, quantity, 'household_supplies_categories' AS category FROM household_supplies_categories
            UNION ALL
            SELECT name, price, quantity, 'snacks_categories' AS category FROM snacks_categories
            UNION ALL
            SELECT name, price, quantity, 'school_supplies_categories' AS category FROM school_supplies_categories
            LIMIT $items_per_page OFFSET $offset";
}

// Fetch total number of products
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_products = $row_count['total'];
$total_pages = ceil($total_products / $items_per_page);

// Fetch products
$result_products = $conn->query($sql_products);

if ($result_products->num_rows > 0) {
    while ($row = $result_products->fetch_assoc()) {
        $products[] = $row;
    }
}

// Close database connection
$conn->close();

// Check if it's an AJAX request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // AJAX request handling
    header('Content-Type: application/json');
    echo json_encode([
        'products' => $products,
        'total_pages' => $total_pages,
        'current_page' => $current_page
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Page</title>
    <link rel="stylesheet" href="css/display.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="display.js"></script>
</head>

<body>
<!-- Modal For Adding Products -->
<div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close" class="close" aria-label="Close modal">&times;</button>
            </div>
            <form method="POST" action="insert2.php">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Product</label>
                        <input type="text" class="form-control" name="name" placeholder="Product" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>No. of Items</label>
                        <input type="number" class="form-control" name="quantity" placeholder="Quantity" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Category</label>
                        <select name="table" id="table">
                            <option value="beverages_categories">Beverages</option>
                            <option value="can_goods_categories">Can Goods</option>
                            <option value="cigarettes_categories">Cigarettes</option>
                            <option value="household_supplies_categories">House Hold Supplies</option>
                            <option value="snacks_categories">Snacks</option>
                            <option value="school_supplies_categories">School Supplies</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group mb-3">
                        <label>Price</label>
                        <input type="text" class="form-control" name="price" placeholder="Price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close2" class="close" aria-label="Close modal">Close</button>
                    <button type="submit" class="btn btn-primary" value="Insert Data">Add</button>
                </div>
            </form>
        </div>
    </div>

<!-- right side-bar -->
<div class="btn-container">
        <h3 class="tool_header">Quick Access/Tools</h3>
        <button id="open" class="open"><i class='bx bx-box'></i> Add Product</button>
        <button id="archive" class="archive"><i class='bx bx-recycle'></i> Recycle Bin</button>
    </div>

<!-- Filter -->
<form class="filter">
            <label for="category">Filter by Category:</label>
            <select name="category" id="category" onchange="loadProducts(1)">
                <option value="">All Categories</option>
                <option value="beverages_categories">Beverages</option>
                <option value="can_goods_categories">Can Goods</option>
                <option value="cigarettes_categories">Cigarettes</option>
                <option value="household_supplies_categories">Household Supplies</option>
                <option value="snacks_categories">Snacks</option>
                <option value="school_supplies_categories">School Supplies</option>
            </select>
        </form>
        
    <div class="container">

        <div class="row" id="product-list">
            <!-- Products will be dynamically loaded here -->
        </div>
    </div>

    <div class="pagination" id="pagination">
        <!-- Pagination links will be dynamically updated here -->
    </div>
    <script src="modal_animation.js"></script>
    <script src="updateQuantity.js"></script>
</body>

</html>
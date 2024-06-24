<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = new PDO('mysql:host=localhost;dbname=inventory_support_system', 'root', '');
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $stmt = $pdo->prepare("INSERT INTO supplier (name, contact_num) VALUES (?, ?)");
    $stmt->execute([$name, $contact]);
    $pdo = null;

    echo "Data inserted successfully";
} else {
    http_response_code(405);
    echo "Invalid request method";
}
?>

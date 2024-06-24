<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = new PDO('mysql:host=localhost;dbname=inventory_support_system', 'root', '');

    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM supplier WHERE id = ?");
    $stmt->execute([$id]);

    $pdo = null;

    echo "Data deleted successfully";
} else {
    http_response_code(405);
    echo "Invalid request method";
}
?>
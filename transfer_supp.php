<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=inventory_support_system', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_POST['id'];

        // Start a transaction
        $pdo->beginTransaction();

        // Select the row to be transferred
        $stmt = $pdo->prepare("SELECT name, contact_num FROM supplier WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Prepare the insert into block_list
            $stmt = $pdo->prepare("INSERT INTO block_list (name, contact_num) VALUES (?, ?)");
            $stmt->execute([$row['name'], $row['contact_num']]);

            // Delete the row from suppliers
            $stmt = $pdo->prepare("DELETE FROM supplier WHERE id = ?");
            $stmt->execute([$id]);

            // Commit the transaction
            $pdo->commit();

            echo "Data transferred successfully";
        } else {
            echo "No data found with the given ID";
        }
    } catch (Exception $e) {
        // Rollback the transaction if something went wrong
        $pdo->rollBack();
        echo "Failed to transfer data: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
} else {
    http_response_code(405);
    echo "Invalid request method";
}
?>

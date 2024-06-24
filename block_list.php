<?php
$pdo = new PDO('mysql:host=localhost;dbname=inventory_support_system', 'root', '');
$stmt = $pdo->query('SELECT * FROM block_list');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td style="padding: 10px; color: white;">' . htmlspecialchars($row['name']) . '</td>';
    echo '<td style="padding: 10px; color: white;">' . htmlspecialchars($row['contact_num']) . '</td>';
    echo '<td><button class="returnBtn" data-id="' . $row['id'] . '" style="background-color: transparent; color: white; cursor: pointer;">&#128465;</button></td>'; 
    echo '</tr>';
}
?>

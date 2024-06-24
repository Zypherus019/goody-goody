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

$query_latest_id = "SELECT MAX(id) AS latest_id FROM profile";
$result_latest_id = $conn->query($query_latest_id);

if ($result_latest_id->num_rows > 0) {
    $row_latest_id = $result_latest_id->fetch_assoc();
    $latest_id = $row_latest_id['latest_id'];
} else {
    $latest_id = 0; 
}

$query = "SELECT * FROM profile WHERE id = '$latest_id'";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo '<label style="font-weight:bold; font-size:16px; margin-bottom:40px; margin-top:10px;">Name:  ' . $row['name'] . '</label>';
    echo '<label style="font-weight:bold; font-size:16px; margin-bottom:40px; margin-top:10px;">Date of Birth:  ' . $row['date_of_birth'] . '</label>';
    echo '<label style="font-weight:bold; font-size:16px; margin-bottom:40px; margin-top:10px;">Phone Number:  ' . $row['phone_number'] . '</label>';
    echo '<label style="font-weight:bold; font-size:16px; margin-bottom:40px; margin-top:10px;">Permanent Address:  ' . $row['address'] . '</label>';
} else {
    echo 'No data available';
}

$conn->close();
?>

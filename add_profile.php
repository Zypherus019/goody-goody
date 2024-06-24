<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventory_support_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $check_query = "SELECT * FROM profile WHERE id = '$id'";
    $check_result = $conn->query($check_query);

    if ($check_result === false) {
        die("Error checking record: " . $conn->error);
    }

    if ($check_result->num_rows > 0) {
        $update_query = "UPDATE profile SET name='$name', date_of_birth='$dob', phone_number='$phone', address='$address' WHERE id='$id'";
        if ($conn->query($update_query) === TRUE) {
            echo '<script>alert("Profile updated successfully");</script>';
        } else {
            echo "Error updating profile: " . $conn->error;
        }
    } else {
        $insert_query = "INSERT INTO profile (id, name, date_of_birth, phone_number, address) VALUES ('$id', '$name', '$dob', '$phone', '$address')";
        if ($conn->query($insert_query) === TRUE) {
            echo '<script>alert("Profile added successfully");</script>';
        } else {
            echo "Error inserting profile: " . $conn->error;
        }
    }

    $conn->close();
    echo '<script>window.location.href = "profile.php";</script>';
}
?>

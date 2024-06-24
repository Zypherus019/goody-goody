<?php
if (isset($_POST["submit"])) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["new_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($_FILES["new_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
            $db_host = "localhost";
            $db_username = "root";
            $db_password = "";
            $db_name = "inventory_support_system";

            $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $query = "SELECT * FROM images";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $sql = "UPDATE images SET file_path = '$target_file'";
            } else {
                $sql = "INSERT INTO images (file_path) VALUES ('$target_file')";
            }
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Profile picture updated successfully."); window.location.href = "profile.php";</script>';
            } else {
                echo "Error updating profile picture: " . mysqli_error($conn);
            }
            mysqli_close($conn);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

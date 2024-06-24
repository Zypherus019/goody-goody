<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Forbidden access. Please log in to access this page.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div id="profile_modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close" class="close" aria-label="Close modal">&times;</button>
            </div>
            <form action="add_profile.php" method="POST">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Date of Birth</label>
                        <input type="date" class="form-control" name="dob" placeholder="Date">
                    </div>

                    <div class="form-group mb-3">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="phone" placeholder="Number">
                    </div>

                    <div class="form-group mb-3">
                        <label>Permanent Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close2" class="close" aria-label="Close modal">Close</button>
                    <button type="submit" class="btn btn-primary" value="Add Profile">Ok</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    include('update_profile.php');
    ?>
    <div class="container">
        <?php
        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "inventory_support_system";

        $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
        $result = mysqli_query($conn, "SELECT * FROM images");
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $file_path = $row['file_path'];
                echo '<img src="' . $file_path . '" alt="Profile Picture" width="150">';
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_free_result($result);

        ?>

        <form action="update_profile.php" method="post" enctype="multipart/form-data">
            <input type="file" name="new_image" id="new_image">
            <input type="submit" value="Update" name="submit">
        </form>
    </div>

    <div class="container-2">
        <button id="open" class="openbtn"><i class='bx bx-edit'></i>Edit</button>
        <h3>Personal Information</h3>
        <?php include 'display_data.php'; ?>
    </div>
    <button><a href="Home.php">
            << </a></button>
    <script src="profilemodal.js"></script>
</body>

</html>
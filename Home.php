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
    <title>Dash Board</title>
    <link rel="stylesheet" href="css/Home.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php
    error_reporting(1);
    include('nav.php');
    include('update_profile.php');

    function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }

    if (isset($_GET['logout'])) {
        logout();
    }
    ?>
    <div id="searchModal" class="modal3">
        <div class="modal-content3">
            <span class="close1">&times;</span>
            <h3>Search Results</h3>
            <div id="modal-body">
                <!-- Search results will be appended here -->
            </div>
        </div>
    </div>
    <div class="header-wrapper">
        <div class="header-title">
            <h4>Welcome Back, <?php echo $_SESSION['username']; ?></h4>
            <span>Here are your daily updates.</span>
        </div>
        <div class="user-info">

            <div class="search-container">
                <input type="text" id="search-query" class="form-control" placeholder="Search...">
            </div>

            <div class="notif">
                <i class='bx bx-bell'></i>
            </div>
            <div class="icon-line"></div>
            <div class="profile-image">
                <?php
                $db_host = "localhost";
                $db_username = "root";
                $db_password = "";
                $db_name = "inventory_support_system";
                $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
                $result = mysqli_query($conn, "SELECT * FROM images");
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $file_path = $row['file_path'];
                    echo '<img src="' . $file_path . '" alt="Profile Picture" width="50">';
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                mysqli_free_result($result);
                ?>
            </div>
            <a href="profile.php" style="text-decoration: none; color: white;"><span style="text-decoration: none;">Admin</span></a>
        </div>
    </div>
    <div class="sidebar">
        <div class="logo"><img src="images/logo.png" alt="Logo"></div>
        <h3>GENERAL</h3>
        <ul class="list">
            <li>
                <button class="sidebar-btn"><a href="?nav=dashboard"><i class='bx bxs-dashboard'></i> Dash Board</a></button>
            </li>
            <li>
                <button class="sidebar-btn"><a href="?nav=inventory"><i class='bx bx-package'></i> Inventory</a></button>
            </li>
            <li>
                <button class="sidebar-btn"><a href="?nav=supplier"><i class='bx bxs-truck'></i> Suppliers</a></button>
            </li>
        </ul>
        <br>
        <br>
        <br>
        <h3>SUPPORT</h3>
        <ul class="list">
            <li>
                <button class="sidebar-btn"><a href="?logout=true"><i class='bx bx-log-out'></i> Log Out</a></button>
            </li>
        </ul>
    </div>

    <div class="content">
        <?php
        nav();
        ?>
    </div>
    <script src="display.js"></script>
    <script src="suppliers.js"></script>
    <script src="search.js"></script>

</body>

</html>
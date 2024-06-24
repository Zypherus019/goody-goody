<?php
require_once("connect.php"); // Use require_once to ensure the connection file is included once

session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: Home.php');
    exit;
}

// Initialize error variable
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Validate and sanitize user inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // No need to escape password for hashing

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        $error = "Please provide both username and password.";
    } else {
        // Fetch user data from the database
        $sql = "SELECT id, hashed_password, salt FROM login WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            $hashed_password_from_db = $row['hashed_password'];
            $salt = $row['salt'];

            // Verify the password with the hashed password from the database
            if (password_verify($password . $salt, $hashed_password_from_db)) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $username;
                header('Location: Home.php');
                exit;
            } else {
                $error = "Incorrect username or password.";
            }
        } else {
            $error = "User not found.";
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($conn);
?>
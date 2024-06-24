<?php
function nav() {
    // Check if 'nav' is set in the URL parameters
    $nav = isset($_GET['nav']) ? $_GET['nav'] : 'dashboard';

    switch ($nav) {
        case 'dashboard':
            include('barchart.php');
            break;
        case 'inventory':
            include('display.php');
            break;
        case 'supplier':
            include('suppliers.php');
            break;
        default:
            include('Home.php');
            break;
    }
}
?>

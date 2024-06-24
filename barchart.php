<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_support_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
SELECT name, quantity FROM beverages_categories WHERE quantity < 10
UNION ALL
SELECT name, quantity FROM can_goods_categories WHERE quantity < 10
UNION ALL
SELECT name, quantity FROM cigarettes_categories WHERE quantity < 10
UNION ALL
SELECT name, quantity FROM household_supplies_categories WHERE quantity < 10
UNION ALL
SELECT name, quantity FROM snacks_categories WHERE quantity < 10
UNION ALL
SELECT name, quantity FROM school_supplies_categories WHERE quantity < 10;
";

$result = $conn->query($sql);

$items = [];
$quantities = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row["name"];
        $quantities[] = $row["quantity"];
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Quantity Items</title>
    <link rel="stylesheet" href="css/barchart.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2 class="h2">Chart</h2>
<div id="myChartContainer">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($items); ?>,
            datasets: [{
                label: 'Quantity',
                data: <?php echo json_encode($quantities); ?>,
                backgroundColor: '#35315db7',
                borderColor: '#35315db7',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    labels: {
                        color: '#483eba', 
                        font: {
                            size: 14 
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#4138ae', 
                        font: {
                            size: 14 
                        }
                    }
                },
                y: {
                    ticks: {
                        color: 'rgb(75, 192, 192, 1)', 
                        font: {
                            size: 14 
                        }
                    }
                }
            }
        }
    });
});

    </script>
</body>
</html>

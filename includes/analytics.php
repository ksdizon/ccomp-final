<?php
session_start();
include '../includes/connectDb.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || !$_SESSION['is_admin']) {
    header('Location: ../routes/login.php');
    exit();
}

$database_handler = connect_db();

// Fetch connection data
$sql = "
    SELECT device, os
    FROM CONNECTIONS
";
$stmt = $database_handler->prepare($sql);
$stmt->execute();
$connections = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$stmt = null;
$database_handler = null;

// Prepare data for the charts
$device_counts = [];
$os_counts = [];

foreach ($connections as $connection) {
    $device = $connection['device'];
    $os = $connection['os'];
    
    if (!isset($device_counts[$device])) {
        $device_counts[$device] = 0;
    }
    $device_counts[$device]++;
    
    if (!isset($os_counts[$os])) {
        $os_counts[$os] = 0;
    }
    $os_counts[$os]++;
}

$device_labels = array_keys($device_counts);
$device_data = array_values($device_counts);
$os_labels = array_keys($os_counts);
$os_data = array_values($os_counts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .chart-container {
            background: rgba(26, 26, 26, 0.95);
            border-radius: 8px;
            padding: 1rem;
            height: 300px;
        }
        .back-button {
            position: fixed;
            top: 1rem;
            left: 1rem;
            padding: 0.5rem 1.5rem;
            background: rgba(52, 152, 219, 0.8);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .back-button:hover {
            background: rgba(52, 152, 219, 1);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <button class="back-button" onclick="window.location.href='../routes/dashboard.php'">Back to Dashboard</button>
    <button class="logout-button" onclick="window.location.href='../includes/logout.php'">Logout</button>
    
    <div class="charts-grid">
        <div class="chart-container">
            <canvas id="deviceChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="osChart"></canvas>
        </div>
    </div>

    <script>
        // Device Chart
        const deviceCtx = document.getElementById('deviceChart').getContext('2d');
        const deviceChart = new Chart(deviceCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($device_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($device_data); ?>,
                    backgroundColor: [
                        'rgba(39, 174, 96, 0.6)',
                        'rgba(46, 204, 113, 0.6)',
                        'rgba(231, 76, 60, 0.6)',
                        'rgba(241, 196, 15, 0.6)',
                        'rgba(52, 152, 219, 0.6)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Device Distribution',
                        color: '#e1e1e1',
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#e1e1e1'
                        }
                    }
                }
            }
        });

        // OS Chart
        const osCtx = document.getElementById('osChart').getContext('2d');
        const osChart = new Chart(osCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($os_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($os_data); ?>,
                    backgroundColor: [
                        'rgba(39, 174, 96, 0.6)',
                        'rgba(46, 204, 113, 0.6)',
                        'rgba(231, 76, 60, 0.6)',
                        'rgba(241, 196, 15, 0.6)',
                        'rgba(52, 152, 219, 0.6)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Operating System Distribution',
                        color: '#e1e1e1',
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#e1e1e1'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
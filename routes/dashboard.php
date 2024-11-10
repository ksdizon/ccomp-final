<?php
session_start();
include '../includes/connectDb.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || !$_SESSION['is_admin']) {
    header('Location: ../routes/login.php');
    exit();
}

$database_handler = connect_db();

// Fetch connection data along with user information
$sql = "
    SELECT 
        c.user_id,
        c.connection_date,
        c.connection_time,
        c.ip_address,
        c.isp,
        c.device,
        c.os,
        c.using_vpn,
        c.browser,
        c.continent,
        c.region_name,
        c.city,
        c.country,
        u.username,
        u.first_name,
        u.last_name
    FROM CONNECTIONS AS c
    JOIN USERS AS u ON c.user_id = u.user_id
";
$stmt = $database_handler->prepare($sql);
$stmt->execute();
$connections = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$stmt = null;
$database_handler = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .analytics-button {
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
        .analytics-button:hover {
            background: rgba(52, 152, 219, 1);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <button class="analytics-button" onclick="window.location.href='../includes/analytics.php'">View Analytics</button>
    <button class="logout-button" onclick="window.location.href='../includes/logout.php'">Logout</button>
    
    <div class="table-container">
        <h1>Connection Dashboard</h1>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Connection Date</th>
                    <th>Connection Time</th>
                    <th>IP Address</th>
                    <th>ISP</th>
                    <th>Device</th>
                    <th>OS</th>
                    <th>Using VPN</th>
                    <th>Browser</th>
                    <th>Continent</th>
                    <th>Region</th>
                    <th>City</th>
                    <th>Country</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($connections) > 0): ?>
                    <?php foreach ($connections as $connection): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($connection['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($connection['username']); ?></td>
                            <td><?php echo htmlspecialchars($connection['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($connection['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($connection['connection_date']); ?></td>
                            <td><?php echo htmlspecialchars($connection['connection_time']); ?></td>
                            <td><?php echo htmlspecialchars($connection['ip_address']); ?></td>
                            <td><?php echo htmlspecialchars($connection['isp']); ?></td>
                            <td><?php echo htmlspecialchars($connection['device']); ?></td>
                            <td><?php echo htmlspecialchars($connection['os']); ?></td>
                            <td>
                                <span class="status-vpn <?php echo $connection['using_vpn'] ? 'active' : 'inactive'; ?>">
                                    <?php echo $connection['using_vpn'] ? 'Yes' : 'No'; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($connection['browser']); ?></td>
                            <td><?php echo htmlspecialchars($connection['continent']); ?></td>
                            <td><?php echo htmlspecialchars($connection['region_name']); ?></td>
                            <td><?php echo htmlspecialchars($connection['city']); ?></td>
                            <td><?php echo htmlspecialchars($connection['country']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="16">No connection records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
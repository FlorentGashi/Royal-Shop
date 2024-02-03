<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <title>Admin Dashboard | Logs</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php
include '../db/database-connection.php';

function getAdminName($conn, $userId)
{
    $query = "SELECT username FROM Users WHERE user_id = $userId AND role = 'admin'";
    $result = $conn->query($query);

    if ($result === false) {
        echo "Error: " . $conn->error; 
        return '';
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['username'];
    } else {
        return '';
    }
}

$userId = 1;
$adminName = getAdminName($conn, $userId);

$logsQuery = "SELECT * FROM Logs ORDER BY log_id DESC";
$logsResult = mysqli_query($conn, $logsQuery);

include('../components/admin-header.php');
?>

<!-- Admin Dashboard Sidebar and Content -->
<div class="admin-container">
    <aside class="sidebar">
        <ul class="sidebar__links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="logs.php" class="active">Logs</a></li>
            <li><a href="users.php">Users</a></li>
        </ul>
    </aside>

    <main class="admin-content">
        <div class="admin-header">
            <h1>Here are the Logs <?php echo $adminName; ?></h1>
        </div>

        <div class="table-container">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Target Table</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($logsResult) {
                        while ($log = mysqli_fetch_assoc($logsResult)) {
                            echo "<tr>";
                            $timestamp = isset($log['timestamp']) ? $log['timestamp'] : 'N/A';
                            echo "<td>{$timestamp}</td>";
                            echo "<td>{$log['action']}</td>";
                            echo "<td>{$log['target_table']}</td>";
                            echo "<td>{$log['details']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Error fetching logs: " . mysqli_error($conn);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>

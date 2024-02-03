<?php
session_start();
include('../db/database-connection.php');

$usersQuery = "SELECT * FROM Users";
$usersResult = mysqli_query($conn, $usersQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Users Dashboard</title>
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Navbar Desktop -->
<?php
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
            <li><a href="logs.php">Logs</a></li>
            <li><a href="users.php" class="active">Users</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <div class="admin-header">
            <h1>User Management</h1>
        </div>

        <div class="table-container">
            <table class="responsive-table" id="userTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registration Date</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if ($usersResult) {
                        while ($user = mysqli_fetch_assoc($usersResult)) {
                            echo "<tr>";
                            echo "<td>{$user['user_id']}</td>";
                            echo "<td>{$user['username']}</td>";
                            echo "<td>{$user['email']}</td>";
                            echo "<td>{$user['role']}</td>";
                            echo "<td>{$user['registration_date']}</td>";
                            echo "<td>{$user['address']}</td>";
                            echo "<td>{$user['phone_number']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Error fetching users: " . mysqli_error($conn);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>

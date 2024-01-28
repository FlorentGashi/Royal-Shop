<?php
session_start();
include("../db/database-connection.php");

$user_id = $_SESSION["user_id"];

function getUserDetails($user_id, $conn) {
    $query = "SELECT * FROM Users WHERE user_id = '$user_id'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}



$userDetails = getUserDetails($user_id, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <title>Order History</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php
include('../components/admin-header.php');
?>

<div class="admin-container">

    <aside class="sidebar">
        <ul class="sidebar__links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="account.php">Account Information</a></li>
            <li><a href="order-history.php" class="active">Order History</a></li>
            <li><a href="wishlist.php">Wishlist</a></li>
        </ul>
    </aside>

    <main class="admin-content">
        <div class="admin-header">
            <h1><?= $userDetails['username'] ?>, this is you're Order History</h1>
        </div>

        <div class="table-container">
            <table class="responsive-table">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Date & Time</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $orderQuery = "SELECT Products.title, Products.category, Orders.quantity, Orders.total_price, Orders.status, Orders.order_date
                                FROM Orders
                                INNER JOIN Products ON Orders.product_id = Products.product_id
                                WHERE Orders.user_id = '$user_id'";
                    $orderResult = $conn->query($orderQuery);

                    if ($orderResult && $orderResult->num_rows > 0) {
                        while ($order = $orderResult->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $order['title'] . '</td>';
                            echo '<td>' . $order['category'] . '</td>';
                            echo '<td>' . $order['quantity'] . '</td>';
                            echo '<td>' . $order['total_price'] . '</td>';
                            echo '<td>' . $order['status'] . '</td>';
                            echo '<td>' . $order['order_date'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No orders found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>

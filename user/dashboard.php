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

// Function to get the total number of orders 
function getTotalOrders($user_id, $conn) {
    $query = "SELECT COUNT(*) as totalOrders FROM Orders WHERE user_id = '$user_id'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data['totalOrders'];
    }

    return 0;
}

// Function to get the total number of products that are in the wishlist
function getWishlistCount($user_id, $conn) {
    $query = "SELECT COUNT(*) as wishlistCount FROM wishlist WHERE user_id = '$user_id'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data['wishlistCount'];
    }

    return 0;
}


// Function to get the total number of pending orders 
function getPendingOrdersCount($user_id, $conn) {
    $query = "SELECT COUNT(*) as pendingOrders FROM Orders WHERE user_id = '$user_id' AND status = 'pending'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data['pendingOrders'];
    }

    return 0;
}

// Function to get the total number of approved orders
function getApprovedOrdersCount($user_id, $conn) {
    $query = "SELECT COUNT(*) as approvedOrders FROM Orders WHERE user_id = '$user_id' AND status = 'approved'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data['approvedOrders'];
    }

    return 0;
}

$userDetails = getUserDetails($user_id, $conn);
$totalOrders = getTotalOrders($user_id, $conn);
$wishlistCount = getWishlistCount($user_id, $conn);
$pendingOrdersCount = getPendingOrdersCount($user_id, $conn);
$approvedOrdersCount = getApprovedOrdersCount($user_id, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <title>User Dashboard</title>
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
            <li><a href="dashboard.php" class="active">Dashboard</a></li>
            <li><a href="account.php">Account Information</a></li>
            <li><a href="order-history.php">Order History</a></li>
            <li><a href="wishlist.php">Wishlist</a></li>
        </ul>
    </aside>

    <main class="admin-content">
        <div class="admin-header">
            <h1>Welcome <?= $userDetails['username'] ?>, to Your Dashboard</h1>
        </div>

        <div class="admin-cards">
            <div class="card">
                <h2>Orders</h2>
                <p>Total Orders: <span class="count"><?= $totalOrders ?></span></p>
            </div>
            <div class="card">
                <h2>Wishlist</h2>
                <p>Products on Wishlist: <span class="count"><?= $wishlistCount ?></span></p>
            </div>
            <div class="card">
                <h2>Pending Orders</h2>
                <p>Total: <span class="count"><?= $pendingOrdersCount ?></span></p>
            </div>
            <div class="card">
                <h2>Approved Orders</h2>
                <p>Total Messages: <span class="count"><?= $approvedOrdersCount ?></span></p>
            </div>
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
                </tr>
                </thead>
                <tbody>
                    <?php
                    $orderQuery = "SELECT Products.title, Products.category, Orders.quantity, Orders.total_price, Orders.status
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

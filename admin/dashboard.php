<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <title>Admin Dashboard</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap"
        rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<!-- Navbar Desktop -->
<?php
session_start();
include('../db/database-connection.php');
function getProducts($conn) {
  $query = "SELECT * FROM Products";
  $result = mysqli_query($conn, $query);
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
  return $products;
}

function getProductSales($productId, $conn) {
  $query = "SELECT SUM(quantity) AS totalSales FROM Orders WHERE product_id = $productId";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  return $row ? $row['totalSales'] : 0;
}
function getCount($conn, $table)
{
    $query = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($query);

    if ($result === false) {
        echo "Error: " . $conn->error; 
        return 0;
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}

$totalUsers = getCount($conn, "Users");
$totalProducts = getCount($conn, "Products");
$totalMessages = getCount($conn, "ContactFormSubmissions");
$totalOrders = getCount($conn, "Orders");

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

$products = getProducts($conn);
?>

<?php
include('../components/admin-header.php');
?>

<!-- Admin Dashboard Sidebar and Content -->
<div class="admin-container">

    <aside class="sidebar">
        <ul class="sidebar__links">
            <li><a href="dashboard.php" class="active">Dashboard</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="messages.php">Messages</a></li>
        </ul>
    </aside>

    <main class="admin-content">
        <div class="admin-header">
            <h1>Welcome <?php echo $adminName; ?>, to Your Admin Dashboard</h1>
        </div>

        <div class="admin-cards">
            <div class="card">
                <h2>Users</h2>
                <p>Total Users: <span class="count"><?= $totalUsers ?></span></p>
            </div>
            <div class="card">
                <h2>Products</h2>
                <p>Total Products: <span class="count"><?= $totalProducts ?></span></p>
            </div>
            <div class="card">
                <h2>Orders</h2>
                <p>Total Orders: <span class="count"><?= $totalOrders ?></span></p>
            </div>
            <div class="card">
                <h2>Messages</h2>
                <p>Total Messages: <span class="count"><?= $totalMessages ?></span></p>
            </div>
        </div>

        <div class="table-container">
            <table class="responsive-table">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Sales</th>
                    <th>Stock</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['title'] ?></td>
                        <td><?= $product['category'] ?></td>
                        <td><?= getProductSales($product['product_id'], $conn) ?></td>
                        <td><?= $product['stock'] ?></td>
                        <td>$<?= $product['price'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>

<?php
session_start();

include('../db/database-connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerId = $_POST['customerId'];
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $totalPrice = $_POST['totalPrice'];
    $status = 'Pending'; 

    $insertQuery = "INSERT INTO Orders (user_id, product_id, quantity, total_price, order_date, status) 
                    VALUES (?, ?, ?, ?, NOW(), ?)";

    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iidss", $customerId, $productId, $quantity, $totalPrice, $status);

    if ($insertStmt->execute()) {
        echo "Order added successfully.";
        header("Location: orders.php");
        exit();
    } else {
        echo "Error adding order: " . $insertStmt->error;
    }

    $insertStmt->close();
}

$customersQuery = "SELECT user_id, username FROM Users";
$customersResult = mysqli_query($conn, $customersQuery);

$productsQuery = "SELECT product_id, title FROM Products";
$productsResult = mysqli_query($conn, $productsQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Orders Dashboard</title>
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet"/>
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
            <li><a href="orders.php" class="active">Orders</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="logs.php">Logs</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">

        <!-- Create Order Form Here -->
        <form id="orderCreationForm" method="post">
            <label for="customerId">Customer:</label>
            <select id="customerId" name="customerId" class="sel-form" required>
                <?php
                while ($customer = mysqli_fetch_assoc($customersResult)) {
                    echo "<option value='{$customer['user_id']}'>{$customer['username']}</option>";
                }
                ?>
            </select>

            <label for="productId">Product:</label>
            <select id="productId" name="productId" class="sel-form" required>
                <?php
                while ($product = mysqli_fetch_assoc($productsResult)) {
                    echo "<option value='{$product['product_id']}'>{$product['title']}</option>";
                }
                ?>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required/>

            <label for="totalPrice">Total Price:</label>
            <input type="text" id="totalPrice" name="totalPrice" required/>

            <button type="submit" class="add-product-btn">Place Order</button>
        </form>
    </main>
</body>
</html>

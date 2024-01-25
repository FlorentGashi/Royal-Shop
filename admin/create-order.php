<?php
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet"/>
</head>
<body>

<!-- Navbar Desktop -->
<header>
    <a class="logo" href="index.php"><img src="https://royal.intrioxa.com/assets/favicon.png" alt="logo"/>
    </a>
    <nav>
        <ul class="nav__links">
            <li><a href="shop.html">Shop</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>
    <a class="cta" href="login.html">Login</a>
    <p class="menu cta">Menu</p>
</header>

<!-- Navbar in Mobile -->
<div id="mobile__menu" class="overlay">
    <a class="close">&times;</a>
    <div class="overlay__content">
        <a href="shop.html">Shop</a>
        <a href="about.html">About</a>
        <a href="contact.html">Contact</a>
        <a class="cta-mobile" href="login.html">Login</a>
        <a class="cta-mobile" href="cart.html">Cart</a>
    </div>
</div>

<!-- Admin Dashboard Sidebar and Content -->
<div class="admin-container">

    <aside class="sidebar">
        <ul class="sidebar__links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="orders.php" class="active">Orders</a></li>
            <li><a href="messages.php">Messages</a></li>
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

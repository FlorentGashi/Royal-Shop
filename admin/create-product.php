<?php
include('../db/database-connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $productCategory = $_POST['productCategory'];
    $productStock = $_POST['productStock'];
    $productPrice = $_POST['productPrice'];
    $productDescription = $_POST['productDescription'];

    // Image upload directory is this path 
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($_FILES["productImage"]["name"]);
    move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile);

    $insertQuery = "INSERT INTO Products (title, category, stock, price, description, image_url) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ssdsss", $productName, $productCategory, $productStock, $productPrice, $productDescription, $targetFile);

    if ($insertStmt->execute()) {
        echo "Product added successfully.";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error adding product: " . $insertStmt->error;
    }

    $insertStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Products Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <li><a href="products.php" class="active">Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="messages.php">Messages</a></li>
        </ul>
    </aside>

    <main class="admin-content">
        <form id="productCreationForm" enctype="multipart/form-data" method="post">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" required/>

            <label for="productCategory">Category:</label>
            <input type="text" id="productCategory" name="productCategory" required/>

            <label for="productStock">Stock:</label>
            <input type="number" id="productStock" name="productStock" required/>

            <label for="productPrice">Price:</label>
            <input type="text" id="productPrice" name="productPrice" required/>

            <label for="productDescription">Description:</label>
            <textarea id="productDescription" name="productDescription" required></textarea>

            <label for="productImage">Image:</label>
            <input type="file" id="productImage" name="productImage" accept="image/*" required/>

            <button type="submit" class="add-product-btn">Create Product</button>
        </form>
    </main>
</body>
</html>

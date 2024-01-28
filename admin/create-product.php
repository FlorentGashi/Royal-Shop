<?php
session_start();

include('../db/database-connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $productCategory = $_POST['productCategory'];
    $productStock = $_POST['productStock'];
    $productPrice = $_POST['productPrice'];
    $productDescription = $_POST['productDescription'];

    $rootDir = dirname(__DIR__);
    $uploadsDir = $rootDir . "/uploads/";
    // Initialize variables for image URLs
    $image_urls = [];

    // Loop through each image input
    for ($i = 1; $i <= 4; $i++) {
        $targetFile = $uploadsDir . basename($_FILES["productImage$i"]["name"]);

        // Check for file upload errors
        if ($_FILES["productImage$i"]["error"] > 0) {
            echo "File $i upload error: " . $_FILES["productImage$i"]["error"];
            exit();
        }

        // Move uploaded file to the uploads directory
        if (move_uploaded_file($_FILES["productImage$i"]["tmp_name"], $targetFile)) {
            echo "File $i successfully moved to the uploads directory.";
        } else {
            echo "File $i not moved to the uploads directory.";
            exit();
        }

        // Check if file exists in the uploads directory
        if (file_exists($targetFile)) {
            echo "File $i exists in the uploads directory.";
        } else {
            echo "File $i does not exist in the uploads directory.";
            exit();
        }

        // Assign the image URL to the array
        $image_urls[] = $targetFile;
    }

    $insertQuery = "INSERT INTO Products (title, category, stock, price, description, image_url, image_url_2, image_url_3, image_url_4) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ssdssssss", $productName, $productCategory, $productStock, $productPrice, $productDescription, ...$image_urls);

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
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php
include('../components/admin-header.php');
?>

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

            <label for="productImage1">Image 1:</label>
            <input type="file" id="productImage1" name="productImage1" accept="image/*" required/>

            <label for="productImage2">Image 2:</label>
            <input type="file" id="productImage2" name="productImage2" accept="image/*" required/>

            <label for="productImage3">Image 3:</label>
            <input type="file" id="productImage3" name="productImage3" accept="image/*" required/>

            <label for="productImage4">Image 4:</label>
            <input type="file" id="productImage4" name="productImage4" accept="image/*" required/>

            <button type="submit" class="add-product-btn">Create Product</button>
        </form>
    </main>
</body>
</html>

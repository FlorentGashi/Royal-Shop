<?php
session_start();
include('../db/database-connection.php');

// Function to get products from the database
function getProducts($conn) {
    $query = "SELECT * FROM Products";
    $result = $conn->query($query);

    if ($result === false) {
        die("Error: " . $conn->error);
    }

    $products = $result->fetch_all(MYSQLI_ASSOC);
    return $products;
}

// Function to get product sales for a given product ID
function getProductSales($productId, $conn) {
    $query = "SELECT SUM(quantity) AS totalSales FROM Orders WHERE product_id = $productId";
    $result = $conn->query($query);

    if ($result === false) {
        die("Error: " . $conn->error);
    }

    $row = $result->fetch_assoc();
    return $row ? $row['totalSales'] : 0;
}

// Function to update a product in the database
function updateProduct($conn, $productId, $productName, $productDescription, $productCategory, $productStock, $productPrice, $productDiscount) {

    $discountValue = !empty($productDiscount) ? $productDiscount : null;

    $updateQuery = "UPDATE Products SET title=?, description=?, category=?, stock=?, price=?, discounted_price=? WHERE product_id=?";
    $updateStmt = $conn->prepare($updateQuery);

    $updateStmt->bind_param("ssssdii", $productName, $productDescription, $productCategory, $productStock, $productPrice, $discountValue, $productId);

    if (!$updateStmt->execute()) {
        die("Error: " . $updateStmt->error);
    }

    $updateStmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];

        $deleteQuery = "DELETE FROM Products WHERE product_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $product_id);


        if (!$deleteStmt->execute()) {
            die("Error: " . $deleteStmt->error);
        }

        $deleteStmt->close();

        header("Location: products.php");
        exit();
    } elseif (isset($_POST['update_product'])) {
        $productId = $_POST['editProductId'];
        $productName = $_POST['editProductName'];
        $productDescription = $_POST['editProductDescription'];
        $productCategory = $_POST['editProductCategory'];
        $productStock = $_POST['editProductStock'];
        $productPrice = $_POST['editProductPrice'];
        $productDiscount = $_POST['editProductDiscount']; 

        updateProduct($conn, $productId, $productName, $productDescription, $productCategory, $productStock, $productPrice, $productDiscount);

        header("Location: products.php");
        exit();
    }
}

$products = getProducts($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Products Dashboard</title>
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
            <li><a href="products.php" class="active">Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="logs.php">Logs</a></li>
            <li><a href="users.php">Users</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <div class="admin-header">
            <h1>Product Management</h1>
            <a href="create-product.php" class="add-product-link">
                <button class="add-product-btn">Add Product</button>
            </a>
        </div>

        <div class="table-container">
            <table class="responsive-table" id="productTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Sales</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['product_id'] ?></td>
                        <td><?= $product['title'] ?></td>
                        <td><?= $product['category'] ?></td>
                        <td><?= getProductSales($product['product_id'], $conn) ?></td>
                        <td><?= $product['stock'] ?></td>
                        <td>$<?= $product['price'] ?></td>
                        <td><?= $product['discounted_price'] !== null ? $product['discounted_price'] : 'No Discount' ?></td>
                        <td>
                            <button class="crud-btn edit-btn" data-product-info="<?= htmlentities(json_encode($product), ENT_QUOTES, 'UTF-8') ?>">Edit</button>
                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display: contents">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <button type="submit" name="delete_product" class="crud-btn delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="editProductPopup" class="edit-product-popup">
        <label for="editProductId">Product ID:</label>
        <input type="text" id="editProductId" value="" disabled/>
        <label for="editProductName">Product Name:</label>
        <input type="text" id="editProductName" value="" />
        <label for="editProductDescription">Description:</label>
        <textarea id="editProductDescription" name="editProductDescription" required></textarea>
        <label for="editProductCategory">Category:</label>
        <input type="text" id="editProductCategory" value="" />
        <label for="editProductStock">Stock:</label>
        <input type="number" id="editProductStock" value="" />
        <label for="editProductPrice">Price:</label>
        <label for="editProductDiscount">Discount:</label>
        <input type="text" id="editProductDiscount" value="" />
        <input type="text" id="editProductPrice" value="" />
        <button id="saveEditBtn">Save</button>
    </div>
</div>
<script>
    document.getElementById("productTable").addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-btn")) {
            if (confirm('Are you sure you want to delete this product?')) {
                var productId = event.target.parentElement.querySelector("[name='product_id']").value;

                var form = document.createElement("form");
                form.method = "post";
                form.action = "products.php";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "delete_product";
                input.value = 1;

                var inputProductId = document.createElement("input");
                inputProductId.type = "hidden";
                inputProductId.name = "product_id";
                inputProductId.value = productId;

                form.appendChild(input);
                form.appendChild(inputProductId);

                document.body.appendChild(form);
                form.submit();
            }
        } else if (event.target.classList.contains("edit-btn")) {
            var productInfo = JSON.parse(event.target.dataset.productInfo);
            openEditPopup(productInfo);
        }
    });

    function openEditPopup(productData) {
        document.getElementById("editProductId").value = productData.product_id;
        document.getElementById("editProductName").value = productData.title || "";
        document.getElementById("editProductDescription").value = productData.description || "";
        // document.getElementById("editProductCategory").value = productData.category || "";
        document.getElementById("editProductCategory").value = productData.category !== undefined && productData.category !== null ? productData.category : "";
        document.getElementById("editProductStock").value = productData.stock || "";
        document.getElementById("editProductPrice").value = productData.price || "";
        document.getElementById("editProductDiscount").value = productData.discounted_price || "";

        document.getElementById("editProductPopup").style.display = "block";
    }

    function closeEditPopup() {
        document.getElementById("editProductPopup").style.display = "none";
    }

    document.getElementById("saveEditBtn").addEventListener("click", function () {
        var updatedData = {
            productId: document.getElementById("editProductId").value,
            name: document.getElementById("editProductName").value,
            description: document.getElementById("editProductDescription").value,
            category: document.getElementById("editProductCategory").value,
            stock: document.getElementById("editProductStock").value,
            price: document.getElementById("editProductPrice").value,
            discount: document.getElementById("editProductDiscount").value
        };


        var form = document.createElement("form");
        form.method = "post";
        form.action = "products.php"; 

        var inputUpdateProduct = document.createElement("input");
        inputUpdateProduct.type = "hidden";
        inputUpdateProduct.name = "update_product";
        inputUpdateProduct.value = 1;

        var inputEditProductId = document.createElement("input");
        inputEditProductId.type = "hidden";
        inputEditProductId.name = "editProductId";
        inputEditProductId.value = updatedData.productId;

        var inputEditProductName = document.createElement("input");
        inputEditProductName.type = "hidden";
        inputEditProductName.name = "editProductName";
        inputEditProductName.value = updatedData.name;

        var inputEditProductDescription = document.createElement("input");
        inputEditProductDescription.type = "hidden";
        inputEditProductDescription.name = "editProductDescription";
        inputEditProductDescription.value = updatedData.description;

        var inputEditProductCategory = document.createElement("input");
        inputEditProductCategory.type = "hidden";
        inputEditProductCategory.name = "editProductCategory";
        inputEditProductCategory.value = updatedData.category;

        var inputEditProductStock = document.createElement("input");
        inputEditProductStock.type = "hidden";
        inputEditProductStock.name = "editProductStock";
        inputEditProductStock.value = updatedData.stock;

        var inputEditProductPrice = document.createElement("input");
        inputEditProductPrice.type = "hidden";
        inputEditProductPrice.name = "editProductPrice";
        inputEditProductPrice.value = updatedData.price;

        var inputEditProductDiscount = document.createElement("input");
        inputEditProductDiscount.type = "hidden";
        inputEditProductDiscount.name = "editProductDiscount";
        inputEditProductDiscount.value = updatedData.discount;


        form.appendChild(inputUpdateProduct);
        form.appendChild(inputEditProductId);
        form.appendChild(inputEditProductName);
        form.appendChild(inputEditProductDescription);
        form.appendChild(inputEditProductCategory);
        form.appendChild(inputEditProductStock);
        form.appendChild(inputEditProductPrice);
        form.appendChild(inputEditProductDiscount);

        document.body.appendChild(form);
        form.submit();
    });
</script>
</body>
</html>
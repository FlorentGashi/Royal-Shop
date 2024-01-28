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

function getWishlist($user_id, $conn) {
    $query = "SELECT Products.product_id, Products.title, Products.category, Products.price, Products.discounted_price
              FROM wishlist
              INNER JOIN Products ON wishlist.product_id = Products.product_id
              WHERE wishlist.user_id = '$user_id'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}

$userDetails = getUserDetails($user_id, $conn);
$wishlist = getWishlist($user_id, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <title>Wishlist</title>
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
            <h1><?= $userDetails['username'] ?>, view you're Wishlist</h1>
        </div>

        <div class="table-container">
            <table class="responsive-table">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Discount Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($wishlist as $item): ?>
                        <tr>
                            <td><?= $item['title'] ?></td>
                            <td><?= $item['category'] ?></td>
                            <td><?= $item['price'] ?></td>
                            <td><?= !empty($item['discounted_price']) ? $item['discounted_price'] : 'No Discount' ?></td>
                            <td>
                                <form method="post" action="wishlist.php" style="display: contents;">
                                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                    <button type="submit" name="remove_from_wishlist" class="crud-btn delete-btn">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>

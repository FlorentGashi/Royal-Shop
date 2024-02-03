<?php
include('./db/database-connection.php');

function getProducts($conn) {
    $query = "SELECT * FROM Products";
    $result = mysqli_query($conn, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
}
try {
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$products = getProducts($conn);
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal | Shop</title>
    <meta name="description" content="Blerje online ne Royal Shop per produkte teknologjike. Gjej ofertat e fundit ne smartphone, laptop, pajisje elektronike, dhe shume tjera.">
    <meta name="keywords" content="blej online, produkte teknologjike, smartphone, laptop, elektronika, Royal Shop">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
        include './components/loader.php'
     ?>
     <!-- This is the Navbar Desktop -->
     <?php 
        include './components/header.php'
     ?>

     <!-- Product Section Start's Here -->
     <div class="products-section">
      <h2 class="section-title">Produktet Tona</h2>
        <div class="product-container">
            <?php foreach ($products as $product): ?>
                <div class="product">
                <?php $relativePath = "uploads/" . basename($product['image_url']); ?>
                <img src="<?php echo $relativePath; ?>" alt="<?php echo $product['title']; ?>">
                    <div class="product-content">
                        <h3 class="product-title"><?php echo $product['title']; ?></h3>
                        <p class="product-price"><?php echo $product['price'];?>€</p>
                        <?php if ($product['discounted_price']): ?>
                            <p class="product-discount">Nga: <?php echo $product['discounted_price']; ?>€</p>
                        <?php endif; ?>
                        <div class="product-actions">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="wishlist.php?product_id=<?php echo $product['product_id']; ?>" class="action-button">Wishlist</a>
                        <?php endif; ?>
                        <a href="product-details.php?product_id=<?php echo $product['product_id']; ?>" class="action-button">Shiko</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Product Section Ends Here -->

    <?php 
     include './components/footer.php'
    ?>
</body>
</html>
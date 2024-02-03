<?php
include('./db/database-connection.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = "SELECT * FROM Products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $pageTitle = $product['title'];
        $description = $product['description'];
        $price = $product['price'];
        $discountedPrice = $product['discounted_price'];
        $imageURL = $product['image_url'];
    } else {
        header("Location: /404.php");
        exit();
    }
} 
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Shop | <?= $pageTitle ?></title>
    <meta name="description" content="Mirësevini në Royal Shop, destinacioni tuaj i preferuar për blerje online të produkteve të teknologjisë. Gjeni pajisjet më të fundit dhe cilësore për të përmirësuar përvojën tuaj digjitale. Shfletoni koleksionin tonë dhe hapi dritën e inovacionit!">
    <meta name="keywords" content="Teknologji e fundit, Blerje online teknologjike, Paisje elektronike, Pajisje inteligjente, Shitje produkte teknologjike, Gadget inovative, Telefona inteligjentë, Laptopë cilësore, Aksesore teknologjike, Oferta teknologjike">
    <link rel="shortcut icon" href="./assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body style="background-color: #f4f4f4;">

    <?php 
        include './components/loader.php'
    ?>

    <?php 
    include './components/header.php'
    ?>

    <section class="product-preview-container">
        <div class="row">
            <div class="product-col">
                <h1 class="product-h1"><?= $pageTitle ?></h1>
                <p><?= $description ?></p>
                <p><b>Price:</b> <?= $price ?>€</p>
                <?php if ($discountedPrice): ?>
                    <p><b>Discounted Price:</b> <?= $discountedPrice ?>€</p>
                <?php endif; ?>

                <form method="post" action="cart.php">
                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                    <input type="hidden" name="title" value="<?= $pageTitle ?>">
                    <input type="hidden" name="price" value="<?= $price ?>">
                    <input type="hidden" name="image_url" value="<?= $imageURL ?>">
                    <button type="submit" class="accept-btn" name="add_to_cart">Shto në Shport</button>
                </form>
            </div>
            <div class="product-col">
                <div class="feature-img">
                    <?php
                    $encodedFilename = isset($product['image_url']) ? rawurlencode(basename($product['image_url'])) : '';
                    $encodedPath = "uploads/" . $encodedFilename;
                    ?>
                    <img src="<?= $encodedPath ?>" id="productImg" alt="<?= $pageTitle ?>">
                </div>
                <div class="small-img-row">
                    <?php
                    $smallImageUrls = [
                        $product['image_url'],
                        $product['image_url_2'],
                        $product['image_url_3'],
                        $product['image_url_4']
                    ];

                    foreach ($smallImageUrls as $index => $smallImageUrl) {
                        $encodedSmallFilename = isset($smallImageUrl) ? rawurlencode(basename($smallImageUrl)) : ''; 
                        $encodedSmallPath = "uploads/" . $encodedSmallFilename; 
                    ?>
                        <div class="small-img-col">
                            <img src="<?= $encodedSmallPath ?>" width="100%" class="small-img" onclick="changeImage('<?= $encodedSmallPath ?>')">
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section Starts Here -->
    <?php 
        include './components/footer.php'
    ?>
    <!-- This is JS code is to change Product Images-->
    <script>
        var productImg = document.getElementById("productImg");
        var smallImages = document.getElementsByClassName("small-img");
    
        function changeImage(imageSrc) {
          productImg.src = imageSrc;
        }
    </script>
</body>
</html>

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
     <!-- Here is The Loader so The Page Doesn't show up till the content is Loaded -->
     <div class="center-body" id="loading">
        <div class="loader-circle-86">
            <svg version="1.1" x="0" y="0" viewbox="-10 -10 120 120" enable-background="new 0 0 200 200" xml:space="preserve">
           <path class="circle" d="M0,50 A50,50,0 1 1 100,50 A50,50,0 1 1 0,50"/>
            </svg>
        </div>
    </div>

    <!-- This is the Navbar -->
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
                <br />
                <a href="cart.html" class="accept-btn">Shto në Shport</a>
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

                    // Loop through small image URLs and generate small image elements
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
    <footer class="footer">
        <ul class="footer-menu">
          <li class="menu__item"><a class="menu__link" href="./shop.html">Shop</a></li>
          <li class="menu__item"><a class="menu__link" href="./about.html">About</a></li>
          <li class="menu__item"><a class="menu__link" href="./contact.html">Contact</a></li>
    
        </ul>
        <p>Copyright &copy; <script>document.write(new Date().getFullYear())</script> Royal Shop | All Rights Reserved</p>
    </footer>
    <!-- This is JS code is to change Product Images-->
    <script>
        var productImg = document.getElementById("productImg");
        var smallImages = document.getElementsByClassName("small-img");
    
        function changeImage(imageSrc) {
          productImg.src = imageSrc;
        }
    </script>

    <script>
		window.addEventListener('load', function() {
			document.getElementById('loading').classList.add('hide');
		});
	</script>
    <script type="text/javascript" src="./js/mobile.js"></script>
</body>
</html>
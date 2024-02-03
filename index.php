<?php
include('./db/database-connection.php');

function getProducts($conn) {
    $query = "SELECT * FROM Products";
    $result = mysqli_query($conn, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
}

$products = getProducts($conn);
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal</title>
    <meta name="description" content="Mirësevini në Royal Shop, destinacioni tuaj i preferuar për blerje online të produkteve të teknologjisë. Gjeni pajisjet më të fundit dhe cilësore për të përmirësuar përvojën tuaj digjitale. Shfletoni koleksionin tonë dhe hapi dritën e inovacionit!">
    <meta name="keywords" content="Teknologji e fundit, Blerje online teknologjike, Paisje elektronike, Pajisje inteligjente, Shitje produkte teknologjike, Gadget inovative, Telefona inteligjentë, Laptopë cilësore, Aksesore teknologjike, Oferta teknologjike">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
        include './components/loader.php';
        include './components/header.php';
    ?>

    <!-- Slideshow Begins Here -->
    <div class="slideshow-container">
        <div class="slide">
            <img src="./assets/Slideshow 1.jpg" alt="Slide 1" class="slide-img">
            <div class="caption">
                <h1>Mirësevini në Royal Shop</h1>
                <p>Mirëprituni në botën tonë të teknologjisë, ku cilësia dhe përparimi janë vlerat që udhëhoqen.</p>
                <a href="shop.html" class="btn-shop">Blej Tani</a>
            </div>
        </div>

        <div class="slide">
            <img src="./assets/Slideshow 2.jpg" alt="Slide 2" class="slide-img">
            <div class="caption">
                <h1>Destinacioni Juaj për Teknologji!</h1>
                <p>Ne jemi këtu për të sjellë një përvojë blerje të jashtëzakonshme për klientët tanë, duke ofruar një koleksion të zgjedhur të produkteve të teknologjisë së fundit.</p>
                <a href="shop.html" class="btn-shop">Blej Tani</a>
            </div>
        </div>
    </div>
    <!-- Slideshow End's Here -->

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

    <!-- Services  -->
    <section class="center-container">
      <h2 class="section-title">Pse të zgjidhni Royal Shop?</h2>
        <div class="services">
            <div class="why-card">
                <span class="icon-title">🚚 Transport 24/7</span>
                <p class="description">Ne ofrojmë shërbim transporti 24/7. Blerjet tuaja do të dorëzohen shpejt dhe në kohë.</p>
            </div>

            <div class="why-card">
                <span class="icon-title">🛡️ Garanci për cilësi</span>
                <p class="description">Produktet tona janë të sigurta dhe me garanci për cilësi. Jemi të përkushtuar në ofrimin e produkteve të shkëlqyera.</p>
            </div>

            <div class="why-card">
                <span class="icon-title">💳 Pagesa të sigurta</span>
                <p class="description">Siguria e informacionit tuaj është për ne shumë e rëndësishme. Ofrojmë metoda të sigurta të pagesës për blerjet tuaja.</p>
            </div> 
       </div>
      <a href="shop.html"><button class="accept-btn">Zbulo të gjitha</button></a>
    </section>
    <!-- Services End -->

    <?php 
         include './components/cta.php';
         include './components/footer.php';
    ?>

    <script>
        let slideIndex = 0;
      
        function showSlides() {
          let slides = document.getElementsByClassName("slide");
          for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
          }
          slideIndex++;
          if (slideIndex > slides.length) {
            slideIndex = 1;
          }
          slides[slideIndex - 1].style.display = "block";
          setTimeout(showSlides, 5000); 
        }
      
        showSlides();
    </script>
</body>
</html>
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_to_cart"])) {
        $product_id = $_POST["product_id"];
        $title = $_POST["title"];
        $price = $_POST["price"];
        $image_url = $_POST["image_url"];

        if (!isset($_SESSION["cart"][$product_id])) {
            $_SESSION["cart"][$product_id] = array(
                "title" => $title,
                "price" => $price,
                "image_url" => $image_url,
                "quantity" => 1
            );
        } else {
            $_SESSION["cart"][$product_id]["quantity"]++;
        }
    }

    if (isset($_POST["update_cart"])) {
        foreach ($_POST["quantity"] as $product_id => $quantity) {
            $quantity = max(1, intval($quantity));
            if (isset($_SESSION["cart"][$product_id])) {
                $_SESSION["cart"][$product_id]["quantity"] = $quantity;
            }
        }
    } elseif (isset($_POST["remove_item"])) {
        $product_id = $_POST["remove_item"];
        unset($_SESSION["cart"][$product_id]);
    }

    if (isset($_POST["proceed_to_checkout"])) {
        header("Location: checkout.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zhvillimi në Vazhdim</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<?php 
    include './components/loader.php';
    include './components/header.php';
?>

<main>
    <section class="cart-container">
        <h1>Your Shopping Cart</h1>

        <form method="post" action="cart.php">
            <?php
            if (!empty($_SESSION["cart"])) {
                foreach ($_SESSION["cart"] as $product_id => $cartItem) {
                    ?>
                    <div class="cart-item">
                        <?php
                        $encodedFilename = isset($cartItem['image_url']) ? rawurlencode(basename($cartItem['image_url'])) : '';
                        $encodedPath = "uploads/" . $encodedFilename;
                        ?>
                        <img src="<?= $encodedPath ?>" alt="<?= $cartItem['title'] ?>" />
                        <div class="item-details">
                            <h3><?= $cartItem['title'] ?></h3>
                            <p>Price: $<?= $cartItem['price'] ?></p>
                        </div>
                        <div class="quantity">
                            <label for="quantity<?= $product_id ?>">Quantity:</label>
                            <input type="number" name="quantity[<?= $product_id ?>]" id="quantity<?= $product_id ?>" value="<?= $cartItem['quantity'] ?>" min="1" />
                            <button type="submit" name="remove_item" class="close-button" value="<?= $product_id ?>">×</button>
                        </div>
                    </div>
                    <?php 
                }
            } else {
                echo '<p>Your cart is empty. <a href="./shop.php" class="continue-shopping-link">Continue shopping</a></p>';
            }
            ?>

            <div class="order-summary">
                <h2>Order Summary</h2>
                <?php
                $subtotal = 0;
                foreach ($_SESSION["cart"] as $cartItem) {
                    $subtotal += $cartItem['price'] * $cartItem['quantity'];
                }
                ?>
                <p>Subtotal: $<?= number_format($subtotal, 2) ?></p>

                <div class="actions">
                    <button type="submit" name="update_cart" class="update-cart-button">Update Cart</button>
                    <button class="checkout-button" name="proceed_to_checkout" class="checkout-button">Proceed to Checkout</button>
                </div>
            </div>
        </form>
    </section>
</main>

<?php 
    include './components/footer.php';
?>
</html>

<?php
session_start();
include("./db/database-connection.php");

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserInfo($userId) {
    global $conn;

    $escapedUserId = mysqli_real_escape_string($conn, $userId);
    $query = "SELECT * FROM Users WHERE user_id = '$escapedUserId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }

    return false;
}

function insertOrder($userId, $productDetails) {
    global $conn;

    $escapedUserId = mysqli_real_escape_string($conn, $userId);

    foreach ($productDetails as $productId => $product) {
        $escapedProductId = mysqli_real_escape_string($conn, $productId);
        $quantity = $product['quantity'];
        $totalPrice = $product['price'] * $quantity;

        $query = "INSERT INTO Orders (user_id, product_id, quantity, total_price, status) VALUES ('$escapedUserId', '$escapedProductId', '$quantity', '$totalPrice', 'pending')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Error: " . mysqli_error($conn));
        }
    }
}

$userLoggedIn = isLoggedIn();
$userInfo = array();

if ($userLoggedIn) {
    $userId = $_SESSION['user_id'];

    if (!empty($userId)) {
        $userInfo = getUserInfo($userId);
    } else {

        header("Location: login.php");
        exit();
    }
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['place_order'])) {

        $cardNumber = $_POST["card-number"];
        $expiryDate = $_POST["expiry-date"];
        $cvv = $_POST["cvv"];

        insertOrder($userId, $cart);
    }

    $newOrderId = mysqli_insert_id($conn);
    var_dump($newOrderId);  
    if (!empty($newOrderId)) {
        header("Location: thankyou-order.php?order_id=$newOrderId");
        exit();
    } else {
        echo "Error: Unable to retrieve the order ID.";
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
    <section class="checkout-container">
        <h1 style="padding: 10px;">Checkout</h1>

        <form class="checkout-form" method="post" action="checkout.php">
            <?php if ($userLoggedIn): ?>
                <div class="user-profile" id="user-profile">
                    <h2>User Profile</h2>
                    <p id="user-name">Name: <?= $userInfo['username'] ?></p>
                    <p id="user-email">Email: <?= $userInfo['email'] ?></p>
                </div>
            <?php endif; ?>

            <?php if (!$userLoggedIn): ?>
                <div class="customer-info" id="customer-info">
                    <p>
                        <b>Note:</b> To make a purchase with us, you need to have an
                        account. If you're already a member, simply log in <a href="login.php">here</a>. <br> If you don't have an account yet, you can
                        create one by clicking <a href="signup.php">here</a>.
                    </p>
                </div>
            <?php endif; ?>

            <div class="payment-info">
                <h2>Payment Information</h2>
                <label for="card-number">Card Number:</label>
                <input type="text" id="card-number" name="card-number" placeholder="1234-1234-1234-1234" required />

                <label for="expiry-date">Expiry Date:</label>
                <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" required />

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" placeholder="123" required />
            </div>

            <button class="place-order-button" type="submit" name="place_order">Place Order</button>
        </form>

        <!-- Order Summary -->
        <div class="order-summary">
            <h2>Order Summary</h2>
            <?php foreach ($cart as $product_id => $product): ?>
                <p><?= $product['title'] ?> - Quantity: <?= $product['quantity'] ?> - Price: $<?= $product['price'] * $product['quantity'] ?></p>
            <?php endforeach; ?>
            <p>Total: $<?= calculateCartTotal($cart) ?></p>
        </div>
    </section>
</main>
<?php
include './components/footer.php';
?>

<?php
function calculateCartTotal($cart) {
    $total = 0;
    foreach ($cart as $product) {
        $total += $product['quantity'] * $product['price'];
    }
    return $total;
}
?>
</html>

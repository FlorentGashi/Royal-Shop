<?php
session_start();
include('./db/database-connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION['user_id'])) {
    $product_id = $_GET["product_id"];
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO wishlist (user_id, product_id) VALUES ('$user_id', '$product_id')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Error: " . mysqli_error($conn));
        }
    }
}

header("Location: shop.php");
exit();

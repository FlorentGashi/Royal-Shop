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

$userDetails = getUserDetails($user_id, $conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];

    $updateQuery = "UPDATE Users SET username = '$username', email = '$email', address = '$address', phone_number = '$phone_number' WHERE user_id = '$user_id'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        $errorMessage = "Error updating information: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <title>User Dashboard</title>
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
            <li><a href="account.php" class="active">Account Information</a></li>
            <li><a href="order-history.php">Order History</a></li>
            <li><a href="wishlist.php">Wishlist</a></li>
        </ul>
    </aside>

    <main class="admin-content">
        <div class="admin-header">
            <h1><?= $userDetails['username'] ?>, Your Account Information</h1>
        </div>
        <form id="productCreationForm" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= $userDetails['username'] ?>" required/>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?= $userDetails['email'] ?>" required/>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?= $userDetails['phone_number'] ?>" required/>

            <label for="address">Shipping Address:</label>
            <input type="text" id="address" name="address" value="<?= $userDetails['address'] ?>" required/>

            <button type="submit" class="add-product-btn">Save</button>
        </form>

        <?php
        if (isset($successMessage)) {
            echo '<p class="success" style="text-align:center;">' . $successMessage . '</p>';
        } elseif (isset($errorMessage)) {
            echo '<p class="error" style="text-align:center;>"' . $errorMessage . '</p>';
        }
        ?>
    </main>
</div>
</body>
</html>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("./db/database-connection.php");

$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

if (!empty($user_id)) {
    $query = "SELECT role FROM Users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        $_SESSION['role'] = $role;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<header>
    <a class="logo" href="index.php"><img src="assets/favicon.png" alt="logo"></a>
    <nav>
        <ul class="nav__links">
            <li><a href="shop.php">Shop</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>

            <?php
            if (isset($_SESSION["user_id"])) {
                $role = isset($_SESSION["role"]) ? $_SESSION["role"] : "";
                if ($role == "admin") {
                    echo '<li><a href="./admin/dashboard.php">Dashboard</a></li>';
                } else {
                    echo '<li><a href="./user/dashboard.php">Dashboard</a></li>';
                }
            }
            ?>
        </ul>
    </nav>

    <?php
    if (isset($_SESSION["user_id"])) {
        echo '<form class="logout-form" action="./logout.php" method="post">
                  <button class="cta" type="submit">Logout</button>
              </form>';
    } else {
        echo '<a class="cta" href="login.php">Login</a>';
    }
    ?>
    <p class="menu cta">Menu</p>
</header>

<!-- This is the Navbar in Mobile -->
<div id="mobile__menu" class="overlay">
    <a class="close">&times;</a>
    <div class="overlay__content">
        <a href="shop.php">Shop</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>

        <?php
        if (isset($_SESSION["user_id"])) {
            $role = isset($_SESSION["role"]) ? $_SESSION["role"] : "";
            
            if ($role == "admin") {
                echo '<a href="./admin/dashboard.php">Dashboard</a>';
            } else {
                echo '<a href="./user/dashboard.php">Dashboard</a>';
            }

            echo '<a class="cta-mobile" href="./logout.php">Logout</a>';
        } else {
            echo '<a class="cta-mobile" href="login.php">Login</a>';
        }
        ?>

        <a class="cta-mobile" href="cart.php">Cart</a>
    </div>
</div>

<script type="text/javascript" src="./js/mobile.js"></script>

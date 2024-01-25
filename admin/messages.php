<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Messages Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet" />
</head>
<body>

<!-- Navbar Desktop -->
<header>
    <a class="logo" href="index.php"><img src="../assets/favicon.png" alt="logo"/></a>
    <nav>
        <ul class="nav__links">
            <li><a href="shop.html">Shop</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>
    <a class="cta" href="login.html">Login</a>
    <p class="menu cta">Menu</p>
</header>

<!-- Navbar in Mobile -->
<div id="mobile__menu" class="overlay">
    <a class="close">&times;</a>
    <div class="overlay__content">
        <a href="shop.html">Shop</a>
        <a href="about.html">About</a>
        <a href="contact.html">Contact</a>
        <a class="cta-mobile" href="login.html">Login</a>
        <a class="cta-mobile" href="cart.html">Cart</a>
    </div>
</div>

<!-- Admin Dashboard Sidebar and Content -->
<div class="admin-container">

    <aside class="sidebar">
        <ul class="sidebar__links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="messages.php" class="active">Messages</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <div class="admin-header">
            <h1>Messages Management</h1>
        </div>

        <!-- Display Messages Table -->
        <div class="table-container">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../db/database-connection.php');
                    $query = "SELECT * FROM ContactFormSubmissions";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['submission_id']}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['subject']}</td>";
                        echo "<td>{$row['message']}</td>";
                        echo "<td>{$row['timestamp']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>

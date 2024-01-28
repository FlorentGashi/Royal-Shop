<header>
    <a class="logo" href="../index.php">
        <img src="../assets/favicon.png" alt="logo"/>
    </a>
    <nav>
        <ul class="nav__links">
            <li><a href="../shop.php">Shop</a></li>
            <li><a href="../about.php">About</a></li>
            <li><a href="../contact.php">Contact</a></li>
        </ul>
    </nav>
    <?php
    if (isset($_SESSION["user_id"])) {
        echo '<form class="logout-form" action="../logout.php" method="post">
                  <button class="cta" type="submit">Logout</button>
              </form>';
    } else {
        echo '<a class="cta" href="login.php">Login</a>';
    }
    ?>
    <p class="menu cta">Menu</p>
</header>

<div id="mobile__menu" class="overlay">
    <a class="close">&times;</a>
    <div class="overlay__content">
        <a href="../shop.php">Shop</a>
        <a href="../about.php">About</a>
        <a href="../contact.php">Contact</a>
        <?php
        if (isset($_SESSION["user_id"])) {
            echo '<a class="cta-mobile" href="../logout.php">Logout</a>';
        } else {
            echo '<a class="cta-mobile" href="login.php">Login</a>';
        }
        ?>
    </div>
</div>

<script src="../js/mobile.js"></script>
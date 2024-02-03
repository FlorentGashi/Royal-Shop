<?php
    include("./db/database-connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $email = $_POST["email"];

        $role = 'user';

        $query = "INSERT INTO Users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";
        $result = $conn->query($query);

        if ($result) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal | Regjistrohu</title>
    <meta name="description" content="Mirësevini në Royal Shop, destinacioni tuaj i preferuar për blerje online të produkteve të teknologjisë. Gjeni pajisjet më të fundit dhe cilësore për të përmirësuar përvojën tuaj digjitale. Shfletoni koleksionin tonë dhe hapi dritën e inovacionit!">
    <meta name="keywords" content="Teknologji e fundit, Blerje online teknologjike, Paisje elektronike, Pajisje inteligjente, Shitje produkte teknologjike, Gadget inovative, Telefona inteligjentë, Laptopë cilësore, Aksesore teknologjike, Oferta teknologjike">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

    <?php 
        include './components/loader.php'
    ?>

    <?php 
    include './components/header.php'
    ?>

    <!-- This is The Registration Form -->
    <div class="form-container">
        <h1 class="title">Regjistrohu</h1>
        <form class="form" action="signup.php" method="post" onsubmit="return validateForm()">
            <div class="input-group">
                <label for="username">Sheno Emrin</label>
                <input type="text" name="username" id="username" required>
                <p id="usernameError" class="error"></p>
            </div>
            <div class="input-group">
                <label for="email">Sheno Email</label>
                <input type="email" name="email" id="email" required>
                <p id="emailError" class="error"></p>
            </div>
            <div class="input-group">
                <label for="password">Sheno Paswordin</label>
                <input type="password" name="password" id="password" required>
                <p id="passwordError" class="error"></p>
            </div>
            <button class="sign">Regjistrohu</button>
        </form>
        <p class="signup">Keni nje Llogari?
            <a rel="noopener noreferrer" href="login.php">Kyçu</a>
        </p>
    </div>
    <!-- Registration Form End's Here -->

    <?php 
    include './components/footer.php'
    ?>
</body>
</html>

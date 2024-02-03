<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal | Kyçu</title>
    <meta name="description" content="Mirësevini në Royal Shop, destinacioni tuaj i preferuar për blerje online të produkteve të teknologjisë. Gjeni pajisjet më të fundit dhe cilësore për të përmirësuar përvojën tuaj digjitale. Shfletoni koleksionin tonë dhe hapi dritën e inovacionit!">
    <meta name="keywords" content="Teknologji e fundit, Blerje online teknologjike, Paisje elektronike, Pajisje inteligjente, Shitje produkte teknologjike, Gadget inovative, Telefona inteligjentë, Laptopë cilësore, Aksesore teknologjike, Oferta teknologjike">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <?php 
        include './components/loader.php';
        include './components/header.php';
    ?>
    
    <?php
        header('Content-Type: text/html; charset=utf-8');

        include("./db/database-connection.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];
        
            $query = "SELECT user_id, password, role FROM Users WHERE username = '$username'";
            $result = $conn->query($query);
        
            if ($result) {
                $row = $result->fetch_assoc();
        
                if ($row) {
                    $user_id = $row['user_id'];
                    $hashedPassword = $row['password'];
                    $role = $row['role'];
        
                    if (password_verify($password, $hashedPassword)) {
                        session_start();
                        $_SESSION["user_id"] = $user_id;
        
                        if ($role == 'admin') {
                            header("Location: ./admin/dashboard.php");
                            exit();
                        } elseif ($role == 'user') {
                            header("Location: ./user/dashboard.php");
                            exit();
                        } 
                    } 
                } 
            } else {
                echo "Error: " . $conn->error;
            }
        }
        ?>

    <!-- This is The Login Form -->
    <div class="form-container">
        <h1 class="title">Kyçu</h1>
        <form class="form" action="login.php" method="post" onsubmit="return validateForm()">
            <div class="input-group">
                <label for="username">Sheno Emrin</label>
                <input type="text" name="username" id="username" required>
                <p id="usernameError" class="error"></p>
            </div>
            <div class="input-group">
                <label for="password">Sheno Paswordin</label>
                <input type="password" name="password" id="password" required>
                <p id="passwordError" class="error"></p>
            </div>
            <button class="sign">Kyçu</button>
        </form>
        <p id="successMessage" class="success"></p>
        <p class="signup">Nuk keni ende nje Llogari?
        <a rel="noopener noreferrer" href="signup.php" class="">Regjistrohu</a>
        </p>
    </div>
    <!--  Login Form End's Here -->

    <!-- Footer Section Starts Here -->
    <?php 
     include './components/footer.php'
    ?>
    
</body>
</html>
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
    <!-- Here is The Loader so The Page Doesn't show up till the content is Loaded -->
    <div class="center-body" id="loading">
        <div class="loader-circle-86">
            <svg version="1.1" x="0" y="0" viewbox="-10 -10 120 120" enable-background="new 0 0 200 200" xml:space="preserve">
           <path class="circle" d="M0,50 A50,50,0 1 1 100,50 A50,50,0 1 1 0,50"/>
            </svg>
        </div>
    </div>
    
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


    <?php 
     include './components/header.php'
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


    <!-- Form Validation Here -->
    <script>
        let usernameRegex = /^[A-Za-z]/;
        let passwordRegex = /^[A-Z].*\d{3}$/;
    
        function validateForm() {
            let usernameInput = document.getElementById('username');
            let usernameError = document.getElementById('usernameError');
            let passwordInput = document.getElementById('password');
            let passwordError = document.getElementById('passwordError');
            let successMessage = document.getElementById('successMessage');
    
            usernameError.innerText = '';
            passwordError.innerText = '';
    
            if (!usernameRegex.test(usernameInput.value)) {
                usernameError.innerText = 'Emri i Përdoruesit duhet të jetë nga 8 deri në 15 karaktere dhe të përmbajë vetëm shkronja.';
                return false;
            }
    
            if (!passwordRegex.test(passwordInput.value)) {
                passwordError.innerText = 'Fjalëkalimi duhet të fillojë me shkronjë të madhe dhe të përmbajë të paktën 3 numra.';
                return false;
            }
    
            successMessage.innerText = 'Forma u plotësua me sukses!';
            return true;
        }
    </script>

    <script>
		window.addEventListener('load', function() {
			document.getElementById('loading').classList.add('hide');
		});
	</script>
    
</body>
</html>
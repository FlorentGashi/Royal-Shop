<?php
    include("./db/database-connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];

    
        $query = "INSERT INTO ContactFormSubmissions (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
        $result = $conn->query($query);

        if ($result) {    
            header("Location: thankyou.php"); 
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
    <title>Royal Production | Na Kontaktoni</title>
    <meta name="description" content="Mirësevini në Royal Shop, një ambient online ku teknologjia dhe eleganca bëhen një. Nëpërmjet faqes sonë,ju ftojmë të eksploroni botën tonë të pajisjeve të fundit, të krijuara me kujdes për të përmirësuar dhe transformuar përvojën tuaj digjitale. Shfletoni, gjeni, dhe hapi dritën e inovacionit te Royal Shop!">
    <meta name="keywords" content="Teknologji e fundit, Blerje online teknologjike, Paisje elektronike, Pajisje inteligjente, Shitje produkte teknologjike, Gadget inovative, Telefona inteligjentë, Laptopë cilësore, Aksesore teknologjike, Oferta teknologjike">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body> 
    <?php 
        include './components/loader.php'
    ?>
 
    <?php 
    include './components/header.php'
    ?>

    <section class="contact-us">
        <div class="row" style="align-items: center;">
            <div class="contact-col">
                <h1 class="contact-h1">Na Kontaktoni</h1>
                <p style="padding-left: 70px; width: 690px" class="contact-p">Ju jeni të mirëpritur të na kontaktoni për çdo pyetje, kërkesë apo informacion shtesë. Na dërgoni një email, telefononi ose vizitoni zyrën tonë. Ne jemi këtu për të ndihmuar dhe përgjigjur në mënyrë të shpejtë dhe efikase. <br> Faleminderit për interesimin tuaj për Royal Shop!</p>
                <div style="margin-top: 50px;">
                    <i class="fa fa-home"></i>
                    <span>
                        <a href="https://maps.app.goo.gl/6PXJtt2TM3pmRndy5" class="contact-col-a"><p class="col-important">UBT, Prishtina</p></a>
                        <p>10000 - Prishtina</p>
                    </span>
                    </div>
                    <div>
                    <i class="fa fa-phone"></i>
                    <span>
                        <a href="tel:+38349191357" class="contact-col-a"><p class="col-important">+38349191357</p></a>
                        <p>E Hënë deri të Shtunë, 10AM deri në 6PM</p>
                    </span>
                    </div>
                    <div>
                    <i class="fa fa-envelope"></i>
                    <span>
                        <a href="mailto:info@intrioxa.com" class="contact-col-a"><p class="col-important">info@intrioxa.com</p></a>
                        <p>Dërgoni email për pyetje</p>
                    </span>
                    </div>                  
            </div>
            <div class="contact-col">
                <div class="contact-form-container">
                    <form action="contact.php" method="POST">
                        <input type="text" name="name" placeholder="Shkruaj Emrin Tend" required>
                        <input type="email" name="email" placeholder="Shkruaj Email Adresen" required>
                        <input type="text" name="subject" placeholder="Subjekti" required>
                        <textarea rows="8" name="message" placeholder="Mesazhi" required></textarea>
                        <button type="submit" class="submit-btn-contact">Dërgo Mesazhin</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <section class="location">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46940.2060114189!2d21.1587273!3d42.666380100000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13549ee605110927%3A0x9365bfdf385eb95a!2sPristina!5e0!3m2!1sen!2s!4v1702003510162!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>


    <?php 
    include './components/footer.php'
    ?>
</body>
</html>
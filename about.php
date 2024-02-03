<?php
include('./db/database-connection.php');
function getCount($conn, $table)
{
    $query = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($query);

    if ($result === false) {
        echo "Error: " . $conn->error; 
        return 0;
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}

$totalUsers = getCount($conn, "Users");
$totalProducts = getCount($conn, "Products");
$totalMessages = getCount($conn, "ContactFormSubmissions");
$totalOrders = getCount($conn, "Orders");
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Production | Rreth Nesh</title>
    <meta name="description" content="Mirësevini në Royal Shop, një ambient online ku teknologjia dhe eleganca bëhen një. Nëpërmjet faqes sonë,ju ftojmë të eksploroni botën tonë të pajisjeve të fundit, të krijuara me kujdes për të përmirësuar dhe transformuar përvojën tuaj digjitale. Shfletoni, gjeni, dhe hapi dritën e inovacionit te Royal Shop!">
    <meta name="keywords" content="Teknologji e fundit, Blerje online teknologjike, Paisje elektronike, Pajisje inteligjente, Shitje produkte teknologjike, Gadget inovative, Telefona inteligjentë, Laptopë cilësore, Aksesore teknologjike, Oferta teknologjike">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color: #f4f4f4;">
    <?php 
        include './components/loader.php';
        include './components/header.php';
    ?>

        <section class="about-us">
            <div class="row">
              <div class="about-col">
                <h1 class="about-h1">Royal Shop</h1>
                <p>
                  Royal Shop është një dyqan online i specializuar në produkte
                  teknologjike dhe inovative. Ne ofrojmë një gamë të gjërë të
                  produkteve me cilësi të lartë dhe çmime të përballueshme.
                </p>
                <p>
                  Jemi të përkushtuar për të ofruar shërbim të shkëlqyer ndaj
                  klientëve tanë. Vizioni ynë është të sigurojmë një eksperiencë
                  blerjeje të paharrueshme për të gjithë klientët tanë.
                </p>
                <p>
                  Nëse keni pyetje ose shqetësime, mos ngurroni të na kontaktoni. Ju
                  faleminderit për besimin tuaj në Royal Shop!
                </p>
                <br />
                <a href="contact.html" class="accept-btn">Na Kontaktoni</a>
              </div>
              <div class="about-col">
                <video src="./assets/About-Video.mov" autoplay loop muted playsinline></video>
              </div>
            </div>
          </section>

            <section class="interesting-facts">
                      <h2>Fakte Rreth Kompanise Tonë</h2>
                      <p>Ne jemi një kompani e specializuar në ofrimin e produkteve teknologjike të cilat sjellin inovacion në përdorimin e përditshëm.</p>
              
                      <table>
                          <tr>
                              <th>Kategoria</th>
                              <th>Vlera</th>
                          </tr>
                          <tr>
                              <td>Viti i Themelimit:</td>
                              <td>2023</td>
                          </tr>
                          <tr>
                              <td>Numri i Produktëve:</td>
                              <td><?= $totalProducts ?></td>
                          </tr>
                          <tr>
                              <td>Porosit e Realizuara:</td>
                              <td><?= $totalOrders ?></td>
                          </tr>
                          <tr>
                              <td>Klientë të Regjistruar Deri Tani:</td>
                              <td><?= $totalUsers ?></td>
                          </tr>
                      </table>
            </section>

        <?php 
         include './components/cta.php';
         include './components/footer.php';
        ?>
</body>
</html>
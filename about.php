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
    <!-- Here is The Loader so The Page Doesn't show up till the content is Loaded -->
    <div class="center-body" id="loading">
        <div class="loader-circle-86">
            <svg version="1.1" x="0" y="0" viewbox="-10 -10 120 120" enable-background="new 0 0 200 200" xml:space="preserve">
           <path class="circle" d="M0,50 A50,50,0 1 1 100,50 A50,50,0 1 1 0,50"/>
            </svg>
        </div>
    </div>

    <?php 
     include './components/header.php'
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
                              <td>670+</td>
                          </tr>
                          <tr>
                              <td>Klientët e Lumtur:</td>
                              <td>2500+</td>
                          </tr>
                          <tr>
                              <td>Cilesia e produkteve</td>
                              <td>Jemi te paret ne rajon per nga Cilesia 
                          </tr>
                      </table>
            </section>

        <!-- Call To Action Start's Here -->
        <section class="call-to-action">
            <div class="cta-content">
                <h2 class="cta-title">Zbulo ofertat tona ekskluzive!</h2>
                <p class="cta-description">Blej produkte teknologjike me çmime të neveritshme. Kthehu në botën e teknologjisë sot.</p>
                <a href="shop.html" class="cta-button">Eksploro Tani</a>
            </div>
        </section>
        <!-- Call to Action End's Here -->

        <?php 
         include './components/footer.php'
        ?>

        <script>
            window.addEventListener('load', function() {
                document.getElementById('loading').classList.add('hide');
            });
        </script>
</body>
</html>
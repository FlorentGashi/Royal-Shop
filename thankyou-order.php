<?php 
$orderID = isset($_GET['order_id']) ? $_GET['order_id'] : 'N/A';
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faleminderit</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./assets/favicon.png" type="image/x-icon">
</head>
   <?php 
   include './components/loader.php';
   include './components/header.php';
   ?>

    <div class="card-404">
        <h1>Faleminderit</h1>
        <p style="text-align: center;">Porosia juaj është bërë me sukses. ID-ja juaj e porosisë është: <?= $orderID ?></p>
        <a href="./user/dashboard.php" class="button">Kthehu në Dashboard</a>
    </div>

   <?php 
   include './components/footer.php'
   ?>
</html>
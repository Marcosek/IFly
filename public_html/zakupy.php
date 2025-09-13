<?php
    session_start();
  
if (isset($_POST['add_to_cart']) && isset($_POST['product_name'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_img = $_POST['product_img'];

   
    $found = false;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['product_name'] === $product_name) {
                $_SESSION['cart'][$key]['quantity']++;
                $found = true;
                break;
            }
        }
    }

   
    if (!$found) {
        $_SESSION['cart'][] = array(
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_img' => $product_img,
            'quantity' => 1
        );
    }
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFly</title>
    <link rel="stylesheet" type="text/css" href="Style/zakupy.css">
  <link rel="icon" type="image/x-icon" href="logo.png">
</head>
<body>
  <div class="top-nav">
    <div class="container">
      <div class="logo">
        <a href="http://ifly.ct8.pl/"><img src="logonapis.png" alt="Logo"></a>
      </div>
      <div class="nav-links">
        <ul>
        <?php
  
            if (isset($_SESSION['zalogowany'])) {
                echo "<li><a href='profil.php'>".$_SESSION['zalogowany']."</a></li><li><a href='logout.php'>Wyloguj sie</a></li>";
            }else {
                echo "<li><a href='log.php'>Logowanie</a></li><li><a href='reg.php'>Rejestracja</a></li>";
            }
        ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="second-nav">
    <ul>
      <li><a href="http://ifly.ct8.pl/loty.php">Loty</a></li>
      <li><a href="http://ifly.ct8.pl/">Pasażer</a></li>
      <li><a href="http://ifly.ct8.pl/">Usługi</a></li>
      <li><a href="http://ifly.ct8.pl/zakupy.php">Zakupy</a></li>
      <li><a href="http://ifly.ct8.pl/">Kontakt</a></li>
            <li><a href="http://ifly.ct8.pl/gra.php">Gra</a></li>
    </ul>
  </div>
  <div class="main-content">

<div id="gorne">

    <div id="wyszukiwarka">
      <form method="post" action="">
        <input type="text" name="wyszukiwarka"><br>
        <input type="submit" name="wyslij" value="Wyszukaj">
        </form>
    </div>

    <div id="koszyk">
        <a href="http://ifly.ct8.pl/koszyk.php"><h2>Koszyk</h2></a>
    </div>

</div>

<div id="produkty">

<?php
$servername = "mysql.ct8.pl";
$username = "m40342_marcosek";
$password = "Programista06";
$dbname = "m40342_IFly";


if(isset($_POST['wyslij']))
{
  $nazwa = $_POST['wyszukiwarka'];
  

  $conn = new mysqli($servername, $username, $password, $dbname);
      $zap = "SELECT * FROM products WHERE product_name LIKE '%$nazwa%'";
$zap = $conn->query($zap);

if ($zap->num_rows > 0) {
    

    while ($row = $zap->fetch_assoc()) {
        echo '<div id="produkt">';
    echo '<h3>' . $row["product_name"] . '</h3>';
    echo '<p>' . $row["price"] . ' PLN</p>';
    echo '<img src="' . $row["img"] . '" alt="' . $row["product_name"] . '">';
          echo '<form method="post" action="">';
            echo '<input type="hidden" name="product_name" value="' . $row["product_name"] . '">';
            echo '<input type="hidden" name="product_price" value="' . $row["price"] . '">';
            echo '<input type="hidden" name="product_img" value="' . $row["img"] . '">';
            echo '<input type="submit" name="add_to_cart" value="Dodaj do koszyka">';
            echo '</form>';
            echo '</div>';
    }

  }
  
}else{

$conn = new mysqli($servername, $username, $password, $dbname);
      $zap = "SELECT * FROM products";
$zap = $conn->query($zap);

if ($zap->num_rows > 0) {
    

    while ($row = $zap->fetch_assoc()) {
        echo '<div id="produkt">';
    echo '<h3>' . $row["product_name"] . '</h3>';
    echo '<p>' . $row["price"] . ' PLN</p>';
    echo '<img src="' . $row["img"] . '" alt="' . $row["product_name"] . '">';
          echo '<form method="post" action="">';
            echo '<input type="hidden" name="product_name" value="' . $row["product_name"] . '">';
            echo '<input type="hidden" name="product_price" value="' . $row["price"] . '">';
            echo '<input type="hidden" name="product_img" value="' . $row["img"] . '">';
            echo '<input type="submit" name="add_to_cart" value="Dodaj do koszyka">';
            echo '</form>';
            echo '</div>';
    }

  }
  

}

?>

</div>
  </div>
  <div class="footer">
    &copy IFly Airport | 2024 Wszelkie prawa zastrzeżone
  </div>
</body>
</html>
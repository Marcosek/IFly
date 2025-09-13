<?php
session_start();

if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFly</title>
    <link rel="stylesheet" type="text/css" href="Style/koszyk.css">
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
                    } else {
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
      <li><a href="http://ifly.ct8.pl/bilety.php">Kup Bilet</a></li>
            <li><a href="http://ifly.ct8.pl/">Usługi</a></li>
            <li><a href="http://ifly.ct8.pl/zakupy.php">Zakupy</a></li>
            <li><a href="http://ifly.ct8.pl/">Kontakt</a></li>
            <li><a href="http://ifly.ct8.pl/gra.php">Gra</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div id="produkty">
            <?php
            $totalPrice = 0;

            if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                echo '<h2>Twój koszyk:</h2>';
                echo '<form method="post" action="">';
                echo '<table border="1">';
                echo '<tr><th>Nazwa Produktu</th><th>Zdjęcie</th><th>Ilość</th><th>Cena</th></tr>';
                foreach ($_SESSION['cart'] as $product) {
                    if (is_array($product)) {
                        echo '<tr>';
                        echo '<td>' . $product['product_name'] . '</td>';
                        echo '<td><img src="' . $product['product_img'] . '" alt="' . $product['product_name'] . '" style="width:50px;height:50px;"></td>';
                        echo '<td>' . $product['quantity'] . '</td>';
                        $productTotalPrice = $product['product_price'] * $product['quantity'];
                        echo '<td>' . $productTotalPrice . ' PLN</td>';
                        $totalPrice += $productTotalPrice;
                        echo '</tr>';
                    }
                }
                echo '</table>';
                echo '<p>Łączna cena wszystkich produktów: ' . $totalPrice . ' PLN</p>';
                echo '<input type="submit" name="clear_cart" value="Wyczyść koszyk">';
                echo '</form>';
            } else {
                echo '<p>Twój koszyk jest pusty.</p>';
            }
            ?>
        </div>
        <?php
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            echo '<div id="prawa">';
            echo '<form method="post" action="">';
            echo '<label for="name">Imię i nazwisko:</label>';
            echo '<input type="text" id="name" name="name" required>';
            echo '<label for="city">Miasto:</label>';
            echo '<input type="text" id="city" name="city" required>';
            echo '<label for="address">Adres:</label>';
            echo '<input type="text" id="address" name="address" required>';
            echo '<label for="dostawa">Metoda dostawy:</label>';
            echo '<select id="dostawa" name="dostawa" required>';
            echo '<option value="paczkomat">Paczkomat (+6 PLN) </option>';
            echo '<option value="kurier">Kurier (+12 PLN) </option>';
            echo '</select>';
            echo '<input type="submit" value="wyslij" name="wyslij">';
            echo '</form>';
            echo '</div>';
        }
        ?>
        <?php
        if (isset($_POST['wyslij'])) {
            $name = $_POST['name'];
            $city = $_POST['city'];
            $adres = $_POST['address'];
            $dostawaNazwa = $_POST['dostawa'];
            
            if ($dostawaNazwa == 'paczkomat') {
                $dostawa = 6;
            } else {
                $dostawa = 12;
            }
            $totalTotalPrice = $totalPrice + $dostawa;
            
            echo '<div id="prawa"><h2>Twoje zamówienie zostało zatwierdzone!</h2><p>Imię i nazwisko: ' . $name . '</p><p>Miasto: ' . $city . '</p><p>Adres: ' . $adres . '</p><p><b>Łączna kwota zakupu: ' . $totalTotalPrice . ' PLN</b></p></div>';
            
            if (isset($_SESSION['zalogowany'])) {
                $nazwa = $_SESSION['zalogowany'];
            } else {
                $cyferki = rand(10000, 99999);
                $nazwa = "guest" . $cyferki;
            }

            $servername = "mysql.ct8.pl";
            $username = "m40342_marcosek";
            $password = "Programista06";
            $dbname = "m40342_IFly";

            $conn = new mysqli($servername, $username, $password, $dbname);
            $status = "oczekujace";
            $dataZamowienia = date("Y-m-d");
            $shipping_address = $city . " " . $adres;
            $query2 = "INSERT INTO orders (username, order_date, total_price, status, shipping_address) VALUES ('$nazwa', '$dataZamowienia', '$totalTotalPrice', '$status', '$shipping_address')";
            $result2 = $conn->query($query2);

            unset($_SESSION['cart']);
        }
        ?>
    </div>
    <div class="footer">
      &copy IFly Airport | 2024 Wszelkie prawa zastrzeżone
  </div>

</body>
</html>
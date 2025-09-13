<?php
    session_start();
    require_once "db.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFly - Moje rabaty</title>
    <link rel="stylesheet" type="text/css" href="Style/profil.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@500&display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="logo.png">
  <style>
    h2 {
      margin-left: 50px;
    }
    .button {
      margin-left: 50px;
    }
  </style>
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
       echo "<li><a href='http://ifly.ct8.pl/profil.php'>".$_SESSION['zalogowany']."</a></li><li><a href='logout.php'>Wyloguj sie</a></li>";
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
      <li><a href="http://ifly.ct8.pl/bilety.php">Kup Bilet</a></li>
      <li><a href="http://ifly.ct8.pl/">Usługi</a></li>
      <li><a href="http://ifly.ct8.pl/zakupy.php">Zakupy</a></li>
      <li><a href="http://ifly.ct8.pl/">Kontakt</a></li>
            <li><a href="http://ifly.ct8.pl/gra.php">Gra</a></li>
    </ul>
  </div>
  <div class="main-content">
    <div class="container-panels">
      <div class="panel">
        <ul class="options-list">
          <li><img src="icon_password.png" class="icon"><a href="http://ifly.ct8.pl/profil.php">Informacje</a> <span class="arrow">></span></li>
          <hr>
          <li><img src="icon_user.png" class="icon"><a href="http://ifly.ct8.pl/haslo.php">Zmiana Hasła</a> <span class="arrow">></span></li>
          <hr>
          <li><img src="icon_percent.png" class="icon"><a href="http://ifly.ct8.pl/rabat.php">Moje kody rabatowe</a> <span class="arrow">></span></li>
          <hr>
          <li><img src="icon_calendar.png" class="icon"><a href="http://ifly.ct8.pl/rezerwacje.php">Moje rezerwacje</a> <span class="arrow">></span></li>
          <hr>
          <li><img src="icon_orders.png" class="icon"><a href="http://ifly.ct8.pl/orders.php">Moje zamówienia</a> <span class="arrow">></span></li>
          <hr>
          <li><img src="icon_ticket.jpg" class="icon"><a href="http://ifly.ct8.pl/MyTickets.php">Moje Bilety</a> <span class="arrow">></span></li>
        </ul>
      </div>
      <div class="panel2">
        <h2>Twoje aktywne kody rabatowe:</h2>
        <?php
                  $servername = "mysql.ct8.pl";
$username = "m40342_marcosek";
$password = "Programista06";
$dbname = "m40342_IFly";

$conn = new mysqli($servername, $username, $password, $dbname);
        $query = "SELECT used FROM users WHERE username = '" . $_SESSION['zalogowany'] . "'";
$result = $conn->query($query);
  while ($row = $result->fetch_assoc()) {
         $used = $row["used"] ;
    }
  if($used == 'no'){
    $query2 = "SELECT discount FROM users WHERE username = '" . $_SESSION['zalogowany'] . "'";
$result2 = $conn->query($query2);
  while ($row2 = $result2->fetch_assoc()) {
         $rabat = $row2["discount"];
    echo "<p>Kod rabatowy 10% na dowolny bilet: <b>" . $rabat . "</p></b>";
  }
    }else {
  echo "<p>Brak aktywnych rabatów</p>";
  }
  
  ?>
      </div>
    </div>
  </div>
  <div class="footer">
    &copy IFly Airport | 2024 Wszelkie prawa zastrzeżone
  </div>
</body>
</html>
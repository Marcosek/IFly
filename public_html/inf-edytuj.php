<?php
    session_start();
    require_once "db.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFly - Edytowanie profilu</title>
    <link rel="stylesheet" type="text/css" href="Style/profil.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@500&display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="logo.png">
  <style>
    .panel2 {
        text-align: center;
    }

    .button {
        width: 312px;
        height: 60px;
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
      <li><a href="http://ifly.ct8.pl/">Loty</a></li>
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
      <h2>INFORMACJE</h2>
        <form method="POST" action="">  
            <div><br><input type="text" name="username" placeholder="Nazwa użytkownika" required id="input_form"></div>
            <div><br><input type="text" name="number" placeholder="Numer telefonu" pattern="[0-9]{9}" title="Wprowadź 9 cyfr" required id="input_form"></div>
            <input type="submit" name="submit" value="Wprowadź" class="button">
        </form>
            <?php
            if(isset($_POST['submit'])){
                $name = $_SESSION['zalogowany'];
                $username = $_POST['username'];
                $number = $_POST['number'];
            
                $sql2="UPDATE users SET username = '$username', number = '$number' WHERE username = '$name'";
            
                $result = $conn->query($sql2);
                $_SESSION['zalogowany'] = $username;
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
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFly</title>
    <link rel="stylesheet" type="text/css" href="Style/index2.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
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
  <div class="bg">
    <div class="tablica">
    <form method="post">
      <input type="submit" name="show_departures" value="Odloty" class="buttons">
      <input type="submit" name="show_arrivals" value="Przyloty" class="buttons2">
    </form>
    <?php
  require_once "displaytable.php";

  if(isset($_POST['show_departures'])) {
    displayTable($departures_result, "odloty", true);
  } elseif(isset($_POST['show_arrivals'])) {
    displayTable($arrivals_result, "przyloty", false);
  } else {
    // Domyślne wyświetlenie obu tabel
    displayTable($departures_result, "odloty", true);
  }
  ?>
  </div>
  </div>
  <div class="add-info">
    <h3>Gdzie jesteśmy?</h3>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5100.5847970355935!2d19.12921185657223!3d50.267798787857714!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4716dbe890978aa7%3A0x72a04755996b8d9b!2sZesp%C3%B3%C5%82%20Szk%C3%B3%C5%82%20Elektronicznych%20i%20Informatycznych!5e0!3m2!1spl!2spl!4v1704843243310!5m2!1spl!2spl" width="800" height="600" style="border:1;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  <hr>
  <div class="News">
    <h3>Szybkie newsy!</h3>
    <div class="A1">
    <img src="News1.jpg">
    <h4>Rozszerzenie udogodnień w terminalu</h4>
    <a class="t1">Lotnisko ogłasza plany rozszerzenia i modernizacji terminalu, aby zapewnić podróżnym jeszcze lepsze doświadczenia podczas oczekiwania na lot. </a>
    </div>
    <div class="A2">
    <img src="News2.jpg">
    <h4>Program poprawy ekologicznej</h4>
    <a class="t1">Lotnisko wprowadza nowy program mający na celu redukcję wpływu na środowisko. Poprzez zastosowanie nowych technologii i innowacyjnych rozwiązań, lotnisko planuje zmniejszyć emisję CO2 oraz minimalizować negatywny wpływ na otaczającą przyrodę. </a>
    </div>
  </div>
  </div>
  <div class="footer">
    &copy IFly Airport | 2024 Wszelkie prawa zastrzeżone
  </div>
</body>
</html>
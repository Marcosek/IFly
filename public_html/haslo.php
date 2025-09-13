<?php
    session_start();
    require_once "db.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFly - Zmiana hasła</title>
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
        margin-top: 140px;
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
      <li><a href="http://ifly.ct8.pl/">Pasażer</a></li>
      <li><a href="http://ifly.ct8.pl/">Usługi</a></li>
      <li><a href="http://ifly.ct8.pl/zakupy.php">Zakupy</a></li>
      <li><a href="http://ifly.ct8.pl/">Kontakt</a></li>
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
      <h2>ZMIANA HASŁA</h2>
        <form method="POST" action="">  
        <div><br><input type="password" name="old" placeholder="Poprzednie Hasło" required id="input_form"></div>
        <div><br><input type="password" name="new" placeholder="Nowe hasło" required id="input_form"></div>
        <div><br><input type="password" name="new2" placeholder="Powtórz nowe hasło" required id="input_form"></div>
            <input type="submit" name="submit" value="Zmień hasło" class="button">
        </form>
            <?php
if (isset($_POST['submit'])) {
    $oldPassword = $_POST['old'];
    $newPassword = $_POST['new'];
    $newPasswordRepeat = $_POST['new2'];

    if ($newPassword !== $newPasswordRepeat) {
        echo "<a style='color: red; font-weight:bold'>Nowe hasła nie zgadzają się.</a>";
    } else {
        if (isset($_SESSION['zalogowany'])) {
            $username = $_SESSION['zalogowany'];

            $getUserQuery = "SELECT password FROM users WHERE username = ?";
            $stmt = $conn->prepare($getUserQuery);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];

                if (password_verify($oldPassword, $hashedPassword)) {
                    $hashedNewPassword = hashPassword($newPassword);

                    $updateQuery = "UPDATE users SET password = ? WHERE username = ?";
                    $stmt = $conn->prepare($updateQuery);
                    $stmt->bind_param("ss", $hashedNewPassword, $username);
                    if ($stmt->execute()) {
                        echo "<a style='color: red; font-weight:bold'>Hasło zostało zmienione pomyślnie.</a>";
                        session_destroy(); 
                        header("Location: log.php");
                    } else {
                        echo "Wystąpił problem podczas zmiany hasła.";
                    }
                } else {
                    echo "<a style='color: red; font-weight:bold'>Stare hasło jest niepoprawne.</a>";
                }
            } else {
                echo "<a style='color: red; font-weight:bold'>Nie znaleziono użytkownika.</a>";
            }
        } else {
            echo "<a style='color: red; font-weight:bold'>Użytkownik niezalogowany.</a>";
        }
    }
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
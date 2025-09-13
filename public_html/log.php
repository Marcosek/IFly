<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Style/reg.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@500&display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="logo.png">
    <title>Logowanie</title>
    <style>
        body{
            background-image: url(bgreg3.jpg);
            background-size: cover;
        
        }
    </style>
</head>
<body>
    <div id="panel">
    <h1>ZALOGUJ SIĘ</h1>
    <form action="log.php" method="post">
        <div><br><input type="text" name="login" placeholder="Nazwa użytkownika" required id="input_form"></div>
        <div><br><input type="password" name="haslo" placeholder="Hasło" required id="input_form"></div>
        <input type="submit" name="loguj" value="ZALOGUJ SIĘ"  id="button">
    </form>   
    <a class="a2">Jestes nowy?</a><a href="reg.php" id="href" class="a2"> Stwórz konto</a>
</div>
<?php
require_once "db.php";


session_start();
  if(isset($_POST['login']) && isset($_POST['haslo'])){
      $login = $_POST['login'];
      $pass = $_POST['haslo'];
      $_SESSION['rejestracja'] = 1;
      $q1 = "SELECT * FROM users WHERE username = '$login' AND verification_status = 'true'";
      $result = $conn->query($q1);
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
         
          if (password_verify($pass, $row['password'])) {
              
              $_SESSION['zalogowany'] = $row['username'];
              header('Location: index.php');
  
          }else {
  
              echo "<div id='alert'>Błędny login lub hasło</div>";
          }
      }else{
              echo "<div id='alert'>Brak użytkownika lub nie potwierdziłeś konta <a href='user-otp.php' style='text-decoration: none;'>Potwierdź konto</a></div>";
      }
  }    ?>

</body>
</html>
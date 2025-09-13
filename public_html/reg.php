<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Style/reg.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@500&display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="logo.png">
    <title>Rejestracja</title>
    <style>
        body{
            background-image: url(bgreg.jpg);
            background-size: cover;
        }
    </style>
</head>
<body>
    <div id="panel">
    <h1>STWÓRZ KONTO</h1>
    <form action="" method="post">
        <div><br><input type="text" name="login" placeholder="Nazwa użytkownika" required id="input_form"></div>
        <div><br><input type="email" name="email" placeholder="Email" required id="input_form"></div>
        <div><br><input type="password" name="haslo" placeholder="Hasło" required id="input_form"></div>
        <div><br><input type="password" name="haslo2" placeholder="Powtórz hasło" required id="input_form"></div>
        <input type="submit" name="Loguj" value="STWÓRZ" id="button"><br>
        <a class="a">Masz juz konto?</a><a href="log.php" id="href" class="a"> Zaloguj się</a>
    </form>   
    </div>
    <?php

    require_once "db.php";


if(isset($_POST['login']) && isset($_POST['haslo']) && isset($_POST['email'])) {
    $login = $_POST['login'];
    $password = $_POST['haslo'];
    $password2 = $_POST['haslo2'];
    $email = $_POST['email'];

if($password !== $password2){
    echo "<div id='alert'>Twoje hasła do siebie nie pasują</div>";

  }else{

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail = true;
    }else {
        $mail = false;
        echo "<div id='alert'>Email jest niepoprawny.</div>";
    }

    
    if ($mail) {
  $email_check = $conn->query("SELECT * FROM users WHERE email = '{$email}'");
  if ($email_check->num_rows > 0) {
      echo "<div id='alert'>Taki adres email już istnieje.<div>";
  }else{
    $username_check = $conn->query("SELECT * FROM users WHERE username = '{$login}'");
    if ($username_check->num_rows > 0) {
      echo "<div id='alert'>Taka nazwa użytkownika już istnieje.</div>";
  }else{
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $code = rand(999999, 111111);
        $status = "false";
        $data_check= $conn->query("INSERT INTO users VALUES (NULL, '{$login}', '{$hash}', '{$email}', 'false', '$code', '', NULL, NULL)");
    if($data_check){
        try {
  $mail = new PHPMailer();

  $mail->isSMTP();
  $mail->SMTPDebug = 0;

  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 465;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->SMTPAuth = true;

  $mail->Username = 'Ifly.ct8@gmail.com';
  $mail->Password = 'fiixfginctewshse';

  $mail->CharSet = 'UTF-8';
  $mail->setFrom('no-reply@domena.pl', 'IFly');
  $mail->addAddress($email);
  $mail->addReplyTo('biuro@domena.pl', 'IFly');

  $mail->isHTML(true);
  $mail->Subject = 'Twój kod weryfikacji!';
  $mail->Body = "<html>
<head>
    <title>Twój kod weryfikacji do konta {$login}!</title>
    <style>
* {
  margin: 0;
  padding: 0;
}

body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
  background-color: #f5f5f5;
}

.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #ffffff;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.header {
  text-align: center;
  margin-bottom: 20px;
}

.logo {
  max-width: 150px;
  height: auto;
  margin-bottom: 10px;
}

.content {
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 5px;
}

.code {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.email {
  margin-bottom: 20px;
}

.footer {
  text-align: center;
  margin-top: 20px;
  color: #777777;
}
    </style>
</head>
<body>
    <div class='container'>
    <div class='header'>
      <img src='https://i.imgur.com/TnffThR.png' alt='Logo' class='logo'>
      <h2>Witaj!</h2>
    </div>
    <div class='content'>
      <p>Twój kod weryfikacyjny:</p>
      <p class='code'>{$code}</p>
      <p>Weryfikacja jest wymagana w celu dokończenia procesu rejestracji.</p>
      <p>Prosimy o potwierdzenie adresu e-mail do konta: <strong>{$login}</strong></p>
      <p>http://ifly.ct8.pl/user-otp.php</p>
    </div>
    <div class='footer'>
      <p>W przypadku pytań skontaktuj się z nami pod adresem: <a href='mailto:Ifly.ct8@gmail.com'>Ifly.ct8@gmail.com</a></p>
    </div>
  </div>
</body>
</html>";
    $mail->send();
          
header('location: user-otp.php');

} catch(Exception $e) {
  header('location: user-otp.php');
}        }else{
        exit();
    }
}}}}}
?>
</body>
</html>

</body>

</html>
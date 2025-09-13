<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Style/reg.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@500&display=swap" rel="stylesheet">
    <title>Weryfikacja</title>
    <style>
        body{
            background-image: url(bgreg3.jpg);
            background-size: cover;
        }
    </style>
</head>
<body>
    <div id="panel">
    <h1>WERYFIKACJA KONTA</h1>
    <form action="" method="post">
        <div><br><input type="text" name="email" placeholder="Email" required id="input_form"></div>
        <div><br><input type="text" name="verification_code" placeholder="Kod" required id="input_form"></div>
            <div><br><input type="submit" value="ZWERYFIKUJ" id="button"></div>
    </form>
    </div>
    <?php
require_once "db.php";

if(isset($_POST['email']) && isset($_POST['verification_code'])) {
    $email = $_POST['email'];
    $verification_code = $_POST['verification_code'];

    $query = "SELECT * FROM users WHERE email = '$email' AND code = '$verification_code'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $update_query = "UPDATE users SET verification_status = 'true' WHERE email = '$email'";
        if ($conn->query($update_query) === TRUE) {
            echo "<div id='alert'>Weryfikacja zakonczona pomyslnie!</div>";
      header('location: log.php');
        } else {
            echo "<div id='alert'>Błąd podczas aktualizacji weryfikacji: </div>" . $conn->error;
        }
    } else {
        echo "<div id='alert'>Kod weryfikacyjny nie pasuje do emaila '$email'.</div>";
    }
}
?>
</body>
</html>

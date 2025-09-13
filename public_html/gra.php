<?php
    session_start();
  $rabatNazwa = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gra</title>
    <link rel="stylesheet" type="text/css" href="gra.css">
  <link rel="icon" type="image/x-icon" href="logo.png">
    <script src="gra.js"></script>
</head>
<body>
  <div id="boxy">
<?php
    if (isset($_SESSION['zalogowany'])) {
      echo "<div id='zalogowany-info'>";
        echo 'Jesteś zalogowany jako '."<b>".$_SESSION['zalogowany']."</b><br>Uzyskaj najlepszy wynik i zdobądź rabat 10% na dowolny lot!";
      echo "</div>";
         
      $servername = "mysql.ct8.pl";
$username = "m40342_marcosek";
$password = "Programista06";
$dbname = "m40342_IFly";

$conn = new mysqli($servername, $username, $password, $dbname);
      $top_scores_query = "SELECT username, result FROM score ORDER BY result DESC LIMIT 10";
$top_scores_result = $conn->query($top_scores_query);

if ($top_scores_result->num_rows > 0) {
    echo "<div id='lewa'><table><caption>TOP 10 WYNIKÓW</caption><tr><th>Nazwa</th><th>Wynik</th></tr>";

    while ($row = $top_scores_result->fetch_assoc()) {
        echo "<tr><td>" . $row["username"] . "</td><td>" . $row["result"] . "</td></tr>";
    }

    echo "</table></div>";
} else {
    echo "Brak danych do wyświetlenia.";
}
        ?>
  <div id="srodek">
        <canvas id="gra">
        </canvas>
        <form action="" method="post">
            <h1>Wynik:</h1><input type="text" name="wynik" id="wynik" readonly>
            <input type="submit" value="Zapisz wynik" name="submit">
        </form>
    
          </div>
    <?php
      $rabat='';
    if(isset($_POST["submit"])) {
    $dzisiejszaData = date("Y-m-d");
    $servername = "mysql.ct8.pl";
    $username = "m40342_marcosek";
    $password = "Programista06";
    $dbname = "m40342_IFly";
      

    $conn = new mysqli($servername, $username, $password, $dbname);

    $wynik = $_POST['wynik'];
    $name = $_SESSION['zalogowany'];
      
 $query = "SELECT MAX(result) AS najwiekszyWynik FROM score";
      $result = $conn->query($query);
      if ($result){
        $row = $result->fetch_assoc();
        if ($wynik > $row['najwiekszyWynik']){
          $rabat = rand(10000, 99999);
          $query_rabat = "UPDATE users SET discount = '$rabat' WHERE username = '" . $_SESSION['zalogowany'] . "'";
          $query_used = "UPDATE users SET used = 'no' WHERE username = '" . $_SESSION['zalogowany'] . "'";
          $result_rabat = $conn->query($query_rabat);
          $result_used = $conn->query($query_used);
          $rabatNazwa = "Gratulacje udało ci się zdobyć rabat 10% na dowolny lot! Kod: " . $rabat;
        } 
      }
    
    $check_user_query = "SELECT * FROM score WHERE username = '$name'";
    $check_result = $conn->query($check_user_query);

    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        $current_result = $row['result'];

        if ($wynik > $current_result) {
            $update_query = "UPDATE score SET result = '$wynik', date = '$dzisiejszaData' WHERE username = '$name'";
            $update_result = $conn->query($update_query);
            if ($update_result) {
                
            } else {
                echo "Błąd podczas aktualizacji wyniku: " . $conn->error;
            }
        }    } else {
        $insert_query = "INSERT INTO score (result, username, date) VALUES ('$wynik','$name','$dzisiejszaData')";
        $insert_result = $conn->query($insert_query);
        if ($insert_result) {
            
        } else {
            echo "Błąd podczas dodawania nowego wyniku: " . $conn->error;
        }
    }
   
}
   $siedemDni = date("Y-m-d", strtotime("-7 days"));
$servername = "mysql.ct8.pl";
$username = "m40342_marcosek";
$password = "Programista06";
$dbname = "m40342_IFly";

$conn = new mysqli($servername, $username, $password, $dbname);

  
      
      
  $top_scores_date_query = "SELECT username, result FROM score WHERE date >= '$siedemDni' ORDER BY result DESC LIMIT 10 ";
  $top_scores_date_result = $conn->query($top_scores_date_query);
  
  if ($top_scores_date_result->num_rows > 0) {
    echo "<div id='prawa'><table><caption>TOP 10 WYNIKÓW TEGO TYGODNIA</caption><tr><th>Nazwa</th><th>Wynik</th></tr>";

    while ($row = $top_scores_date_result->fetch_assoc()) {
        echo "<tr><td>" . $row["username"] . "</td><td>" . $row["result"] . "</td></tr>";
    }

    echo "</table></div>";
} else {
    echo "Brak danych do wyświetlenia.";
}
  ?>
        <div id="rabat">
<p><?php

echo $rabatNazwa;

?></p></div>
    
    <?php

 } else {
   echo "<div id='zalogowany-info'>";
        echo "Musisz się zalogować, aby zagrać.";
   echo "</div>";
    }
    ?>

  

          </div>
  </body>
  </html>
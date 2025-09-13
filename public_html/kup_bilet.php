<?php
    session_start();
    require_once "db.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFly - Kup Bilet</title>
    <link rel="stylesheet" type="text/css" href="Style/index.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
 
form {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

form label {
  margin-bottom: 10px;
  font-size: 18px;
}

form select,
form input[type="number"],
form input[type="submit"] {
  margin-bottom: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 60%;
  max-width: 300px;
  font-size: 16px;
}

form input[type="submit"] {
  background-color: #3498db;
  color: #fff;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
  background-color: #2980b9;
}


body {
  font-family: 'Roboto', sans-serif; 
}

h2 {
  margin-bottom: 30px;
}


.footer {
  background-color: #333;
  color: #fff;
  width: 100%;
  text-align: center;
  padding: 20px 0;
  position: fixed;
  bottom: 0;
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
    <h2>Bilet Lotniczy</h2>
        <form method="post" action="">
            <?php
                $flight_id = $_GET['flight_id'];
                $sql = "SELECT flights.start, flights.flight_number, flights.gate, tour.departure_location, tour.arrival_location, tour.business_class,tour.economy_class
                        FROM flights
                        INNER JOIN tour ON flights.ID_tour = tour.tour_id
                        WHERE flights.ID = $flight_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<label>Z miasta: " . $row["departure_location"] . "</label><br>";
                        echo "<label>Kierunek: " . $row["arrival_location"] . "</label><br>";
                        echo "<label>Start: " . $row["start"] . "</label><br>";
                        echo "<label>Numer lotu: " . $row["flight_number"] . "</label><br>";
                        echo "<label>Brama: " . $row["gate"] . "</label><br>";
                        echo "<label>Cena biletu klasy biznesowej: " . $row["business_class"] . "</label><br>";
                        echo "<label>Cena biletu klasy ekonomicznej: " . $row["economy_class"] . "</label><br>";
                    }
                } else {
                    echo "Brak danych o locie";
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $username = $_SESSION['zalogowany']; 
                    $flight_id = $_GET['flight_id']; 
                    $purchase_date = date("Y-m-d"); 
                    $ticket_type = $_POST['ticket_type']; 
                    $passenger_count = $_POST['passenger_count']; 

    
    $sql = "INSERT INTO tickets (username, flight_id, purchase_date, Ticket_type)
    VALUES ";

   
    for ($i = 0; $i < $passenger_count; $i++) {
        $sql .= "('$username', '$flight_id', '$purchase_date', '$ticket_type'),";
    }
    $sql = rtrim($sql, ",");

}
            ?>
          <label for="passenger_count">Liczba pasażerów:</label>
<input type="number" id="passenger_count" name="passenger_count" min="1" value="1">
            <label for="ticket_type">Rodzaj biletu:</label>
            <select id="ticket_type" name="ticket_type">
                <option value="business_class">Business Class</option>
                <option value="economy_class">Economy Class</option>
            </select>

            <input type="submit" value="Kup">
        </form>
    <?php
  if ($conn->query($sql) === TRUE) {
        echo "Bilety zostały pomyślnie zakupione!";
    }
  ?>
    </div>
  <div class="footer">
  </div>
</body>
</html>
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFly</title>
    <link rel="stylesheet" type="text/css" href="Style/index.css">
  <link rel="icon" type="image/x-icon" href="logo.png">
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
                echo "<li><a href='profil.php'>".$_SESSION['zalogowany']."</a></li><li><a href='logout.php'>Wyloguj sie</a></li>";
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
    <div class="Search">
  <form method="post" action="">
    <label class="radio"><input type="radio" name="lot" value="odloty" checked><span>Odloty</span>
  </label>
  <label class="radio">
    <input type="radio" name="lot" value="przyloty" ><span>Przyloty</span>
  </label>
      <br>
      <label class="label">Wybierz kierunek</label>
    <select name="kierunek" class="input" id="input_form">
      <option value="" selected></option>
      <?php
     require_once "displaytable.php";
  
  $query="SELECT DISTINCT arrival_location FROM tour WHERE arrival_location <> 'Sosnowiec'";
  $result = $conn->query($query);
  while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['arrival_location'] . "'>" . $row['arrival_location'] . "</option>";
    }
  ?>
</select>
      <label class="label" >Data od</label>
      <input type="date" name="dataod" class="input" id="input_form"> 
      <label class="label" >Data do</label>
      <input type="date" name="datado" class="input" id="input_form">
      <label class="label" >Numer lotu</label>
      <input type="text" name="numer" class="input" id="input_form">
      <input type="submit" name="submit" id="submit" value="Pokaż wyniki" id="input_form">
    </form>
    </div>
    <?php
  
  if(isset($_POST['submit']))
  {
    $rodzajLotu = $_POST['lot'];
    $kierunek = $_POST['kierunek'];
    $dataod = $_POST['dataod'];
    $datado = $_POST['datado'];
    $numer = $_POST['numer'];
    
    $dzisiejszaData = date('Y-m-d H:i:s');
    
    if (empty($dataod)) {
    $dataod = $dzisiejszaData;
}
    
  $query = "SELECT flights.*, planes.name AS plane_name, planes.plane_id AS id_plane, planes.status AS plane_status, tour.departure_location,  tour.arrival_location
          FROM flights
          INNER JOIN planes ON flights.id_plane = planes.plane_id
          INNER JOIN tour ON flights.id_tour = tour.tour_id";


if ($rodzajLotu == "odloty") {
    $query .= " WHERE tour.departure_location = 'Sosnowiec'";
    if ($kierunek) {
        $query .= " AND tour.arrival_location = '$kierunek'";
    }
} elseif ($rodzajLotu == "przyloty") {
    $query .= " WHERE tour.arrival_location = 'Sosnowiec'";
    if ($kierunek) {
        $query .= " AND tour.departure_location = '$kierunek'";
    }
}


if ($dataod) {
    $query .= " AND flights.start > '$dataod'";
}

if ($datado) {
    $query .= " AND flights.start < '$datado'";
}


if ($numer) {
    $query .= " AND flights.flight_number = $numer";
}
     $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        echo "<h2>Wyniki wyszukiwania</h2>";
        echo "<table border='1'>";
        echo "<tr><th>" . ($rodzajLotu ? "odloty" : "przyloty") . "</th><th>Kierunek</th><th>Numer Lotu</th><th>" . ($rodzajLotu ? "Terminal" : "Gate") . "</th><th>Status</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            
            if ($rodzajLotu) {
                $time = date('H:i', strtotime($row['start']));
                echo "<td>" . $time . "</td>";
                echo "<td>" . $row['arrival_location'] . "</td>";
            } else {
                $time = date('H:i', strtotime($row['end']));
                echo "<td>" . $time . "</td>";
                echo "<td>" . $row['departure_location'] . "</td>";
            }
            
            echo "<td>" . $row['flight_number'] . "</td>";

            if ($rodzajLotu) {
                echo "<td>B-D</td>";
            } else {
                echo "<td>".$row['gate']."</td>";
            }

            if (strtotime($row['start']) < time()) {
                echo "<td>Leci</td>";
            } else {
                echo "<td>Oczekuje</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
  }
  }
  ?>
    
  </div>
  <div class="footer">
  </div>
</body>
</html>
<?php
require_once "db.php";

$currentDateTime = date('Y-m-d H:i:s');

// Zapytanie dla 5 najbliższych odlotów
$departures_sql = "SELECT flights.*, planes.name AS plane_name, planes.plane_id AS id_plane, planes.status AS plane_status, tour.departure_location,  tour.arrival_location
                    FROM flights
                    INNER JOIN planes ON flights.id_plane = planes.plane_id
                    INNER JOIN tour ON flights.id_tour = tour.tour_id
                    WHERE tour.departure_location = 'Sosnowiec' AND flights.start > '$currentDateTime'
                    ORDER BY flights.start ASC LIMIT 5";
$departures_result = $conn->query($departures_sql);

// Zapytanie dla 5 najbliższych przylotów
$arrivals_sql = "SELECT flights.*, planes.name AS plane_name, planes.plane_id AS id_plane, planes.status AS plane_status, tour.arrival_location, tour.departure_location
                    FROM flights
                    INNER JOIN planes ON flights.id_plane = planes.plane_id
                    INNER JOIN tour ON flights.id_tour = tour.tour_id
                    WHERE tour.arrival_location = 'Sosnowiec' AND flights.end > '$currentDateTime'
                    ORDER BY flights.end ASC LIMIT 5";
$arrivals_result = $conn->query($arrivals_sql);

// Funkcja wyświetlająca tabele dla odlotów i przylotów
function displayTable($result, $title, $isDepartureTable) {
    if ($result->num_rows > 0) {
        echo "<h2>Tablica $title</h2>";
        echo "<table>";
        echo "<tr><th>" . ($isDepartureTable ? "ODLOT" : "PRZYLOT") . "</th><th>KIERUNEK</th><th>NUMER LOTU</th><th>" . ($isDepartureTable ? "TERMINAL" : "GATE") . "</th><th>STATUS</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            
            if ($isDepartureTable) {
                $time = date('H:i', strtotime($row['start']));
                echo "<td>" . $time . "</td>";
                echo "<td>" . $row['arrival_location'] . "</td>";
            } else {
                $time = date('H:i', strtotime($row['end']));
                echo "<td>" . $time . "</td>";
                echo "<td>" . $row['departure_location'] . "</td>";
            }
            
            echo "<td>" . $row['flight_number'] . "</td>";

            if ($isDepartureTable) {
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
    } else {
        echo "<p>Brak wyników dla $title.</p>";
    }
}
?>
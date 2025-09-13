<?php

$servername = "mysql.ct8.pl";

$username = "m40342_marcosek";

$password = "Programista06";

$dbname = "m40342_IFly";



$conn = new mysqli($servername, $username, $password, $dbname);



if ($conn->connect_error) {

    die("Połączenie nie udane: " . $conn->connect_error);

}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

?>
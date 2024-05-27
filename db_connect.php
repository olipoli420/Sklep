<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "polaczenie";

// Tworzenie połączenia z bazą danych
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Sprawdzenie czy połączenie z bazą danych się udało
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}
?>
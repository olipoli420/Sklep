<?php
session_start();
require_once 'db_connect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$imie = $_POST['Imie'];
$nazwisko = $_POST['Nazwisko'];
$email = $_POST['Email'];
$telefon = $_POST['Telefon'];
$wiek = $_POST['Wiek'];
$username = mysqli_real_escape_string($conn,$username);
$password = mysqli_real_escape_string($conn,$password);
$imie = mysqli_real_escape_string($conn,$imie);
$nazwisko = mysqli_real_escape_string($conn,$nazwisko);
$email = mysqli_real_escape_string($conn,$email);
$telefon = mysqli_real_escape_string($conn,$telefon);
$wiek = mysqli_real_escape_string($conn,$wiek);
$query = "SELECT * FROM uzytkownicy WHERE login='$username'";
$query2 = "INSERT INTO uzytkownicy (`imie`, `nazwisko`, `email`, `telefon`, `wiek`, `login`, `haslo`) VALUES ('$imie','$nazwisko','$email','$telefon','$wiek','$username','$password')";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "Uzytkownik z taka nazwa juz istnieje <br>";
} else {
    $result2 = mysqli_query($conn, $query2);
    echo "Utworzono uzytkownika <br>";
    echo "<form action='index.html'>";
    echo "<input type='submit' value='Przejd do logowania'>";
    echo "</form>";
}
?>
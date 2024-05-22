<?php
session_start();

// Połączenie z bazą danych
require_once 'db_connect.php';

// Pobranie danych z formularza
$username = $_POST['username'];
$password = $_POST['password'];
// Zabezpieczenie przed atakami SQL Injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Zapytanie do bazy danych w celu sprawdzenia istnienia użytkownika
$query = "SELECT * FROM uzytkownicy WHERE login='$username' AND haslo='$password'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$id =$row['id'];
// Sprawdzenie czy istnieje użytkownik o podanych danych
if($row['Klasa']=="Admin")
{
    header('Location: Admin.php');
}
else
{
    if (mysqli_num_rows($result) == 1) 
    {
    // Użytkownik istnieje, zaloguj go
    $_SESSION['username'] = $username;
    header('Location: welcome.php'); // Przekierowanie do strony powitalnej
    } else 
    {
    // Użytkownik nie istnieje lub błędne dane logowania
    echo "Błędne dane logowania. Spróbuj ponownie.";
    }
}

?>
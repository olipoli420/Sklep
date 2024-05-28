<?php
session_start();

// Połączenie z bazą danych
require_once 'db_connect.php';

// Pobranie danych z formularza
$username = $_POST['username'];
$password = $_POST['password'];

// Zabezpieczenie przed atakami SQL Injection
$username = mysqli_real_escape_string($conn, $username);

// Zapytanie do bazy danych w celu sprawdzenia istnienia użytkownika
$query = "SELECT * FROM uzytkownicy WHERE login = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$_SESSION['id_klienta']=$row['id'];
// Sprawdzenie czy istnieje użytkownik o podanych danych
if ($row) {
    // Użytkownik istnieje, sprawdzenie hasła
    if (password_verify($password, $row['haslo'])) {
        // Hasło zgodne, logowanie użytkownika
        $_SESSION['username'] = $username;
        if ($row['Klasa'] == "Admin") {
            header('Location: Admin.php');
        } else {
            header('Location: welcome.php'); // Przekierowanie do strony powitalnej
        }
    } else {
        // Błędne hasło
        echo "Błędne hasło. Spróbuj ponownie.";
    }
} else {
    // Brak użytkownika o podanym loginie
    echo "Użytkownik nie istnieje. Spróbuj ponownie.";
}
?>

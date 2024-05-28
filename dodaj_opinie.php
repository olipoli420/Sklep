<?php
// Połączenie z bazą danych
require_once 'db_connect.php';

// Sprawdzenie, czy formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie danych z formularza
    $opinionContent = $_POST['opinionContent'];
    $ilosc_gwiazdek = $_POST['ilosc_gwiazdek'];
    $id_przedmiotu = $_POST['id_przedmiotu'];

    // Pobranie imienia i nazwiska klienta z bazy danych
    // Załóżmy, że użytkownik jest zalogowany i jego dane znajdują się w zmiennej sesyjnej
    session_start();
    $id_klienta = $_SESSION['id_klienta'];

    // Wstawienie nowej opinii do tabeli opiniePrzedmiotow
    $query = "INSERT INTO opiniePrzedmiotow (id_przedmiotu, id_klienta, il_gwiazdek, tresc, data) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iiis", $id_przedmiotu, $id_klienta, $ilosc_gwiazdek, $opinionContent);
    $success = mysqli_stmt_execute($stmt);

    // Sprawdzenie, czy dodanie opinii się powiodło
    if ($success) {
        header("Location: szczegoly.php?id_przedmiotu=$id_przedmiotu");
    } else {
        echo "Wystąpił błąd podczas dodawania opinii.";
    }

    // Zamknięcie połączenia
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Jeśli formularz nie został przesłany, wyświetl komunikat o błędzie
    echo "Nieprawidłowe żądanie.";
}
?>

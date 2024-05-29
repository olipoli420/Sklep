<?php
session_start();
require_once 'db_connect.php';

// Sprawdź, czy dane zostały przesłane poprzez metodę POST
if(isset($_POST['id_zamowienia'])) {
    // Pobierz id_zamowienia z formularza
    $id_zamowienia = $_POST['id_zamowienia'];
    if(!empty($id_zamowienia))
    {
        // Przygotuj zapytanie SQL
        $query = "UPDATE zamowieniaklientow SET Status=1 WHERE Id_zamowienia=?";

        // Przygotuj i wykonaj zapytanie SQL
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_zamowienia);

        // Sprawdź, czy zapytanie zostało wykonane poprawnie
        if(mysqli_stmt_execute($stmt)) {
            // Sprawdź, czy zapytanie zostało wykonane poprawnie i zmodyfikowano jakieś rekordy
            if(mysqli_stmt_affected_rows($stmt) > 0) {
                // Zapytanie zmodyfikowało co najmniej jeden rekord
                header('Location: admin.php');
                exit;
            } else {
                // Zapytanie nie zmodyfikowało żadnego rekordu
                echo "Błąd: Nie udało się zaktualizować rekordów.";
            }

        } else {
            // Jeśli wystąpił błąd, wyświetl komunikat
            echo "Błąd podczas wykonywania zapytania SQL: " . mysqli_error($conn);
        }        
    }
    else
    {
        print "Zmienna jest pusta";
    }

} else {
    // Jeśli dane nie zostały przesłane, wyświetl komunikat
    echo "Nie przesłano danych";
}
?>

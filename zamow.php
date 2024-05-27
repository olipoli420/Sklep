<?php
session_start();
require_once 'db_connect.php';  

if (!empty($_POST['Miejscowosc']) && !empty($_POST['Ulica']) && !empty($_POST['Adres']) && !empty($_POST['Kod_pocztowy'])) {
    if (isset($_POST['Miejscowosc']) && isset($_POST['id_uzytkownika']) && isset($_POST['nazwa_tabeli'])) {
        $id_uzytkownika = $_POST['id_uzytkownika'];
        $tableName = $_POST['nazwa_tabeli'];
        $suma = 0;

        // Pobieranie sumy kwoty
        $query = "SELECT * FROM $tableName";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $query2 = "SELECT * FROM przedmioty WHERE id_przedmiotu= ?";
            $stmt2 = mysqli_prepare($conn, $query2);
            mysqli_stmt_bind_param($stmt2, "i", $row['id_przedmiotu']);
            mysqli_stmt_execute($stmt2);
            $result2 = mysqli_stmt_get_result($stmt2);
            $row2 = mysqli_fetch_assoc($result2);
            $suma += ($row['ilosc'] * $row2['cena']);
        }

        // Dodawanie nowego zamówienia
        $queryZamowienieK = "INSERT INTO zamowieniaklientow (id_uzytkownika, Laczna_Kwota) VALUES (?, ?)";
        $stmtZamowienieK = mysqli_prepare($conn, $queryZamowienieK);
        mysqli_stmt_bind_param($stmtZamowienieK, "ii", $id_uzytkownika, $suma);
        mysqli_stmt_execute($stmtZamowienieK);
        $lastInsertedId = mysqli_insert_id($conn);

        // Dodawanie zamówionych przedmiotów
        $query = "SELECT * FROM $tableName";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $queryZamowienieP = "INSERT INTO zamowioneprzedmioty (Id_zamowienia, id_przedmiotu, ilosc) VALUES (?, ?, ?)";
            $stmtZamowienieP = mysqli_prepare($conn, $queryZamowienieP);
            mysqli_stmt_bind_param($stmtZamowienieP, "iii", $lastInsertedId, $row['id_przedmiotu'], $row['ilosc']);
            mysqli_stmt_execute($stmtZamowienieP);

            // Aktualizacja stanu przedmiotu
            $queryUsuwanieZeStanu = "UPDATE przedmioty SET ilosc = ilosc - ? WHERE id_przedmiotu = ?";
            $stmtUsuwanieZeStanu = mysqli_prepare($conn, $queryUsuwanieZeStanu);
            mysqli_stmt_bind_param($stmtUsuwanieZeStanu, "ii", $row['ilosc'], $row['id_przedmiotu']);
            mysqli_stmt_execute($stmtUsuwanieZeStanu);
        }

        // Usuwanie z koszyka
        $queryUsuwanieKoszyka = "DELETE FROM $tableName";
        $stmtUsuwannieKoszyka = mysqli_prepare($conn, $queryUsuwanieKoszyka);
        mysqli_stmt_execute($stmtUsuwannieKoszyka);

        // Dodawanie danych dostawy
        $miejscowosc = $_POST['Miejscowosc'];
        $ulica = $_POST['Ulica'];
        $adres = $_POST['Adres'];
        $kod_pocztowy = $_POST['Kod_pocztowy'];
        $queryDostawy = "INSERT INTO dostawy (id_zamowienia, Miejscowosc, Ulica, Adres, Kod_pocztowy) VALUES (?, ?, ?, ?, ?)";
        $stmtDostawy = mysqli_prepare($conn, $queryDostawy);
        mysqli_stmt_bind_param($stmtDostawy, "issss", $lastInsertedId, $miejscowosc, $ulica, $adres, $kod_pocztowy);
        mysqli_stmt_execute($stmtDostawy);

        header("Location: PokazKoszyk.php");
    } else {
        echo "Dane POST nie zostały przesłane.";
    }
} else {
    echo "Nie podano danych";
}
?>

<?php
session_start();
require_once 'db_connect.php';  

// Sprawdzenie, czy przesłano dane z formularza
if (!empty($_POST['adres'])) {
    // Przypisanie danych z formularza do zmiennych
    $adres_id = $_POST['adres'];
    $id_uzytkownika = $_SESSION['id_klienta'];
    $tableName = isset($_SESSION['tableName']) ? $_SESSION['tableName'] : '';
    
    // Pobranie sumy kwoty zamówienia
    $suma = 0;
    $querySuma = "SELECT SUM(przedmioty.cena * $tableName.ilosc) AS suma 
    FROM przedmioty 
    INNER JOIN $tableName ON przedmioty.id_przedmiotu = $tableName.id_przedmiotu";
    $resultSuma = mysqli_query($conn, $querySuma);
    $rowSuma = mysqli_fetch_assoc($resultSuma);
    $suma = $rowSuma['suma'];
    
    // Dodanie nowego zamówienia
    $queryZamowienie = "INSERT INTO zamowieniaklientow (id_uzytkownika, id_adresu, Laczna_Kwota) VALUES (?, ?, ?)";
    $stmtZamowienie = mysqli_prepare($conn, $queryZamowienie);
    mysqli_stmt_bind_param($stmtZamowienie, "iii", $id_uzytkownika, $adres_id, $suma);
    mysqli_stmt_execute($stmtZamowienie);
    $lastInsertedId = mysqli_insert_id($conn);
    
    // Pobranie danych o produktach z koszyka
    $queryProdukty = "SELECT * FROM $tableName";
    $resultProdukty = mysqli_query($conn, $queryProdukty);
    
    // Dodanie zamówionych przedmiotów
    while ($row = mysqli_fetch_assoc($resultProdukty)) {
        $queryZamowieniePrzedmioty = "INSERT INTO zamowioneprzedmioty (Id_zamowienia, id_przedmiotu, ilosc) VALUES (?, ?, ?)";
        $stmtZamowieniePrzedmioty = mysqli_prepare($conn, $queryZamowieniePrzedmioty);
        mysqli_stmt_bind_param($stmtZamowieniePrzedmioty, "iii", $lastInsertedId, $row['id_przedmiotu'], $row['ilosc']);
        mysqli_stmt_execute($stmtZamowieniePrzedmioty);
        
        // Aktualizacja stanu przedmiotu
        $queryAktualizacjaStanu = "UPDATE przedmioty SET ilosc = ilosc - ? WHERE id_przedmiotu = ?";
        $stmtAktualizacjaStanu = mysqli_prepare($conn, $queryAktualizacjaStanu);
        mysqli_stmt_bind_param($stmtAktualizacjaStanu, "ii", $row['ilosc'], $row['id_przedmiotu']);
        mysqli_stmt_execute($stmtAktualizacjaStanu);
    }
    
    // Wyczyszczenie koszyka
    $queryCzyszczenieKoszyka = "DELETE FROM $tableName";
    $stmtCzyszczenieKoszyka = mysqli_prepare($conn, $queryCzyszczenieKoszyka);
    mysqli_stmt_execute($stmtCzyszczenieKoszyka);
    
    header("Location: PokazKoszyk.php");
} else {
    echo "Nie wybrano adresu dostawy.";
}
?>

<?php
session_start();
require_once 'db_connect.php';  

// Sprawdzenie, czy przesłano dane z formularza
if (!empty($_POST['miejscowosc']) && !empty($_POST['ulica']) && !empty($_POST['adres']) && !empty($_POST['kod_pocztowy'])) {
    // Przypisanie danych z formularza do zmiennych
    $miejscowosc = $_POST['miejscowosc'];
    $ulica = $_POST['ulica'];
    $adres = $_POST['adres'];
    $kod_pocztowy = $_POST['kod_pocztowy'];
    
    // Pobranie id zalogowanego użytkownika
    $id_uzytkownika = $_SESSION['id_uzytkownika'];
    
    // Sprawdzenie czy adres już istnieje w bazie
    $querySprAdres = "SELECT * FROM adresy WHERE id_klienta=? AND Miejscowosc=? AND Ulica=? AND Adres=? AND Kod_pocztowy=?";
    $stmtSprAdres = mysqli_prepare($conn, $querySprAdres);
    mysqli_stmt_bind_param($stmtSprAdres, "issss", $id_uzytkownika, $miejscowosc, $ulica, $adres, $kod_pocztowy);
    mysqli_stmt_execute($stmtSprAdres);
    $resultSprAdres = mysqli_stmt_get_result($stmtSprAdres);
    
    if(mysqli_num_rows($resultSprAdres) > 0) {
        echo "Adres już istnieje w bazie danych.";
    } else {
        // Dodanie adresu do bazy danych
        $queryAdres = "INSERT INTO adresy (id_klienta, Miejscowosc, Ulica, Adres, Kod_pocztowy) VALUES (?, ?, ?, ?, ?)";
        $stmtAdres = mysqli_prepare($conn, $queryAdres);
        mysqli_stmt_bind_param($stmtAdres, "issss", $id_uzytkownika, $miejscowosc, $ulica, $adres, $kod_pocztowy);
        mysqli_stmt_execute($stmtAdres);
        
        header('Location: KlientZamowienia.php');
    }
} else {
    echo "Wypełnij wszystkie pola formularza.";
}
?>

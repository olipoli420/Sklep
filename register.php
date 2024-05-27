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
$password = password_hash($password, PASSWORD_DEFAULT);
$imie = mysqli_real_escape_string($conn,$imie);
$nazwisko = mysqli_real_escape_string($conn,$nazwisko);
$email = mysqli_real_escape_string($conn,$email);
$telefon = mysqli_real_escape_string($conn,$telefon);
$wiek = mysqli_real_escape_string($conn,$wiek);
$query = "SELECT * FROM uzytkownicy WHERE login= ?";
$stmt=mysqli_prepare($conn,$query);
mysqli_stmt_bind_param($stmt,"s",$username);
mysqli_stmt_execute($stmt);
$query2 = "INSERT INTO uzytkownicy (`imie`, `nazwisko`, `email`, `telefon`, `wiek`, `login`, `haslo`) VALUES (?,?,?,?,?,?,?)";
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) > 0) {
    echo "Uzytkownik z taka nazwa juz istnieje <br>";
} else {
    $stmt2=mysqli_prepare($conn,$query2);
    mysqli_stmt_bind_param($stmt2,"ssssiss",$imie,$nazwisko,$email,$telefon,$wiek,$username,$password);
    mysqli_stmt_execute($stmt2);
    $query3="SELECT * FROM uzytkownicy WHERE login=?";
    $stmt3=mysqli_prepare($conn,$query3);
    mysqli_stmt_bind_param($stmt3,"s",$username);
    mysqli_stmt_execute($stmt3);
    $result3=mysqli_stmt_get_result($stmt3);
    $row3=mysqli_fetch_assoc($result3);
    $tableName="koszyk".$row3['id'];
    $querytworzenie="CREATE TABLE $tableName (
        id_przedmiotu INT,
        ilosc INT,
        FOREIGN KEY (id_przedmiotu) REFERENCES przedmioty(id_przedmiotu)
    );";
    mysqli_query($conn,$querytworzenie);
    echo "Utworzono uzytkownika <br>";
    echo "<form action='index.html'>";
    echo "<input type='submit' value='Przejd do logowania'>";
    echo "</form>";
}
?>
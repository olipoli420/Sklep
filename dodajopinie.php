<?php
session_start();
require_once 'db_connect.php';



$imie = mysqli_real_escape_string($conn, $_POST['imie']);
$tekst = mysqli_real_escape_string($conn, $_POST['recenzja']);
$stars = intval($_POST['stars']);

$query = "INSERT INTO opinie (Imie, tekst,gwiazdki) VALUES (?, ?,?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt,"ssi",$imie,$tekst,$stars);
mysqli_stmt_execute($stmt);
if ($stmt) 
{
    header("Location: opinie.php");
    exit();
} else 
{
       print "błąd polecenia";
}
?>

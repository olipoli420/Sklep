<?php
session_start();
require_once 'db_connect.php';



$imie = mysqli_real_escape_string($conn, $_POST['imie']);
$tekst = mysqli_real_escape_string($conn, $_POST['recenzja']);
$stars = intval($_POST['stars']);

$query = "INSERT INTO opinie (Imie, tekst,gwiazdki) VALUES ('$imie', '$tekst','$stars')";

 
if (mysqli_query($conn, $query)) 
{
    header("Location: opinie.php");
    exit();
} else 
{
       print "błąd polecenia";
}
?>

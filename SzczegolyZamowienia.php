<?php
session_start();
require_once 'db_connect.php';
$id_zamowienia=$_POST['id_zamowienia'];
$query="SELECT * FROM zamowieniaklientow WHERE Id_zamowienia= ?";
$stmt=mysqli_prepare($conn,$query);
mysqli_stmt_bind_param($stmt,"i",$id_zamowienia);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
$row=mysqli_fetch_assoc($result);
$query1="SELECT * FROM uzytkownicy WHERE id= ?";
$stmt1=mysqli_prepare($conn,$query1);
mysqli_stmt_bind_param($stmt1,"i",$row['id_uzytkownika']);
mysqli_stmt_execute($stmt1);
$result1=mysqli_stmt_get_result($stmt1);
$row1=mysqli_fetch_assoc($result1);
print "Szczegoly zamowienia o ID= ".$id_zamowienia."<br>";
print "Dane uzytkownika zamawiajacego: <br>";
print "<b>ID: </b>".$row1['id']."<b> Imie: </b>".$row1['imie']."<b> Nazwisko: </b>".$row1['nazwisko']."<b> email: </b>".$row1['email']." <b>telefon: </b>".$row1['telefon']." <b>wiek: </b>".$row1['wiek']." <b>login: </b>".$row1['login'];
print "<form action='ZobaczZamowienia.php'>";
print "<input type='submit' value='Cofnij'>";
print "</form>";

?>
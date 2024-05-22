<?php
session_start();
require_once 'db_connect.php';
$id_zamowienia=$_POST['id_zamowienia'];
$query="SELECT * FROM zamowieniaklientow WHERE Id_zamowienia=".$id_zamowienia;
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_assoc($result);
$query1="SELECT * FROM uzytkownicy WHERE id=".$row['id_uzytkownika'];
$result1=mysqli_query($conn,$query1);
$row1=mysqli_fetch_assoc($result1);
print "Szczegoly zamowienia o ID= ".$id_zamowienia."<br>";
print "Dane uzytkownika zamawiajacego: <br>";
print "<b>ID: </b>".$row1['id']."<b> Imie: </b>".$row1['imie']."<b> Nazwisko: </b>".$row1['nazwisko']."<b> email: </b>".$row1['email']." <b>telefon: </b>".$row1['telefon']." <b>wiek: </b>".$row1['wiek']." <b>login: </b>".$row1['login'];
print "<form action='ZobaczZamowienia.php'>";
print "<input type='submit' value='Cofnij'>";
print "</form>";

?>
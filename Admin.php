<?php
session_start();
require_once 'db_connect.php';
print "<form action='DodajProdukt.php' method='POST'>";
print "<input type='submit' value='DODAJ PRODUKT'>";
print "</form>";
print "<form action='UsunProdukt.php' method='POST'>";
print "<input type='submit' value='USUN PRODUKT'>";
print "</form>";
print "<form action='ZobaczZamowienia.php' method='POST'>";
print "<input type='submit' value='ZOBACZ ZAMOWIENIA'>";
print "</form>";
?>

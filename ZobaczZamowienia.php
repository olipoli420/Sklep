<?php
session_start();
require_once 'db_connect.php';
$query="SELECT * FROM zamowieniaklientow";
$result=mysqli_query($conn,$query);
while($row=mysqli_fetch_assoc($result))
{
    print "<form action='SzczegolyZamowienia.php' method='POST'>";
    print "Zamowienie o ID= ".$row['Id_zamowienia']." <input type='submit' value=\"Szczegóły Zamowienia\"> <input type='hidden' name='id_zamowienia' value='".$row['Id_zamowienia']."'<br>";
    print "</form>";
    $query2="SELECT * FROM zamowioneprzedmioty WHERE Id_zamowienia=".$row['Id_zamowienia'];
    $result2=mysqli_query($conn,$query2);
    print "<table border=1>";
    print "<tr><td>Nazwa</td><td>Ilosc</td></tr>";
    while($row2=mysqli_fetch_assoc($result2))
    {
        $query3="SELECT * FROM przedmioty WHERE id_przedmiotu=".$row2['id_przedmiotu'];
        $result3=mysqli_query($conn,$query3);
        $row3=mysqli_fetch_assoc($result3);
        print "<tr><td>".$row3['nazwa']."</td><td>".$row2['ilosc']."</td></tr>";
    }
    print "</table>";
}
?>
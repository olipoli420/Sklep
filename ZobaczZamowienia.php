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
    $query2="SELECT * FROM zamowioneprzedmioty WHERE Id_zamowienia=?";
    $stmt2=mysqli_prepare($conn,$query2);
    mysqli_stmt_bind_param($stmt2,"i",$row['Id_zamowienia']);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2); 
    print "<table border=1>";
    print "<tr><td>Nazwa</td><td>Ilosc</td></tr>";
    while($row2=mysqli_fetch_assoc($result2))
    {
        $query3="SELECT * FROM przedmioty WHERE id_przedmiotu= ?";
        $stmt3= mysqli_prepare($conn,$query3);
        mysqli_stmt_bind_param($stmt3,"i",$row2['id_przedmiotu']);
        mysqli_stmt_execute($stmt3);
        $result3=mysqli_stmt_get_result($stmt3);
        $row3=mysqli_fetch_assoc($result3);
        print "<tr><td>".$row3['nazwa']."</td><td>".$row2['ilosc']."</td></tr>";
    }
    print "</table>";
}
?>
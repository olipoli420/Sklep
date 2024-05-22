<?php
session_start();
require_once 'db_connect.php';
$id_przedmiotu=$_POST['id_przedmiotu'];
$tableName=$_POST['nazwa_tabeli'];
$query2="SELECT * FROM przedmioty WHERE id_przedmiotu=$id_przedmiotu";
$result2=mysqli_query($conn,$query2);
$query3="SELECT * FROM $tableName WHERE id_przedmiotu = $id_przedmiotu";
$result3=mysqli_query($conn,$query3);
$row3=mysqli_fetch_assoc($result3);
$row2=mysqli_fetch_assoc($result2);
if($row2['ilosc']==$row3['ilosc'])
{

}
else
{
    $query="UPDATE $tableName SET ilosc = ilosc + 1 where id_przedmiotu=$id_przedmiotu";
    mysqli_query($conn,$query);
}

header("Location: PokazKoszyk.php");
?>
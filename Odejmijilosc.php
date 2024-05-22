<?php
session_start();
require_once 'db_connect.php';
$id_przedmiotu=$_POST['id_przedmiotu'];
$tableName=$_POST['nazwa_tabeli'];
$query="UPDATE $tableName SET ilosc = ilosc - 1 where id_przedmiotu=$id_przedmiotu";
mysqli_query($conn,$query);
$query2="SELECT * FROM $tableName WHERE id_przedmiotu=$id_przedmiotu";
$result2=mysqli_query($conn,$query2);
$row2=mysqli_fetch_assoc($result2);
if($row2['ilosc']==0)
{
    $query3="DELETE FROM $tableName WHERE id_przedmiotu= $id_przedmiotu";
    mysqli_query($conn,$query3);
}

header("Location: PokazKoszyk.php");
?>
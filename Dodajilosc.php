<?php
session_start();
require_once 'db_connect.php';
$id_przedmiotu=$_POST['id_przedmiotu'];
$tableName=$_POST['nazwa_tabeli'];
$query2="SELECT * FROM przedmioty WHERE id_przedmiotu=?";
$stmt2 = mysqli_prepare($conn, $query2);
mysqli_stmt_bind_param($stmt2, "i", $id_przedmiotu);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);
$query3="SELECT * FROM $tableName WHERE id_przedmiotu = ?";
$stmt3= mysqli_prepare($conn, $query3);
mysqli_stmt_bind_param($stmt3,"i", $id_przedmiotu);
mysqli_stmt_execute($stmt3);
$result3=mysqli_stmt_get_result($stmt3);
$row3=mysqli_fetch_assoc($result3);
$row2=mysqli_fetch_assoc($result2);
if($row2['ilosc']==$row3['ilosc'])
{

}
else
{
    $query="UPDATE $tableName SET ilosc = ilosc + 1 where id_przedmiotu= ?";
    $stmt= mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"i", $id_przedmiotu);
    mysqli_stmt_execute($stmt);
}

header("Location: PokazKoszyk.php");
?>
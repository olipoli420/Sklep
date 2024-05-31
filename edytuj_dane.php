<?php
session_start();
require_once 'db_connect.php';
$id=$_POST['id'];
$mail=$_POST['email'];
$telefon=$_POST['telefon'];
if(!empty($mail))
{
    $queryUpdateM="UPDATE uzytkownicy SET email=? WHERE id=?";
    $stmtUpdateM=mysqli_prepare($conn,$queryUpdateM);
    mysqli_stmt_bind_param($stmtUpdateM,"si",$mail,$id);
    mysqli_stmt_execute($stmtUpdateM);
}
if(!empty($telefon))
{
    $queryUpdateT="UPDATE uzytkownicy SET telefon=? WHERE id=?";
    $stmtUpdateT=mysqli_prepare($conn,$queryUpdateT);
    mysqli_stmt_bind_param($stmtUpdateT,"si",$telefon,$id);
    mysqli_stmt_execute($stmtUpdateT);
}
header('Location: konto.php')
?>
<?php
session_start();
require_once 'db_connect.php';
$id_przedmiotu=$_POST['id_przedmiotu'];
$ilosc=$_POST['ilosc'];
$queryUpdate="UPDATE przedmioty SET ilosc=ilosc + ? WHERE id_przedmiotu=?";
$stmtUpdate=mysqli_prepare($conn,$queryUpdate);
mysqli_stmt_bind_param($stmtUpdate,"ii",$ilosc,$id_przedmiotu);
mysqli_stmt_execute($stmtUpdate);
header('Location: admin.php');
?>
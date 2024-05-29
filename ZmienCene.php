<?php
session_start();
require_once 'db_connect.php';
$id=$_POST['id'];
$cena=$_POST['cena'];
$queryUpdate="UPDATE przedmioty SET cena=? WHERE id_przedmiotu=?";
$stmtUpdate=mysqli_prepare($conn,$queryUpdate);
mysqli_stmt_bind_param($stmtUpdate,"di",$cena,$id);
mysqli_stmt_execute($stmtUpdate);
header('Location: admin.php');
?>
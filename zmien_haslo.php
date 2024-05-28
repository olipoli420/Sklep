<?php
session_start();
require_once 'db_connect.php';
$username = $_SESSION['username'];
$old_password=$_POST['old_password'];
$new_password=$_POST['new_password'];
$query="SELECT * FROM uzytkownicy WHERE id=?";
$stmt=mysqli_prepare($conn,$query);
mysqli_stmt_bind_param($stmt,"i",$_SESSION['id_klienta']);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
$row=mysqli_fetch_assoc($result);
if(password_verify($old_password,$row['haslo']))
{
    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
    $queryUpdate="UPDATE uzytkownicy SET haslo=? WHERE id=?";
    $stmtUpdate=mysqli_prepare($conn,$queryUpdate);
    mysqli_stmt_bind_param($stmtUpdate,"si",$new_password,$_SESSION['id_klienta']);
    mysqli_stmt_execute($stmtUpdate);
    $_SESSION['password_changed'] = true;
    header('Location: konto.php');
}
else
{
    $_SESSION['password_changed'] = false;
    header('Location: konto.php');
}
?>
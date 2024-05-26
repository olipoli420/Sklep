<?php
    session_start();
    require_once 'db_connect.php';
    $id_przedmiotu = $_POST['id_przedmiotu'];
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query3="SELECT id FROM uzytkownicy WHERE login=?";
    $stmt3=mysqli_prepare($conn,$query3);
    mysqli_stmt_bind_param($stmt3,"s",$username);
    mysqli_stmt_execute($stmt3);
    $result3=mysqli_stmt_get_result($stmt3);
    $row3=mysqli_fetch_assoc($result3);
    $tableName="Koszyk".$row3['id'];
    $query="DELETE FROM $tableName WHERE id_przedmiotu= ?";
    $stmt=mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"i",$id_przedmiotu);
    mysqli_stmt_execute($stmt);
    header("Location: PokazKoszyk.php");
?>
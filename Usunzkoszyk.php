<?php
    session_start();
    require_once 'db_connect.php';
    $id_przedmiotu = $_POST['id_przedmiotu'];
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query3="SELECT id FROM uzytkownicy WHERE login='$username'";
    $result3=mysqli_query($conn, $query3);
    $row3=mysqli_fetch_assoc($result3);
    $tableName="Koszyk".$row3['id'];
    $query="DELETE FROM $tableName WHERE id_przedmiotu= $id_przedmiotu";
    mysqli_query($conn,$query);
    header("Location: PokazKoszyk.php");
?>
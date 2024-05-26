<?php
    session_start();
    require_once 'db_connect.php';
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="styles.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
    <h1>Koszyk</h1>
</header>

<nav>
    <ul>
        <li><a href="#">Strona główna</a></li>
        <li><a href="welcome.php">Produkty</a></li>
        <li><a href="PokazKoszyk.php">Koszyk</a></li>
        <li><a href="konto.php">Konto</a></li>
        <li><a href="opinie.php">Opinie</a></li>
        <li><a href="#">Kontakt</a></li>
    </ul>
</nav>
<?php
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query3="SELECT id FROM uzytkownicy WHERE login= ?";
    $stmt3=mysqli_prepare($conn,$query3);
    mysqli_stmt_bind_param($stmt3,"s",$username);
    mysqli_stmt_execute($stmt3);
    $result3=mysqli_stmt_get_result($stmt3);
    $row3=mysqli_fetch_assoc($result3);
    $tableName="Koszyk".$row3['id'];
    $id_uzytkownika = $row3['id'];
    $id=$row3['id'];
    $query="SELECT * FROM ?";
    $stmt=mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"s",$tableName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
if(mysqli_num_rows($result)==0)
{
 print "<H1>Twoj koszyk jest pusty </H1>";
}
else
{
print "<div class='container mt-5'>";
    print "<table class='table table-striped'><tr><th scope='col'>Nazwa</th><th scope='col'></th><th scope='col'>Cena</th><th scope='col'>Ilosc</th><th scope='col'></th><th scope='col'>Dostępne sztuki</th></tr>";
    while($row=mysqli_fetch_assoc($result))
    {
        $query2="SELECT * FROM przedmioty WHERE id_przedmiotu = ?";
        $stmt2=mysqli_prepare($conn,$query2);
        mysqli_stmt_bind_param($stmt2,"i",$row['id_przedmiotu']);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $row2=mysqli_fetch_assoc($result2);
        $nazwa_tabeli = $tableName;
        print "<tr><th scope='row'>".$row2['nazwa']."</th><td><img src='".$row2['sciezka']."' alt='rysunek' class='img-fluid w-25'></td><td>".$row2['cena']."</td><td>".$row['ilosc']."</td>";
        print "<td><div class=\"Strzalki\">";
        print "<form action=\"Dodajilosc.php\" method=\"POST\"><input type=\"submit\" value=\"▲\" class='btn btn-secondary'><input type='hidden' name='id_przedmiotu' value='" . $row['id_przedmiotu'] . "'><input type='hidden' name='nazwa_tabeli' value='" . $nazwa_tabeli . "'><input type='hidden' name='id_uzytkownika' value='" . $id_uzytkownika . "'></form>";
        print "<form action=\"Odejmijilosc.php\" method=\"POST\"><input type=\"submit\" value=\"▼\" class='btn btn-secondary'><input type='hidden' name='id_przedmiotu' value='" . $row['id_przedmiotu'] . "'><input type='hidden' name='nazwa_tabeli' value='" . $nazwa_tabeli . "'><input type='hidden' name='id_uzytkownika' value='" . $id_uzytkownika . "'></form>";
        print "</div></td><td>".$row2['ilosc']."</td><td><form action='Usunzkoszyk.php' method='post'><input type='submit' value='Usun' class='btn btn-secondary'><input type='hidden' name='id_przedmiotu' value='" . $row2['id_przedmiotu'] . "'></form></td></tr>";
    }
    print "</table>";
    print "</div>";
    print "<div class='container mt-5' style='display: flex;'>";
    print "<div class='div1' style='flex: 1;'>";
    Print "<form action='welcome.php'><input type=submit value='Cofnij do zakupow' class='btn btn-primary'></form>";
    print "</div>";
    print "<div class='div2' style='flex: 1; margin-left: auto;'>";
    print "<form action=\"KlientZamowienia.php\" method=\"POST\"><input type=\"submit\" value='Zamów' class='btn btn-primary'> <input type='hidden' name='nazwa_tabeli' value='" .$tableName. "'><input type='hidden' name='id_uzytkownika' value='".$id."'></form>";
    print "</div>";
    print "</div>";
}

?>
</body>
</html>
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
        <li><a href="#">Kontakt</a></li>
    </ul>
</nav>
<?php
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query3="SELECT id FROM uzytkownicy WHERE login='$username'";
    $result3=mysqli_query($conn, $query3);
    $row3=mysqli_fetch_assoc($result3);
    $tableName="Koszyk".$row3['id'];
    $id_uzytkownika = $row3['id'];
    $id=$row3['id'];
    $query="SELECT * FROM ".$tableName;
    $result = mysqli_query($conn, $query);
if(mysqli_num_rows($result)==0)
{
 print "<H1>Twoj koszyk jest pusty </H1>";
}
else
{
    print "<table border=1 class='table'><tr><th scope='col'>Nazwa</th><th scope='col'>Cena</th><th scope='col'>Ilosc</th><th scope='col'></th><th scope='col'>Dostępne sztuki</th></tr>";
    while($row=mysqli_fetch_assoc($result))
    {
        $query2="SELECT * FROM przedmioty WHERE id_przedmiotu = ".$row['id_przedmiotu']."";
        $result2 = mysqli_query($conn, $query2);
        $row2=mysqli_fetch_assoc($result2);
        $nazwa_tabeli = $tableName;
        print "<tr><th scope='row'>".$row2['nazwa']."</th><td>".$row2['cena']."</td><td>".$row['ilosc']."</td>";
        print "<td><div class=\"Strzalki\">";
        print "<form action=\"Dodajilosc.php\" method=\"POST\"><input type=\"submit\" value=\"▲\" class='btn btn-secondary'><input type='hidden' name='id_przedmiotu' value='" . $row['id_przedmiotu'] . "'><input type='hidden' name='nazwa_tabeli' value='" . $nazwa_tabeli . "'><input type='hidden' name='id_uzytkownika' value='" . $id_uzytkownika . "'></form>";
        print "<form action=\"Odejmijilosc.php\" method=\"POST\"><input type=\"submit\" value=\"▼\" class='btn btn-secondary'><input type='hidden' name='id_przedmiotu' value='" . $row['id_przedmiotu'] . "'><input type='hidden' name='nazwa_tabeli' value='" . $nazwa_tabeli . "'><input type='hidden' name='id_uzytkownika' value='" . $id_uzytkownika . "'></form>";
        print "</div></td><td>".$row2['ilosc']."</td><td><form action='Usunzkoszyk.php' method='post'><input type='submit' value='Usun' class='btn btn-secondary'><input type='hidden' name='id_przedmiotu' value='" . $row2['id_przedmiotu'] . "'></form></td></tr>";
    }
    print "</table>";
    Print "<form action='welcome.php'><input type=submit value='Cofnij do zakupow' class='btn btn-primary'></form>";
    print "<form action=\"KlientZamowienia.php\" method=\"POST\"><input type=\"submit\" value='Zamów' class='btn btn-primary'> <input type='hidden' name='nazwa_tabeli' value='" .$tableName. "'><input type='hidden' name='id_uzytkownika' value='".$id."'></form>";
}

?>
</body>
</html>
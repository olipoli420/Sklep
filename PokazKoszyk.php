<?php
    session_start();
    require_once 'db_connect.php';
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
</head>
<body>
<header>
    <h1>Koszyk</h1>
</header>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="welcome.php">Sklep</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="welcome.php">Przedmioty</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="PokazKoszyk.php">Koszyk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="opinie.php">Opinie</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="konto.php"><i class="bi bi-person-circle"></i> konto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logaut.php"><i class="bi bi-box-arrow-left"></i> Wyloguj</a>
                </li>
            </ul>
        </div>
    </div>
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
    $query="SELECT * FROM $tableName";
    $stmt=mysqli_prepare($conn,$query);
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
        print "<form action=\"Dodajilosc.php\" method=\"POST\"><input type=\"submit\" value=\"▲\" class='btn btn-outline-info'><input type='hidden' name='id_przedmiotu' value='" . $row['id_przedmiotu'] . "'><input type='hidden' name='nazwa_tabeli' value='" . $nazwa_tabeli . "'><input type='hidden' name='id_uzytkownika' value='" . $id_uzytkownika . "'></form>";
        print "<form action=\"Odejmijilosc.php\" method=\"POST\"><input type=\"submit\" value=\"▼\" class='btn btn-outline-info'><input type='hidden' name='id_przedmiotu' value='" . $row['id_przedmiotu'] . "'><input type='hidden' name='nazwa_tabeli' value='" . $nazwa_tabeli . "'><input type='hidden' name='id_uzytkownika' value='" . $id_uzytkownika . "'></form>";
        print "</div></td><td>".$row2['ilosc']."</td><td><form action='Usunzkoszyk.php' method='post'><input type='submit' value='Usun' class='btn btn-outline-danger'><input type='hidden' name='id_przedmiotu' value='" . $row2['id_przedmiotu'] . "'></form></td></tr>";
    }
    print "</table>";
    print "</div>";
    print "<div class='container mt-5' style='display: flex;'>";
    print "<div class='div1' style='flex: 1;'>";
    Print "<form action='welcome.php'><input type=submit value='Cofnij do zakupow' class='btn btn-outline-primary'></form>";
    print "</div>";
    print "<div class='div2' style='flex: 1; margin-left: auto;'>";
    print "<form action=\"KlientZamowienia.php\" method=\"POST\"><input type=\"submit\" value='Zamów' class='btn btn-outline-success'> <input type='hidden' name='nazwa_tabeli' value='" .$tableName. "'><input type='hidden' name='id_uzytkownika' value='".$id."'></form>";
    print "</div>";
    print "</div>";
}

?>
</body>
</html>
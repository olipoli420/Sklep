<?php
session_start();
require_once 'db_connect.php';
$zmiana = isset($_SESSION['zmiana']) ? $_SESSION['zmiana'] : false;
if(isset($_POST['Cena']))
{
    $zmiana=!$zmiana;
    $_SESSION['zmiana'] = $zmiana;
}
$sortz = isset($_POST['sortowanie']) ? $_POST['sortowanie'] : 'IloscM';

$queryZamowienia = "SELECT zamowieniaklientow.Id_zamowienia,zamowieniaklientow.id_adresu,uzytkownicy.login,uzytkownicy.id, adresy.Miejscowosc, zamowieniaklientow.Data, zamowieniaklientow.Laczna_Kwota, zamowieniaklientow.Status FROM zamowieniaklientow JOIN uzytkownicy ON zamowieniaklientow.id_uzytkownika=uzytkownicy.id JOIN adresy ON zamowieniaklientow.id_adresu=adresy.id_adresu";
switch ($sortz) {
    case "najnowsze":
        $queryZamowienia .= " ORDER BY zamowieniaklientow.Data DESC";
        break;
    case "najstarsze":
        $queryZamowienia .= " ORDER BY zamowieniaklientow.Data ASC";
        break;
    case "CenaM":
        $queryZamowienia .= " ORDER BY zamowieniaklientow.Laczna_Kwota DESC";
        break;
    case "CenaR":
        $queryZamowienia .= " ORDER BY zamowieniaklientow.Laczna_Kwota ASC";
        break;
}
$stmt = mysqli_prepare($conn, $queryZamowienia);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$sort = isset($_POST['sortowaniemagazynu']) ? $_POST['sortowaniemagazynu'] : 'najnowsze';
$queryMagazyn = "SELECT * FROM przedmioty";
switch ($sort) {
    case "IloscM":
        $queryMagazyn .= " ORDER BY ilosc DESC";
        break;
    case "IloscR":
        $queryMagazyn .= " ORDER BY ilosc ASC";
        break;
    case "CenaM":
        $queryMagazyn .= " ORDER BY cena DESC";
        break;
    case "CenaR":
        $queryMagazyn .= " ORDER BY cena ASC";
        break;
}
$stmtMagazyn = mysqli_prepare($conn, $queryMagazyn);
mysqli_stmt_execute($stmtMagazyn);
$resultMagazyn = mysqli_stmt_get_result($stmtMagazyn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1>Panel administratora</h1>
    </header>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href=""></a>
            <form class="d-flex" action="logaut.php">
                <button class="btn btn-outline-danger" type="submit">
                    Wyloguj
                    <i class="bi bi-box-arrow-left align-middle"></i>
                </button>
            </form>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h1>Magazyn</h1>
                <form action="admin.php" method="POST">
                    <select class="form-select" name="sortowaniemagazynu" onchange="this.form.submit()">
                        <option value="IloscM" <?php if ($sort == "IloscM") print "selected" ?>>Po ilosci malejaco</option>
                        <option value="IloscR" <?php if ($sort == "IloscR") print "selected" ?>>Po ilosci rosnąco</option>
                        <option value="CenaM" <?php if ($sort == "CenaM") print "selected" ?>>Po cenie malejąco</option>
                        <option value="CenaR" <?php if ($sort == "CenaR") print "selected" ?>>Po cenie rosnąco</option>
                    </select>
                </form>
                <table class="table table-secondary">
                    <tr>
                        <th scope="col">Id przedmiotu</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Dostepnych sztuk</th>
                        <th scope="col">Dodaj do magazynu</th>
                    </tr>
                    <?php
                    while ($rowMagazyn = mysqli_fetch_assoc($resultMagazyn)) {
                        echo "<tr>";
                        echo "<th scope='row'>".$rowMagazyn['id_przedmiotu']."</th>";
                        echo "<td>".$rowMagazyn['nazwa']."</td>";
                        if(isset($_POST['Cena']))
                        {
                            if($zmiana==false)
                            {
                                echo "<td>".$rowMagazyn['cena']."</td>";
                            }
                            else if($zmiana==TRUE)
                            {
                                echo "<td>";
                                echo "<form action='ZmienCene.php' method='POST'>";
                                echo "<input type='hidden' name='id' value='".$rowMagazyn['id_przedmiotu']."'>";
                                echo "<input type='number' name='cena' onchange='this.form.submit()' placeholder='".$rowMagazyn['cena']."'>";
                                echo "</form>";
                                echo "</td>";
                            }                            
                        }
                        else echo "<td>".$rowMagazyn['cena']."</td>";
                        echo "<td>".$rowMagazyn['ilosc']."</td>";
                        echo "<td>";
                        echo "<form action='DodajNaMagazyn.php' method='POST'>";
                        echo "<input type='hidden' name='id_przedmiotu' value='".$rowMagazyn['id_przedmiotu']."'>";
                        echo "<div class='input-group mb-1'>";
                        echo "<input type='number' class='form-control' name='ilosc'>";
                        echo "<button class='btn btn-outline-secondary' type='submit' id='button-addon2'>Dodaj</button>";
                        echo "</div>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <form action='Admin.php' method='POST'>;
                    <input type='hidden' name='Cena' value=True>
                    <input type='submit' class='btn btn-primary' value='zmień Ceny'>
                </form>
            </div>
            <div class="col-md-4">
                <h1>Zamowienia: </h1><br>
                <form action="admin.php" method="POST">
                    <select class="form-select" name="sortowanie" onchange="this.form.submit()">
                        <option value="najnowsze" <?php if ($sortz == "najnowsze") print "selected" ?>>Od najnowszego</option>
                        <option value="najstarsze" <?php if ($sortz == "najstarsze") print "selected" ?>>Od najstarszego</option>
                        <option value="CenaM" <?php if ($sortz == "CenaM") print "selected" ?>>Po cenie malejąco</option>
                        <option value="CenaR" <?php if ($sortz == "CenaR") print "selected" ?>>Po cenie rosnąco</option>
                    </select>
                </form>
                <table class="table table-light table-bordered table-striped table-hover">
                    <tr>
                        <th scope="col">Id zamowienia</th>
                        <th scope="col">Login uzytkownika</th>
                        <th scope="col">Miejscowosc</th>
                        <th scope="col">Data zamowienia</th>
                        <th scope="col">Kwota zamowienia</th>
                        <th scope="col">Status zamowienia</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class='clickable-row' onclick='this.firstChild.submit()' style='cursor: pointer;'>";
                        echo "<form action='SzczegolyZamowienia.php' method='POST'>";
                        echo "<input type='hidden' name='Id_zamowienia' value='".$row['Id_zamowienia']."'>";
                        echo "<input type='hidden' name='Id_uzytkownika' value='".$row['id']."'>";
                        echo "<input type='hidden' name='Id_adresu' value='".$row['id_adresu']."'>";
                        echo "<td>".$row['Id_zamowienia']."</td>";
                        echo "<td>".$row['login']."</td>";
                        echo "<td>".$row['Miejscowosc']."</td>";
                        echo "<td>".$row['Data']."</td>";
                        echo "<td>".$row['Laczna_Kwota']."</td>";
                        echo "<td>";
                        if ($row['Status'] == 0) {
                            echo "Nie zrealizowane";
                        } else if ($row['Status'] == 1) {
                            echo "Zrealizowane";
                        }
                        echo "</td>";
                        echo "</form>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

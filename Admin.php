<?php
session_start();
require_once 'db_connect.php';

$sort=isset($_POST['sortowanie']) ? $_POST['sortowanie'] : 'najnowsze';
$queryZamowienia="SELECT zamowieniaklientow.Id_zamowienia,zamowieniaklientow.id_adresu,uzytkownicy.login,uzytkownicy.id, adresy.Miejscowosc, zamowieniaklientow.Data, zamowieniaklientow.Laczna_Kwota, zamowieniaklientow.Status FROM zamowieniaklientow JOIN uzytkownicy ON zamowieniaklientow.id_uzytkownika=uzytkownicy.id JOIN adresy ON zamowieniaklientow.id_adresu=adresy.id_adresu";
switch($sort)
{
    case "najnowsze":
        $queryZamowienia.=" ORDER BY zamowieniaklientow.Data DESC";
        break;
    case "najstarsze":
        $queryZamowienia.=" ORDER BY zamowieniaklientow.Data ASC";
        break;
    case "CenaM":
        $queryZamowienia.=" ORDER BY zamowieniaklientow.Laczna_Kwota DESC";
        break;
    case "CenaR":
        $queryZamowienia.=" ORDER BY zamowieniaklientow.Laczna_Kwota ASC";
        break;
}
$stmt=mysqli_prepare($conn,$queryZamowienia);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1>Panel administratora</h1>
    </header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                <h1>Zamowienia: </h1><br>
                <form action="admin.php" method="POST">
                    <select class="form-select" name="sortowanie" onchange="this.form.submit()">
                        <option value="najnowsze" <?php if($sort=="najnowsze") print "selected" ?>>
                            Od najnowszego
                        </option>
                        <option value="najstarsze" <?php if($sort=="najstarsze") print "selected" ?>>
                            Od najstarszego
                        </option>
                        <option value="CenaM" <?php if($sort=="CenaM") print "selected" ?>>
                            Po cenie malejąco
                        </option>
                        <option value="CenaR"<?php if($sort=="CenaR") print "selected" ?>>
                            Po cenie rosnąco
                        </option>
                    </select>
                </form>
                <table class="table table-light table-bordered table-striped table-hover">
                    <tr>
                        <th scope="col">Id zamowienia</th><th scope="col">Login uzytkownika</th><th scope="col">Miejscowosc</th><th scope="col">Data zamowienia</th><th scope="col">Kwota zamowienia</th><th scope="col">Status zamowienia</th>
                    </tr>

                    <?php
                        while($row=mysqli_fetch_assoc($result))
                        {
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
</body>
</html>
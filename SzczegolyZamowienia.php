<?php
session_start();
require_once 'db_connect.php';
$id_zamowienia=$_POST['Id_zamowienia'];
// Dane osoby
$id_uzytkownika=$_POST['Id_uzytkownika'];
$queryDaneOsoby="SELECT * FROM uzytkownicy WHERE id=?";
$stmtDaneOsoby=mysqli_prepare($conn,$queryDaneOsoby);
mysqli_stmt_bind_param($stmtDaneOsoby,"i",$id_uzytkownika);
mysqli_stmt_execute($stmtDaneOsoby);
$resultDaneOsoby=mysqli_stmt_get_result($stmtDaneOsoby);
$rowDaneOsoby=mysqli_fetch_assoc($resultDaneOsoby);
// Dane adresu
$id_adresu=$_POST['Id_adresu'];
$queryDaneAdresu="SELECT * FROM adresy WHERE id_adresu=?";
$stmtDaneAdresu=mysqli_prepare($conn,$queryDaneAdresu);
mysqli_stmt_bind_param($stmtDaneAdresu,"i",$id_adresu);
mysqli_stmt_execute($stmtDaneAdresu);
$resultDaneAdresu=mysqli_stmt_get_result($stmtDaneAdresu);
$rowDaneAdresu=mysqli_fetch_assoc($resultDaneAdresu);
// Dane zamowienia
$queryDaneZamowienia="SELECT zamowioneprzedmioty.id_przedmiotu,przedmioty.nazwa,zamowioneprzedmioty.ilosc FROM zamowioneprzedmioty JOIN przedmioty ON zamowioneprzedmioty.id_przedmiotu=przedmioty.id_przedmiotu WHERE zamowioneprzedmioty.Id_zamowienia=?";
$stmtDaneZamowienia=mysqli_prepare($conn,$queryDaneZamowienia);
mysqli_stmt_bind_param($stmtDaneZamowienia,"i",$id_zamowienia);
mysqli_stmt_execute($stmtDaneZamowienia);
$resultDaneZamowienia=mysqli_stmt_get_result($stmtDaneZamowienia);
// Dane do przycisku
$query="SELECT * FROM zamowieniaklientow WHERE Id_zamowienia=?";
$stmt=mysqli_prepare($conn,$query);
mysqli_stmt_bind_param($stmt,"i",$id_zamowienia);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
$row=mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szczegóły Zamówienia Nr: <?php echo $id_zamowienia; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <div class="container">
            <h1 class="text-center ">Szczegóły Zamówienia Nr: <?php echo $id_zamowienia; ?></h1>
        </div>
    </header>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href=""></a>
            <div class="d-flex">
                <form class="me-2" action="admin.php">
                    <button class="btn btn-outline-secondary" type="submit">
                        Cofnij
                        <i class="bi bi-backspace-fill"></i>
                    </button>
                </form>
                <form action="logaut.php">
                    <button class="btn btn-outline-danger" type="submit">
                        Wyloguj
                        <i class="bi bi-box-arrow-left align-middle"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <h2>Dane osoby:</h2>
                <ul class="list-group">
                    <li class="list-group-item">Id uzytkownika: <?php echo $rowDaneOsoby['id']; ?></li>
                    <li class="list-group-item">Imię: <?php echo $rowDaneOsoby['imie']; ?></li>
                    <li class="list-group-item">Nazwisko: <?php echo $rowDaneOsoby['nazwisko']; ?></li>
                    <li class="list-group-item">Email: <?php echo $rowDaneOsoby['email']; ?></li>
                    <li class="list-group-item">Wiek: <?php echo $rowDaneOsoby['wiek']; ?></li>
                    <li class="list-group-item">Login: <?php echo $rowDaneOsoby['login']; ?></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2>Dane dostawy:</h2>
                <ul class="list-group">
                    <li class="list-group-item">Id adresu: <?php echo $id_adresu; ?></li>
                    <li class="list-group-item">Miejscowosc: <?php echo $rowDaneAdresu['Miejscowosc']; ?></li>
                    <li class="list-group-item">Ulica: <?php echo $rowDaneAdresu['Ulica']; ?></li>
                    <li class="list-group-item">Adres: <?php echo $rowDaneAdresu['Adres']; ?></li>
                    <li class="list-group-item">Kod pocztowy: <?php echo $rowDaneAdresu['Kod_pocztowy']; ?></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2>Zamówione przedmioty:</h2>
                <table class="table">
                    <tr>
                        <th scope="col">Id przedmiotu</th><th scope="col">Nazwa przedmiotu</th><th scope="col">ilosc</th>
                    </tr>
                    <?php
                        While($rowDaneZamowienia=mysqli_fetch_assoc($resultDaneZamowienia))
                        {
                            print "<tr>
                                    <th scope='row'>".$rowDaneZamowienia['id_przedmiotu']."</th><td>".$rowDaneZamowienia['nazwa']."</td><td>".$rowDaneZamowienia['ilosc']."</td>
                                  </tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <form action="Realizacjazamowienia.php" method="POST">
                    <input type="hidden" name="id_zamowienia" value='<?php print $id_zamowienia ?>'>
                    <?php
                    if($row['Status']==0)
                    {
                        print "<input type='submit' class='btn btn-primary' value='Zrealizuj zamowienie'>";
                    }
                    else if($row['Status']==1)
                    {
                        print "<input type='disabled' class='btn btn-success' value='Zamowienie zrealizowane'>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

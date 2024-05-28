<?php
session_start();
require_once 'db_connect.php';
$username = $_SESSION['username'];

$query = "SELECT * FROM uzytkownicy WHERE login= ?";
$stmt=mysqli_prepare($conn,$query);
mysqli_stmt_bind_param($stmt,"s",$username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row=mysqli_fetch_assoc($result);
$username=$row['login'];
$id=$row['id'];
$imie=$row['imie'];
$nazwisko=$row['nazwisko'];
$email=$row['email'];
$telefon=$row['telefon'];
$wiek=$row['wiek'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="konto.css">
</head>
<body>
<header>
    <h1>Konto</h1>
</header>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="welcome.php">Sklep</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="welcome.php">Przedmioty</a></li>
            <li><a href="PokazKoszyk.php">Koszyk</a></li>
            <li><a href="opinie.php">Opinie</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="konto.php" class="active"><span class="glyphicon glyphicon-user"></span> konto</a></li>
            <li><a href="logaut.php"><span class="glyphicon glyphicon-log-out"></span> Wyloguj</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="user-panel">
        <div class="order-history">
            <h2>Historia zamówień</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Numer zamówienia</th>
                    <th>Data</th>
                    <th>Produkty</th>
                    <th>Kwota</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $queryInfoZamowienia = "SELECT * FROM zamowieniaklientow WHERE id_uzytkownika=?";
                    $stmtInfoZamowienia = mysqli_prepare($conn, $queryInfoZamowienia);
                    mysqli_stmt_bind_param($stmtInfoZamowienia, "i", $id);
                    mysqli_stmt_execute($stmtInfoZamowienia);
                    $resultInfoZamowienia = mysqli_stmt_get_result($stmtInfoZamowienia);

                    while ($rowInfoZamowienia = mysqli_fetch_assoc($resultInfoZamowienia)) {
                        print "<tr>";
                        print "<td>".$rowInfoZamowienia['Id_zamowienia']."</td>";
                        print "<td>".$rowInfoZamowienia['Data']."</td>";
                        print "<td>";
                        
                        $queryInfoPrzedmioty = "SELECT * FROM zamowioneprzedmioty WHERE Id_zamowienia=?";
                        $stmtInfoPrzedmioty = mysqli_prepare($conn, $queryInfoPrzedmioty);
                        mysqli_stmt_bind_param($stmtInfoPrzedmioty, "i", $rowInfoZamowienia['Id_zamowienia']);
                        mysqli_stmt_execute($stmtInfoPrzedmioty);
                        $resultInfoPrzedmioty = mysqli_stmt_get_result($stmtInfoPrzedmioty);
                        
                        while ($rowInfoPrzedmioty = mysqli_fetch_assoc($resultInfoPrzedmioty)) {
                            $queryNazwyPrzedmiotow = "SELECT * FROM przedmioty WHERE id_przedmiotu=?";
                            $stmtNazwyPrzedmiotow = mysqli_prepare($conn, $queryNazwyPrzedmiotow);
                            mysqli_stmt_bind_param($stmtNazwyPrzedmiotow, "i", $rowInfoPrzedmioty['id_przedmiotu']);
                            mysqli_stmt_execute($stmtNazwyPrzedmiotow);
                            $resultNazwyPrzedmiotow = mysqli_stmt_get_result($stmtNazwyPrzedmiotow);
                            
                            while ($rowNazwyPrzedmiotow = mysqli_fetch_assoc($resultNazwyPrzedmiotow)) {
                                print $rowNazwyPrzedmiotow['nazwa'].", ";
                            }
                        }
                        
                        print "</td>";
                        print "<td>".$rowInfoZamowienia['Laczna_Kwota']."</td>";
                        print "<td>";
                        if($rowInfoZamowienia['Status']==0)
                        {
                            print "Nie zrealizowane";
                        }
                        else
                        {
                            print "Zrealizowane";
                        }
                        print "</td>";
                        print "</tr>";
                    }
                ?>
            </tbody>
            </table>
        </div>
        <div class="user-details">
            <h3>Dane użytkownika</h3>
            <p>Imię: <?php echo $imie; ?></p>
            <p>Nazwisko: <?php echo $nazwisko; ?></p>
            <p>E-mail: <?php echo $email; ?></p>
            <p>Telefon: <?php echo $telefon; ?></p>
            <p>Wiek: <?php echo $wiek; ?></p>
        </div>
        <div class="edit-user-details">
            <h3>Edytuj dane użytkownika</h3>
            <form action="edytuj_dane.php" method="post">
                <label for="email">Nowy e-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <label for="telefon">Nowy telefon:</label>
                <input type="text" id="telefon" name="telefon" value="<?php echo $telefon; ?>">
                <input type="submit" value="Zapisz zmiany">
            </form>
        </div>
        <div class="change-password">
            <h3>Zmień hasło</h3>
            <form action="zmien_haslo.php" method="post">
                <label for="old_password">Stare hasło:</label>
                <input type="password" id="old_password" name="old_password">
                <label for="new_password">Nowe hasło:</label>
                <input type="password" id="new_password" name="new_password">
                <?php
                    if(isset($_SESSION['password_changed']) && $_SESSION['password_changed'] == true) {
                        echo "<p>Hasło zostało pomyślnie zmienione.</p>";
                        print "<input type='submit' value='Zmień hasło'  style='background-color: #28a745; border-color: #28a745; color: #fff;'>";
                        unset($_SESSION['password_changed']);
                    }
                    else
                    {
                        if(isset($_SESSION['password_changed']) && $_SESSION['password_changed'] == false)
                        {
                            print "<p>Podano zle dane </p>";
                            print "<input style='background-color: #dc3545; border-color: #dc3545; color: #fff;' type='submit' value='Zmień hasło'>";
                            unset($_SESSION['password_changed']);
                        }
                        else
                        {
                            print "<input type='submit' value='Zmień hasło'>";
                        }
                    }

                ?>
            </form>
        </div>
        <div class="delivery-addresses">
            <h3>Adresy dostawy</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Numer Adresu</th>
                        <th>Miejscowosc</th>
                        <th>Ulica</th>
                        <th>Adres</th>
                        <th>Kod Pocztowy</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $queryAdresy="SELECT * FROM adresy WHERE id_klienta=?";
                        $stmtAdresy=mysqli_prepare($conn,$queryAdresy);
                        mysqli_stmt_bind_param($stmtAdresy,"i",$id);
                        mysqli_stmt_execute($stmtAdresy);
                        $resultAdresy=mysqli_stmt_get_result($stmtAdresy);
                        while($rowAdresy=mysqli_fetch_assoc($resultAdresy))
                        {
                            print "<tr><td>".$rowAdresy['id_adresu']."</td><td>".$rowAdresy['Miejscowosc']."</td><td>".$rowAdresy['Ulica']."</td><td>".$rowAdresy['Adres']."</td><td>".$rowAdresy['Kod_pocztowy']."</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

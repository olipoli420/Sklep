<?php
session_start();
require_once 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
    <h1>Sklep internetowy</h1>
</header>

<nav>
    <ul>
        <li><a href="#">Strona główna</a></li>
        <li><a href="#">Produkty</a></li>
        <li><a href="PokazKoszyk.php">Koszyk</a></li>
        <li><a href="konto.php">Konto</a></li>
        <li><a href="#">Kontakt</a></li>
    </ul>
</nav>

<div class="container">
    <?php
    if(isset($_SESSION['username'])) {
        print("<p>Witamy ".$_SESSION['username']."</p>");

        $username = $_SESSION['username'];

        $query = "SELECT id FROM uzytkownicy WHERE login='$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id_uzytkownika = $row['id'];

            $query2 = "SELECT id_przedmiotu, nazwa, cena, ilosc FROM przedmioty WHERE 1";
            $result2 = mysqli_query($conn, $query2);

            if ($result2 && mysqli_num_rows($result2) > 0) {
                echo "<table>
                        <tr>
                            <th>Nazwa</th>
                            <th>Cena</th>
                            <th>Ilość</th>
                            <th>Akcja</th>
                        </tr>";
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    echo "<tr>
                            <td>".$row2['nazwa']."</td>
                            <td>".$row2['cena']."</td>
                            <td>".$row2['ilosc']."</td>
                            <td>
                                <form action='koszyk.php' method='post'>
                                    <input type='submit' value='Zamów' class='btn btn-secondary'>
                                    <input type='hidden' name='id_przedmiotu' value='".$row2['id_przedmiotu']."'>
                                </form>
                            </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Użytkownik o nazwie $username nie posiada przedmiotów</p>";
            }
        } else {
            echo "<p>Błąd podczas pobierania danych użytkownika.</p>";
        }
    } else {
        header('Location: index.html');
    }

    $query3 = "SHOW TABLES LIKE 'koszyk".$id_uzytkownika."'";
    $result3 = mysqli_query($conn, $query3);
    $tableName = "koszyk".$id_uzytkownika;
    if($result3 && mysqli_num_rows($result3)==0) {
        $query4 = "CREATE TABLE ".$tableName." (id_przedmiotu INT, ilosc INT, FOREIGN KEY (id_przedmiotu) REFERENCES przedmioty(id_przedmiotu));";
        mysqli_query($conn, $query4);
    }
    $queryilosc = "SELECT * FROM koszyk".$id_uzytkownika." WHERE 1";
    $resultilosc = mysqli_query($conn, $queryilosc);
    $suma = 0;
    for($i=0;$i<mysqli_num_rows($resultilosc);$i++) {
        $rowilosc = mysqli_fetch_assoc($resultilosc);
        $suma = $suma + $rowilosc['ilosc'];
    }
    ?>
    <form action='PokazKoszyk.php' method='post'>
        <div class="cart-icon" onclick="this.parentNode.submit();"><?php echo $suma; ?></div>
    </form>
</div>
<?php
if(isset($_SESSION['username'])) {
    echo "<form action='logout.php' method='post'><input type='submit' class='btn btn-primary' value='Wyloguj'></form>";
}
?>

</body>
</html>

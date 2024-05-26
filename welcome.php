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
        <li><a href="opinie.php">Opinie</a></li>
        <li><a href="#">Kontakt</a></li>
    </ul>
</nav>

<div class="container mt-5">
    <?php
    if(isset($_SESSION['username'])) {
        print("<p>Witamy ".$_SESSION['username']."</p>");

        $username = $_SESSION['username'];

        $query = "SELECT id FROM uzytkownicy WHERE login= ?";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $selected_option = isset($_POST['opcje']) ? $_POST['opcje'] : '';
        ?>
        <form action="welcome.php" method="POST">
            <label for="opcje">Sortuj:</label>
            <select id="opcje" name="opcje" onchange="this.form.submit()">
                <option value="Alfa" <?php if($selected_option == 'Alfa') echo 'selected'; ?>>Alfabetycznie</option>
                <option value="CenaR" <?php if($selected_option == 'CenaR') echo 'selected'; ?>>Cena Rosnąco</option>
                <option value="CenaM" <?php if($selected_option == 'CenaM') echo 'selected'; ?>>Cena malejąco</option>
            </select>
        </form>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id_uzytkownika = $row['id'];
            $tableName = "koszyk".$id_uzytkownika;
            $query2 = "SELECT * FROM przedmioty WHERE 1";
            $result2 = mysqli_query($conn, $query2);
            $queryAlfa="SELECT * FROM przedmioty ORDER BY nazwa";
            $resultAlfa=mysqli_query($conn,$queryAlfa);
            $queryCenaM="SELECT * FROM przedmioty ORDER BY cena DESC";
            $resultCenaM=mysqli_query($conn,$queryCenaM);
            $queryCenaR="SELECT * FROM przedmioty ORDER BY cena ";
            $resultCenaR=mysqli_query($conn,$queryCenaR);
            if ($result2 && mysqli_num_rows($result2) > 0) {
                echo "<table class='table table-striped'>
                        <tr>
                            <th scope='col'>Nazwa</th>
                            <td border=0></td>
                            <th scope='col'>Cena</th>
                            <th scope='col'>Ilość</th>
                            <th scope='col'>Akcja</th>
                        </tr>";



                        if(isset($_POST['opcje'])) {
                            switch ($_POST['opcje']) {
                                case "Alfa":
                                    $result = $resultAlfa;
                                    break;
                                case "CenaR":
                                    $result = $resultCenaR;
                                    break;
                                case "CenaM":
                                    $result = $resultCenaM;
                                    break;
                                default:
                                    $result = $result2;
                            }
                        } else {
                            $result = $result2;
                        }
        
                        while ($row2 = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <th scope='row'>".$row2['nazwa']."</th>
                                    <td border=0><img src='".$row2['sciezka']."' alt='rysunek' class='img-fluid w-25'></td>
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
        } else 
        {
            echo "<p>Błąd podczas pobierania danych użytkownika.</p>";
        }
    } else {
        header('Location: index.html');
    }

    $query3 = "SHOW TABLES LIKE 'koszyk?";
    $stmt3 = mysqli_prepare($conn,$query3);
    mysqli_stmt_bind_param($stmt3,"i",$id_uzytkownika);
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);
    $tableName = "koszyk".$id_uzytkownika;
    if($result3 && mysqli_num_rows($result3)==0) {
        $query4 = "CREATE TABLE ? (id_przedmiotu INT, ilosc INT, FOREIGN KEY (id_przedmiotu) REFERENCES przedmioty(id_przedmiotu));";
        $stmt4=mysqli_prepare($conn,$query4);
        mysqli_stmt_bind_param($stmt4,"s",$tableName);
        mysqli_stmt_execute($stmt4);
    }
    $queryilosc = "SELECT * FROM ? WHERE 1";
    $stmtilosc = mysqli_prepare($conn, $queryilosc);
    mysqli_stmt_bind_param($stmtilosc,"i",$tableName);
    mysqli_stmt_execute($stmtilosc);
    $resultilosc = mysqli_stmt_get_result($stmtilosc);
    $suma = 0;
    for($i=0;$i<mysqli_num_rows($resultilosc);$i++) {
        $rowilosc = mysqli_fetch_assoc($resultilosc);
        $suma = $suma + $rowilosc['ilosc'];
    }
    ?>
</div>
<div class="container mt-5" style='display: flex'>
    <div class="div1" style='flex: 1;'>
        <form action='PokazKoszyk.php' method='post'>
        <div class="cart-icon" onclick="this.parentNode.submit();"><?php echo $suma; ?></div>
        </form>
    </div>
    <div class="div2" style='flex: 1;'>
        <form action='logout.php' method='post'><input type='submit' class='btn btn-primary' value='Wyloguj'></form>
    </div>
</div>
</body>
</html>

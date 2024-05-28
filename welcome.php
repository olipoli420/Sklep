<?php
session_start();
require_once 'db_connect.php';

if(!isset($_SESSION['last_category_Id'])) {
    $_SESSION['last_category_Id'] = NULL;
}
$suma = 0;

$id_uzytkownika = $_SESSION['id_klienta'];
$tableName = "koszyk" . $id_uzytkownika;
$_SESSION['tableName']=$tableName;
$querySuma = "SELECT SUM(ilosc) AS suma FROM $tableName";
$stmtSuma = mysqli_prepare($conn, $querySuma);
if ($stmtSuma) {
    mysqli_stmt_execute($stmtSuma);
    $resultSuma = mysqli_stmt_get_result($stmtSuma);
    if ($resultSuma) {
        $sumaRow = mysqli_fetch_assoc($resultSuma);
        $suma = $sumaRow['suma'];
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="welcome.css">
</head>
<body>
    <header>
        <h1>Sklep internetowy</h1>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="welcome.php">Sklep</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
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
        <ul class="navbar-nav navbar-right">
            <li class="nav-item">
                <div class="cart-icon dropdown" onmouseover="showCartDropdown()" onmouseout="hideCartDropdown()">
                    <span class="cart-quantity"><?php echo $suma ? $suma : 0; ?></span>
                    <div class="dropdown-menu" id="cartDropdown">
                    <?php
                        $query="SELECT * FROM $tableName";
                        $stmt=mysqli_prepare($conn,$query);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if(mysqli_num_rows($result) > 0) {
                    ?>
                        <table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th scope='col'>Nazwa</th>
                                    <th scope='col'>Obraz</th>
                                    <th scope='col'>Cena</th>
                                    <th scope='col'>Ilość</th>
                                    <th scope='col'>Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $query2="SELECT * FROM przedmioty WHERE id_przedmiotu = ?";
                            $stmt2=mysqli_prepare($conn,$query2);
                            mysqli_stmt_bind_param($stmt2,"i",$row['id_przedmiotu']);
                            mysqli_stmt_execute($stmt2);
                            $result2 = mysqli_stmt_get_result($stmt2);
                            $row2=mysqli_fetch_assoc($result2);
                            $nazwa_tabeli = $tableName;
                    ?>
                            <tr>
                                <td><?php echo $row2['nazwa']; ?></td>
                                <td><img src="<?php echo $row2['sciezka']; ?>" alt="rysunek" class="img-fluid w-50"></td>
                                <td><?php echo $row2['cena']; ?></td>
                                <td><?php echo $row['ilosc']; ?></td>
                                <td>
                                    <form action="Usunzkoszyk.php" method="post">
                                        <input type="submit" value="Usuń" class="btn btn-secondary">
                                        <input type="hidden" name="id_przedmiotu" value="<?php echo $row2['id_przedmiotu']; ?>">
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                            </tbody>
                        </table>
                    <?php
                        } else {
                            echo "<p>Brak przedmiotów w koszyku.</p>";
                        }
                    ?>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="konto.php"><span class="glyphicon glyphicon-user"></span> Konto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logaut.php"><span class="glyphicon glyphicon-log-out"></span> Wyloguj</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <h4>Kategorie:</h4>
                <nav id="sidebarMenu" class="sidebar bg-white">
                    <div class="list-group list-group-flush">
                        <?php
                        $queryK = "SELECT * FROM kategorie";
                        $stmtK = mysqli_prepare($conn, $queryK);
                        if ($stmtK) {
                            mysqli_stmt_execute($stmtK);
                            $resultK = mysqli_stmt_get_result($stmtK);
                            while ($rowK = mysqli_fetch_assoc($resultK)) {
                                $IdKategori = $rowK['id_kategorii'];
                                $NazwaKategori = $rowK['nazwa'];
                                $klasa = isset($_GET['category_id']) && $_GET['category_id'] == $IdKategori ? 'active' : '';
                                $link = $klasa ? "welcome.php" : "welcome.php?category_id=$IdKategori";
                                echo "<a href='$link' class='list-group-item list-group-item-action py-2 ripple category-link $klasa'>$NazwaKategori</a>";
                            }
                            mysqli_free_result($resultK);
                            mysqli_stmt_close($stmtK);
                        } else {
                            echo "<p>Błąd w przygotowaniu zapytania SQL: " . mysqli_error($conn) . "</p>";
                        }
                        ?>
                    </div>
                </nav>
            </div>
            <div class="col-md-10">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<p>Witamy " . $_SESSION['username'] . "</p>";
                    $username = $_SESSION['username'];
                    $query = "SELECT id FROM uzytkownicy WHERE login = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $selected_option = isset($_POST['opcje']) ? $_POST['opcje'] : '';
                        $selected_category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $id_uzytkownika = $row['id'];
                            $tableName = "koszyk" . $id_uzytkownika;
                            $querySuma = "SELECT SUM(ilosc) AS suma FROM $tableName";
                            $stmtSuma = mysqli_prepare($conn, $querySuma);
                            if ($stmtSuma) {
                                mysqli_stmt_execute($stmtSuma);
                                $resultSuma = mysqli_stmt_get_result($stmtSuma);
                                if ($resultSuma) {
                                    $sumaRow = mysqli_fetch_assoc($resultSuma);
                                    $suma = $sumaRow['suma'];
                                }
                                ?>
                                <form action="welcome.php<?php echo isset($_GET['category_id']) ? '?category_id=' . $_GET['category_id'] : ''; ?>" method="POST">
                                    <input type="hidden" name="category_id" value="<?php echo isset($_GET['category_id']) ? $_GET['category_id'] : ''; ?>">
                                    <label for="opcje">Sortuj:</label>
                                    <select id="opcje" name="opcje" onchange="this.form.submit()">
                                        <option value="Alfa" <?php if ($selected_option == 'Alfa') echo 'selected'; ?>>Alfabetycznie</option>
                                        <option value="CenaR" <?php if ($selected_option == 'CenaR') echo 'selected'; ?>>Cena Rosnąco</option>
                                        <option value="CenaM" <?php if ($selected_option == 'CenaM') echo 'selected'; ?>>Cena malejąco</option>
                                    </select>
                                </form>
                                <?php
                            }
                            $query = "SELECT * FROM przedmioty";
                            if (!empty($selected_category_id) && !isset($_GET['remove_category']) || (!empty($_POST['category_id']) && isset($_POST['category_id']))) {
                                if(isset($_POST['category_id'])) {
                                    $selected_category_id=$_POST['category_id'];
                                }
                                $query .= " WHERE id_kategorii=$selected_category_id";
                            }
                            if (!empty($selected_option)) {
                                switch ($selected_option) {
                                    case "Alfa":
                                        $query .= " ORDER BY nazwa";
                                        break;
                                    case "CenaR":
                                        $query .= " ORDER BY cena ASC";
                                        break;
                                    case "CenaM":
                                        $query .= " ORDER BY cena DESC";
                                        break;
                                }
                            }
                            $result2 = mysqli_query($conn, $query);
                            if ($result2 && mysqli_num_rows($result2) > 0) {
                                echo "<table class='table table-striped'>
                                        <thead>
                                            <tr>
                                                <th scope='col'>Nazwa</th>
                                                <th scope='col'>Obraz</th>
                                                <th scope='col'>Cena</th>
                                                <th scope='col'>Ilość</th>
                                                <th scope='col'>Akcja</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    echo "<tr>
                                            <td>" . $row2['nazwa'] . "</td>
                                            <td><img src='" . $row2['sciezka'] . "' alt='rysunek' class='img-fluid w-25'></td>
                                            <td>" . $row2['cena'] . "</td>
                                            <td>" . $row2['ilosc'] . "</td>
                                            <td>
                                                <form action='koszyk.php' method='post'>
                                                    <input type='submit' value='Zamów' class='btn btn-secondary'>
                                                    <input type='hidden' name='id_przedmiotu' value='" . $row2['id_przedmiotu'] . "'>
                                                </form>
                                            </td>
                                          </tr>";
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "<p>Brak przedmiotów w wybranej kategorii.</p>";
                            }
                        } else {
                            echo "<p>Błąd podczas pobierania danych użytkownika.</p>";
                        }
                    } else {
                        header('Location: index.html');
                    }
                } else {
                    header('Location: index.html');
                }
                ?>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <form action='PokazKoszyk.php' method='post'>
                <div class="cart-icon" onclick="this.parentNode.submit();">
                    <span class="cart-quantity"><?php echo $suma ? $suma : 0; ?></span>
                </div>
                <input type="hidden" name="category_id" value="<?php echo isset($_GET['category_id']) ? $_GET['category_id'] : ''; ?>">
            </form>
            <form action='welcome.php' method='get'>
                <input type='hidden' name='remove_category' value='1'>
                <button type='submit' class='btn btn-secondary'>Pokaż wszystkie przedmioty</button>
            </form>
        </div>
    </div>
<script>
    function showCartDropdown() {
        var cartContent = document.getElementById("cartDropdown");
        cartContent.style.display = "block";
        var cartHeight = cartContent.scrollHeight + "px";
        cartContent.style.height = cartHeight;
    }

    function hideCartDropdown() {
        var cartContent = document.getElementById("cartDropdown");
        cartContent.style.display = "none";
        cartContent.style.height = "auto";
    }
</script>

</body>
</html>

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
    <link rel="stylesheet" href="welcome.css">
    <style>
        .hover-dropdown {
            position: relative;
        }
        .hover-dropdown-content {
            display: none;
            position: absolute;
            left: 0;
            background-color: #f9f9f9;
            width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .hover-dropdown:hover .hover-dropdown-content {
            display: block;
        }
        .cart-icon {
            position: relative;
            cursor: pointer;
        }
        .cart-dropdown-content {
            display: none;
            position: absolute;
            right: 0;  /* Zmiana z left: -100%; na right: 0 */
            top: 100%;
            background-color: #f9f9f9;
            min-width: 300px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .cart-icon:hover .cart-dropdown-content {
            display: block;
        }
    </style>

</head>
<body>
    <header>
        <h1>Sklep internetowy</h1>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid justify-content-between">
        <a class="navbar-brand" href="welcome.php">Sklep</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                    <div class="cart-icon">
                        <span class="cart-quantity"><?php echo $suma ? $suma : 0; ?></span>
                        <div class="cart-dropdown-content" id="cartDropdown">
                            <?php
                                $query = "SELECT * FROM $tableName";
                                $stmt = mysqli_prepare($conn, $query);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                if (mysqli_num_rows($result) > 0) {
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
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $query2 = "SELECT * FROM przedmioty WHERE id_przedmiotu = ?";
                                    $stmt2 = mysqli_prepare($conn, $query2);
                                    mysqli_stmt_bind_param($stmt2, "i", $row['id_przedmiotu']);
                                    mysqli_stmt_execute($stmt2);
                                    $result2 = mysqli_stmt_get_result($stmt2);
                                    $row2 = mysqli_fetch_assoc($result2);
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
                                                <input type="hidden" name="welcome" value="">
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
                    <a class="nav-link" href="konto.php"><i class="bi bi-person-circle"></i> Konto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logaut.php"><i class="bi bi-box-arrow-left"></i> Wyloguj</a>
                </li>
            </ul>
        </div>
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
                        $num_rows = mysqli_num_rows($resultK);
                        if ($num_rows > 0) {
                            $i = 1;
                            echo "<div class='hover-dropdown'>";
                            while ($rowK = mysqli_fetch_assoc($resultK)) {
                            $IdKategori = $rowK['id_kategorii'];
                            $NazwaKategori = $rowK['nazwa'];
                            $klasa = isset($_GET['category_id']) && $_GET['category_id'] == $IdKategori ? 'active' : '';
                            $link = $klasa ? "welcome.php" : "welcome.php?category_id=$IdKategori";

                            if ($i == 1) {
                                echo "<a href='$link' class='list-group-item list-group-item-action py-2 ripple category-link $klasa'>$NazwaKategori</a>";
                                echo "<div class='hover-dropdown-content'>";
                            } else {
                                echo "<a href='$link' class='list-group-item list-group-item-action py-2 ripple category-link $klasa'>$NazwaKategori</a>";
                            }

                            if ($i == $num_rows) {
                                echo "</div>";
                            }

                            $i++;
                            }
                            echo "</div>";
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
                                    <select id="opcje" name="opcje" class="form-select" onchange="this.form.submit()">
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
                                            // Sprawdź dostępność produktu
                                            $dostepnosc = $row2['ilosc'] > 0 ? true : false;
                                            // Ustaw klasę i aktywność przycisku w zależności od dostępności
                                            $klasa_przycisku = $dostepnosc ? 'btn-secondary' : 'btn-danger disabled';
                                            $aktywnosc_przycisku = $dostepnosc ? '' : 'disabled';
                                            
                                            echo "<tr>
                                                    <td><a href='szczegoly.php?id_przedmiotu=" . $row2['id_przedmiotu'] . "'>" . $row2['nazwa'] . "</a></td>
                                                    <td><a href='szczegoly.php?id_przedmiotu=" . $row2['id_przedmiotu'] . "'><img src='" . $row2['sciezka'] . "' alt='rysunek' class='img-fluid w-25'></a></td>
                                                    <td>" . $row2['cena'] . "</td>
                                                    <td>" . $row2['ilosc'] . "</td>
                                                    <td>
                                                        <form action='koszyk.php' method='post'>
                                                            <input type='submit' value='Zamów' class='btn $klasa_przycisku' $aktywnosc_przycisku>
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
                        header('Location: login.html');
                    }
                } else {
                    header('Location: login.html');
                }
                ?>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <form action='PokazKoszyk.php' method='post'>
                <div class="cart-icon" onclick="this.parentNode.submit();">
                    <?php echo $suma ? $suma : 0; ?>
                </div>
                <input type="hidden" name="category_id" value="<?php echo isset($_GET['category_id']) ? $_GET['category_id'] : ''; ?>">
            </form>
            <form action='welcome.php' method='get'>
                <input type='hidden' name='remove_category' value='1'>
                <button type='submit' class='btn btn-secondary'>Pokaż wszystkie przedmioty</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

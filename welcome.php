<?php
session_start();
require_once 'db_connect.php';

if(!isset($_SESSION['last_category_Id'])) {
    $_SESSION['last_category_Id'] = NULL;
}

$suma = 0; // Zainicjalizowanie zmiennej $suma na początku

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Sklep internetowy</h1>
    </header>
    <nav>
        <ul>
            <li><a href="welcome.php">Strona główna</a></li>
            <li><a href="#">Produkty</a></li>
            <li><a href="PokazKoszyk.php">Koszyk</a></li>
            <li><a href="konto.php">Konto</a></li>
            <li><a href="opinie.php">Opinie</a></li>
            <li><a href="#">Kontakt</a></li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">
                Kategorie:
                <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white" style="width: 150px;">
                    <div class="position-sticky">
                        <div class="list-group list-group-flush mx-3 mt-4">
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
                                    // Sprawdzamy, czy kategoria jest aktualnie wybrana, jeśli tak, to link nie przekazuje category_id
                                    $link = $klasa ? "welcome.php" : "welcome.php?category_id=$IdKategori";
                                    echo "<a href='$link' class='list-group-item list-group-item-action py-2 ripple category-link $klasa' aria-current='true'>$NazwaKategori</a>";
                                }
                                mysqli_free_result($resultK);
                                mysqli_stmt_close($stmtK);
                            } else {
                                echo "<p>Błąd w przygotowaniu zapytania SQL: " . mysqli_error($conn) . "</p>";
                            }
                            ?>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-md-11">
                <?php
                $id_uzytkownika = null; // Domyślne ustawienie ID użytkownika
                $suma = 0; // Domyślne ustawienie sumy
                if (isset($_SESSION['username'])) { // Sprawdzenie, czy użytkownik jest zalogowany
                    echo "<p>Witamy " . $_SESSION['username'] . "</p>"; // Wyświetlenie powitania

                    $username = $_SESSION['username']; // Pobranie nazwy użytkownika

                    $query = "SELECT id FROM uzytkownicy WHERE login = ?"; // Zapytanie SQL pobierające ID użytkownika
                    $stmt = mysqli_prepare($conn, $query); // Przygotowanie zapytania SQL
                    if ($stmt) 
                    {
                        mysqli_stmt_bind_param($stmt, "s", $username); // Przypisanie wartości do parametrów
                        mysqli_stmt_execute($stmt); // Wykonanie zapytania
                        $result = mysqli_stmt_get_result($stmt); // Pobranie wyników

                        $selected_option = isset($_POST['opcje']) ? $_POST['opcje'] : ''; // Pobranie wybranej opcji sortowania
                        $selected_category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null; // Pobranie ID wybranej kategorii
                        if ($result && mysqli_num_rows($result) > 0) // Sprawdzenie, czy są wyniki i czy liczba wyników jest większa od zera
                        { 
                            $row = mysqli_fetch_assoc($result); // Pobranie wiersza wyników
                            $id_uzytkownika = $row['id']; // Przypisanie ID użytkownika
                            $tableName = "koszyk" . $id_uzytkownika; // Nazwa tabeli koszyka dla użytkownika

                            $querySuma = "SELECT SUM(ilosc) AS suma FROM $tableName"; // Zapytanie SQL pobierające sumę ilości produktów w koszyku
                            $stmtSuma = mysqli_prepare($conn, $querySuma); // Przygotowanie zapytania SQL

                            if ($stmtSuma) 
                            {
                                mysqli_stmt_execute($stmtSuma); // Wykonanie zapytania
                                $resultSuma = mysqli_stmt_get_result($stmtSuma); // Pobranie wyników
                                if ($resultSuma) 
                                {
                                    $sumaRow = mysqli_fetch_assoc($resultSuma); // Pobranie wiersza wyników
                                    $suma = $sumaRow['suma']; // Przypisanie sumy
                                }
                                ?>
                                <form action="welcome.php<?php echo isset($_GET['category_id']) ? '?category_id=' . $_GET['category_id'] : ''; ?>" method="POST">
                                    <!-- Formularz sortowania -->
                                    <input type="hidden" name="category_id" value="<?php echo isset($_GET['category_id']) ? $_GET['category_id'] : ''; ?>"> <!-- Ukryte pole z ID wybranej kategorii -->
                                    <label for="opcje">Sortuj:</label>
                                    <select id="opcje" name="opcje" onchange="this.form.submit()"> <!-- Wysłanie formularza po zmianie opcji -->
                                        <option value="Alfa" <?php if ($selected_option == 'Alfa') echo 'selected'; ?>>Alfabetycznie</option> <!-- Opcja sortowania alfabetycznego -->
                                        <option value="CenaR" <?php if ($selected_option == 'CenaR') echo 'selected'; ?>>Cena Rosnąco</option> <!-- Opcja sortowania po cenie rosnąco -->
                                        <option value="CenaM" <?php if ($selected_option == 'CenaM') echo 'selected'; ?>>Cena malejąco</option> <!-- Opcja sortowania po cenie malejąco -->
                                    </select>
                                </form>
                                <?php
                            } // Zamknięcie warunku dla $stmtSuma
                            // Modyfikacja zapytania SQL dla sortowania w danej kategorii
                            $query = "SELECT * FROM przedmioty"; // Zapytanie SQL pobierające wszystkie przedmioty

                            if (!empty($selected_category_id) && !isset($_GET['remove_category']) || (!empty($_POST['category_id']) && isset($_POST['category_id']))) {
                                if(isset($_POST['category_id']))
                                {
                                    $selected_category_id=$_POST['category_id'];
                                }
                                $query .= " WHERE id_kategorii=$selected_category_id"; // Dodanie warunku dla wybranej kategorii
                            }

                            if (!empty($selected_option)) {
                                switch ($selected_option) {
                                    case "Alfa":
                                        $query .= " ORDER BY nazwa"; // Sortowanie alfabetyczne
                                        break;
                                    case "CenaR":
                                        $query .= " ORDER BY cena ASC"; // Sortowanie po cenie rosnąco
                                        break;
                                    case "CenaM":
                                        $query .= " ORDER BY cena DESC"; // Sortowanie po cenie malejąco
                                        break;
                                }
                            }

                            $result2 = mysqli_query($conn, $query); // Wykonanie zapytania SQL
        
                                if ($result2 && mysqli_num_rows($result2) > 0) // Sprawdzenie, czy są wyniki i czy liczba wyników jest większa od zera
                                { 
                                    echo "<table class='table table-striped'> <!-- Rozpoczęcie tabeli -->
                                        <tr>
                                            <th scope='col'>Nazwa</th>
                                            <th scope='col'>Cena</th>
                                            <th scope='col'>Ilość</th>
                                            <th scope='col'>Akcja</th>
                                        </tr>";
        
                                    while ($row2 = mysqli_fetch_assoc($result2)) // Pętla po wynikach zapytania
                                    { 
                                        echo "<tr> <!-- Rozpoczęcie wiersza -->
                                                <th scope='row'>" . $row2['nazwa'] . "</th> <!-- Nazwa przedmiotu -->
                                                <td border=0><img src='" . $row2['sciezka'] . "' alt='rysunek' class='img-fluid w-25'></td> <!-- Obraz przedmiotu -->
                                                <td>" . $row2['cena'] . "</td> <!-- Cena przedmiotu -->
                                                <td>" . $row2['ilosc'] . "</td> <!-- Ilość przedmiotu -->
                                                <td>
                                                    <form action='koszyk.php' method='post'> <!-- Formularz dodania do koszyka -->
                                                        <input type='submit' value='Zamów' class='btn btn-secondary'> <!-- Przycisk zamówienia -->
                                                        <input type='hidden' name='id_przedmiotu' value='" . $row2['id_przedmiotu'] . "'> <!-- Ukryte pole z ID przedmiotu -->
                                                    </form>
                                                </td>
                                              </tr>"; // Koniec wiersza
                                    }
                                    echo "</table>"; // Koniec tabeli
                                } else 
                                {
                                    echo "<p>Brak przedmiotów w wybranej kategorii.</p>"; // Komunikat o braku przedmiotów
                                }
                            } else 
                            {
                                echo "<p>Błąd podczas pobierania danych użytkownika.</p>"; // Komunikat o błędzie
                            }
                        } else 
                        {
                            header('Location: index.html'); // Przekierowanie na stronę logowania
                        }
                    }
                    ?>
                </div>
            </div>
        
        </div>
        <div class="container mt-5" style='display: flex'>
            <div class="div1" style='flex: 1;'>
                <form action='PokazKoszyk.php' method='post'>
                    <div class="cart-icon" onclick="this.parentNode.submit();"><?php echo $suma; ?></div> <!-- Ikona koszyka -->
                </form>
            </div>
            <div class="div2" style='flex: 1;'>
                <form action='logaut.php' method='post'><input type='submit' class='btn btn-primary' value='Wyloguj'></form> <!-- Formularz wylogowania -->
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
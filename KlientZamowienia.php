<?php
session_start();
require_once 'db_connect.php';  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dostawa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form action="zamow.php" method="post">
        <?php
            // Pobranie adresów użytkownika z bazy danych
            // Zakładając, że masz tabelę 'adresy_uzytkownika' zawierającą adresy użytkownika
            $id_uzytkownika = isset($_SESSION['id_klienta']) ? $_SESSION['id_klienta'] : '';
            $tableName = isset($_SESSION['tableName']) ? $_SESSION['tableName'] : '';
            $query = "SELECT * FROM adresy WHERE id_klienta = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id_uzytkownika);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Sprawdzenie, czy istnieją adresy użytkownika
            if (mysqli_num_rows($result) > 0) {
                echo "<label for='adres'>Wybierz adres:</label>";
                echo "<select name='adres' id='adres' class='form-control'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id_adresu'] . "'>" . $row['Miejscowosc'] . ", " . $row['Ulica'] . ", " . $row['Adres'] . ", " . $row['Kod_pocztowy'] . "</option>";
                }
                echo "</select>";
            } else {
                echo "<p>Brak dostępnych adresów użytkownika.</p>";
            }
        ?>
        <hr>


        <?php
            // Uzupełnienie danych zmiennych

            // Wyświetlenie ukrytych pól
            echo "<input type='hidden' name='nazwa_tabeli' value='" . $tableName . "'>";
            echo "<input type='hidden' name='id_uzytkownika' value='" . $id_uzytkownika . "'>";
        ?>

        <div class="container mt-5" style='display: flex'>
            <div class="div1" style='flex: 1;'>
                <input type='submit' value='Akceptuj' class="btn btn-secondary">
            </div>
    </form>
            <div class="div2" style='flex: 1;'>
                <form action="PokazKoszyk.php">
                    <input class="btn btn-secondary" type="submit" value="Wroc do koszyka">
                </form>
            </div>
        </div>

  <!-- Formularz dodawania nowego adresu -->
  <div class="container mt-5">
        <h4>Dodaj nowy adres:</h4>
        <form action="dodaj_adres.php" method="post">
            <div class="form-group">
                <label for="miejscowosc">Miejscowość:</label>
                <input type="text" name="miejscowosc" id="miejscowosc" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ulica">Ulica:</label>
                <input type="text" name="ulica" id="ulica" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="adres">Adres:</label>
                <input type="text" name="adres" id="adres" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="kod_pocztowy">Kod pocztowy:</label>
                <input type="text" name="kod_pocztowy" id="kod_pocztowy" class="form-control" required>
            </div>
            <input type="submit" value="Dodaj adres" class="btn btn-primary">
        </form>
    </div>
</body>
</html>

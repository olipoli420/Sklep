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
        Miejscowość: <br>
        <input type="text" name="Miejscowosc" placeholder="Miejscowosc" class="form-control" required><br>
        Ulica: <br>
        <input type="text" name="Ulica" placeholder="Ulica" class="form-control" required><br>
        Adres: <br>
        <input type="text" name="Adres" placeholder="Adres" class="form-control" required><br>
        Kod pocztowy: <br>
        <input type="text" name="Kod_pocztowy" placeholder="Kod Pocztowy" class="form-control" required><br>
        <div class="container mt-5" style='display: flex'>
            <div class="div1" style='flex: 1;'>
                <input type='submit' value='Akceptuj' class="btn btn-secondary">
                <?php
                    $id_uzytkownika = $_POST['id_uzytkownika'];
                    $tableName = $_POST['nazwa_tabeli'];
                    print "<input type='hidden' name='nazwa_tabeli' value='" .$tableName. "'><input type='hidden' name='id_uzytkownika' value='".$id_uzytkownika."'>";
                ?>
    </form>
            </div>
            <div class="div2" style='flex: 1;'>
                <form action="PokazKoszyk.php">
                    <input class="btn btn-secondary" type="submit" value="Wroc do koszyka">
                </form>
            </div>
        </div>
</body>
</html>

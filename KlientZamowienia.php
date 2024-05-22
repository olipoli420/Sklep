<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="zamow.php" method="post">
    Miejscowość: <br>
    <input type="text" name="Miejscowosc"><br>
    Ulica: <br>
    <input type="text" name="Ulica"><br>
    Adres: <br>
    <input type="text" name="Adres"><br>
    Kod pocztowy: <br>
    <input type="text" name="Kod_pocztowy"><br>
    <input type='submit' value='Akceptuj'>
    <?php
        $id_uzytkownika = $_POST['id_uzytkownika'];
        $tableName = $_POST['nazwa_tabeli'];
        print "<input type='hidden' name='nazwa_tabeli' value='" .$tableName. "'><input type='hidden' name='id_uzytkownika' value='".$id_uzytkownika."'>";
    ?>
</form>
</body>
</html>

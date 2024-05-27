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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <nav>
    <ul>
        <li><a href="#">Strona główna</a></li>
        <li><a href="welcome.php">Produkty</a></li>
        <li><a href="PokazKoszyk.php">Koszyk</a></li>
        <li><a href="konto.php">Konto</a></li>
        <li><a href="opinie.php">Opinie</a></li>
        <li><a href="#">Kontakt</a></li>
    </ul>
</nav>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Przycisk, który wywołuje rozwijaną listę -->
            <button class="btn btn-primary" id="toggleDropdown">Pokaż Dane uzykownika</button>

            <!-- Lista rozwijana -->
            <div class="dropdown mt-3" id="dropdownList" style="display: none;">
                <?php
                    print "Imie: ".$imie."<br>";
                    print "Nazwisko: ".$nazwisko."<br>";
                    print "Email: ".$email."<br>";
                    print "Telefon: ".$telefon."<br>";
                    print "Wiek: ".$wiek."<br>";
                    print "Nazwa użytkownika: ".$username."<br>";
                ?>
            </div>
        </div>
        <div class="col">
            <!-- Przycisk, który wywołuje rozwijaną listę -->
            <button class="btn btn-primary" id="toggleDropdown1">Pokaż Zamowienia</button>

            <!-- Lista rozwijana -->
            <div class="dropdown mt-3" id="dropdownList1" style="display: none;">
                <?php
                    $query1="SELECT * FROM zamowieniaklientow WHERE id_uzytkownika= ?";
                    $stmt1=mysqli_prepare($conn,$query1);
                    mysqli_stmt_bind_param($stmt1,"i",$id);
                    mysqli_stmt_execute($stmt1);
                    $result1= mysqli_stmt_get_result($stmt1);
                    while($row1=mysqli_fetch_assoc($result1))
                    {
                        print "Złozyłeś zamowienie o id".$row1['Id_zamowienia']."<br> Oto przedmioty zamowione: <br>";
                        $query2="SELECT * FROM zamowioneprzedmioty WHERE Id_zamowienia= ?";
                        $stmt2= mysqli_prepare($conn,$query2);
                        mysqli_stmt_bind_param($stmt2,"i",$row1['Id_zamowienia']);
                        mysqli_stmt_execute($stmt2);
                        $result2= mysqli_stmt_get_result($stmt2);
                        print "<table class='table table-striped table-bordered'>";
                        print "<tr><th>Nazwa</th><th>Cena</th><th>Ilosc</th></tr>";
                        while($row2=mysqli_fetch_assoc($result2))
                        {
                            $query3="SELECT * FROM przedmioty WHERE id_przedmiotu= ?";
                            $stmt3=mysqli_prepare($conn,$query3);
                            mysqli_stmt_bind_param($stmt3,"i",$row2['id_przedmiotu']);
                            mysqli_stmt_execute($stmt3);
                            $result3=mysqli_stmt_get_result($stmt3);
                            $row3=mysqli_fetch_assoc($result3);
                            print "<tr><td> ".$row3['nazwa']."</td> <td> ".$row3['cena']."</td> <td>".$row2['ilosc']."</td></tr><br>";
                        }
                        print "</table>";
                    }
                ?>
            </div>
        </div>
    </div>
    <form action='logaut.php' method='post'><input type='submit' class='btn btn-primary' value='Wyloguj'></form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        // Po kliknięciu przycisku, pokazuj lub ukrywaj listę rozwijaną
        $('#toggleDropdown').click(function(){
            $('#dropdownList').toggle();
        });
    });
    $(document).ready(function(){
        // Po kliknięciu przycisku, pokazuj lub ukrywaj listę rozwijaną
        $('#toggleDropdown1').click(function(){
            $('#dropdownList1').toggle();
        });
    });
</script>

</body>
</html>

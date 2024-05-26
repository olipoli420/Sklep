<?php
session_start();
require_once 'db_connect.php';  
if(!empty($_POST['Miejscowsc']) && !empty($_POST['Ulica']) && !empty($_POST['Adres']) && !empty($_POST['Kod_pocztowy']))
{
    if(isset($_POST['Miejscowosc']) && isset($_POST['id_uzytkownika']) && isset($_POST['nazwa_tabeli'])) 
    {
        $id_uzytkownika = $_POST['id_uzytkownika'];
        $tableName = $_POST['nazwa_tabeli'];
        $suma=0;
        $query="SELECT * FROM ? WHERE 1";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"s",$tableName);
        mysqli_stmt_execute($stmt)
        $result=mysqli_stmt_get_result($stmt);
        while($row=mysqli_fetch_assoc($result))
        {
            $query2="SELECT * FROM przedmioty WHERE id_przedmiotu= ?";
            $stmt2 = mysqli_prepare($conn,$query2);
            mysqli_stmt_bind_param($stmt2,"i", $row['id_przedmiotu']);
            mysqli_stmt_execute($stmt2);
            $result2=mysqli_stmt_get_result($stmt2);
            $row2=mysqli_fetch_assoc($result2);
            $suma=$suma+($row['ilosc']*$row2['cena']);
        }
        $queryIdZamowienia="SELECT * FROM zamowieniaklientow where id_uzytkownika= ?";
        $stmtIdZamowienia=mysqli_prepare($conn,$queryIdZamowienia);
        mysqli_stmt_bind_param($stmtIdZamowienia,"i",$id_uzytkownika);
        mysqli_stmt_execute($stmtIdZamowienia);
        $resultIdZamowienia=mysqli_stmt_get_result($stmtIdZamowienia);
        $rowIdZamowienia=mysqli_fetch_assoc($resultIdZamowienia);
        $queryprzedmioty="SELECT * FROM ? WHERE 1";
        $stmtprzedmioty=mysqli_prepare($conn,$queryprzedmioty);
        mysqli_stmt_bind_param($stmtprzedmioty,"s",$tableName);
        mysqli_stmt_execute($stmtprzedmioty);
        $resultprzedmioty=mysqli_stmt_get_result($stmtprzedmioty);
        if(mysqli_num_rows($resultprzedmioty) > 0)
        {
            $queryZamowienieK = "INSERT INTO zamowieniaklientow (id_uzytkownika, Laczna_Kwota) VALUES (?,?)";
            $stmtZamowienieK = mysqli_prepare($conn,$queryZamowienieK);
            mysqli_stmt_bind_param($stmtZamowienieK,"ii",$id_uzytkownika,$suma);
            mysqli_stmt_execute($stmtZamowienieK);
            $queryLastInsertedId = "SELECT LAST_INSERT_ID() AS last_id";
            $resultLastInsertedId = mysqli_query($conn, $queryLastInsertedId);
            $rowLastInsertedId = mysqli_fetch_assoc($resultLastInsertedId);
            $lastInsertedId = $rowLastInsertedId['last_id'];
        
            $queryprzedmioty="SELECT * FROM ? WHERE 1";
            $stmtprzedmioty=mysqli_prepare($conn,$queryprzedmioty);
            mysqli_stmt_bind_param($stmtprzedmioty,"s",$tableName);
            mysqli_stmt_execute($stmtprzedmioty);
            $resultprzedmioty=mysqli_stmt_get_result($stmtprzedmioty);
            if(mysqli_num_rows($resultprzedmioty) > 0) 
            {
                while($rowprzedmioty=mysqli_fetch_assoc($resultprzedmioty)) 
                {
                    $queryZamowienieP = "INSERT INTO zamowioneprzedmioty (Id_zamowienia, id_przedmiotu, ilosc) VALUES (?,?,?)";
                    $stmtZamowienieP=mysqli_prepare($conn,$queryZamowienieP);
                    mysqli_stmt_bind_param($stmtZamowienieP,"iii",$lastInsertedId,$rowprzedmioty['id_przedmiotu'],$rowprzedmioty['ilosc']);
                    mysqli_stmt_execute($stmtZamowienieP);
                }
                mysqli_data_seek($resultprzedmioty, 0);
                while($rowusuwanieZeStanu=mysqli_fetch_assoc($resultprzedmioty))
                {
                    $queryUsuwanieZeStanu="UPDATE przedmioty SET ilosc = ilosc - ? WHERE id_przedmiotu= ?";
                    $stmtUsuwanieZeStanu = mysqli_prepare($conn, $queryUsuwanieZeStanu);
                    mysqli_stmt_bind_param($stmtUsuwanieZeStanu,"ii",$rowusuwanieZeStanu['ilosc'],$rowusuwanieZeStanu['id_przedmiotu'])
                    mysqli_stmt_execute($stmtUsuwanieZeStanu);
                }   
                $queryUsuwanieKoszyka="DELETE FROM ? WHERE 1";
                $stmtUsuwannieKoszyka=mysqli_prepare($conn,$queryUsuwanieKoszyka);
                mysqli_stmt_bind_param($stmtUsuwannieKoszyka,"s",$tableName);
                mysqli_stmt_execute($stmtUsuwannieKoszyka);
            }
        }
        $miejscowosc=$_POST['Miejscowosc'];
        $ulica=$_POST['Ulica'];
        $adres=$_POST['Adres'];
        $kod_pocztowy=$_POST['Kod_pocztowy']; 
        $queryDostawy="INSERT INTO dostawy (id_zamowienia,Miejscowosc,Ulica,Adres,Kod_pocztowy) VALUES (?,?,?,?,?)";
        $stmtDostawy= mysqli_prepare($conn,$queryDostawy);
        mysqli_stmt_bind_param($stmtDostawy,"issss",$lastInsertedId,$miejscowosc,$ulica,$adres,$kod_pocztowy);
        mysqli_stmt_execute($stmtDostawy);

        header("Location: PokazKoszyk.php");
    } 
    else 
    {
    echo "Dane POST nie zostały przesłane.";
    }
}
else
{
    Print "Nie podano danych";
    print "<form action='PokazKoszyk.php'>";
    Print "<input type='submit' value='Wroc do koszyka'>";
    print "</form>";
}
?>

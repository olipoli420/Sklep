<?php
session_start();
require_once 'db_connect.php';  

if(isset($_POST['Miejscowosc']) && isset($_POST['id_uzytkownika']) && isset($_POST['nazwa_tabeli'])) 
{
    $id_uzytkownika = $_POST['id_uzytkownika'];
    $tableName = $_POST['nazwa_tabeli'];
    $suma=0;
    $query="SELECT * FROM $tableName WHERE 1";
    $result=mysqli_query($conn,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        $query2="SELECT * FROM przedmioty WHERE id_przedmiotu=".$row['id_przedmiotu'];
        $result2=mysqli_query($conn,$query2);
        $row2=mysqli_fetch_assoc($result2);
        $suma=$suma+($row['ilosc']*$row2['cena']);
    }
    $queryIdZamowienia="SELECT * FROM zamowieniaklientow where id_uzytkownika=$id_uzytkownika";
    $resultIdZamowienia=mysqli_query($conn,$queryIdZamowienia);
    $rowIdZamowienia=mysqli_fetch_assoc($resultIdZamowienia);
    $queryprzedmioty="SELECT * FROM $tableName WHERE 1";
    $resultprzedmioty=mysqli_query($conn,$queryprzedmioty);
    if(mysqli_num_rows($resultprzedmioty) > 0)
    {
        $queryZamowienieK = "INSERT INTO zamowieniaklientow (id_uzytkownika, Laczna_Kwota) VALUES ($id_uzytkownika, $suma)";
        mysqli_query($conn, $queryZamowienieK);
        $queryLastInsertedId = "SELECT LAST_INSERT_ID() AS last_id";
        $resultLastInsertedId = mysqli_query($conn, $queryLastInsertedId);
        $rowLastInsertedId = mysqli_fetch_assoc($resultLastInsertedId);
        $lastInsertedId = $rowLastInsertedId['last_id'];
        
        $queryprzedmioty="SELECT * FROM $tableName WHERE 1";
        $resultprzedmioty=mysqli_query($conn,$queryprzedmioty);
        
        if(mysqli_num_rows($resultprzedmioty) > 0) 
        {
            while($rowprzedmioty=mysqli_fetch_assoc($resultprzedmioty)) 
            {
                $queryZamowienieP = "INSERT INTO zamowioneprzedmioty (Id_zamowienia, id_przedmiotu, ilosc) VALUES ('$lastInsertedId', '".$rowprzedmioty['id_przedmiotu']."', '".$rowprzedmioty['ilosc']."')";
                mysqli_query($conn, $queryZamowienieP);
            }
            mysqli_data_seek($resultprzedmioty, 0);
            while($rowusuwanieZeStanu=mysqli_fetch_assoc($resultprzedmioty))
            {
                $queryUsuwanieZeStanu="UPDATE przedmioty SET ilosc = ilosc - ".$rowusuwanieZeStanu['ilosc']." WHERE id_przedmiotu=".$rowusuwanieZeStanu['id_przedmiotu'];
                mysqli_query($conn,$queryUsuwanieZeStanu);
            }   
            $queryUsuwanieKoszyka="DELETE FROM $tableName WHERE 1";
            mysqli_query($conn,$queryUsuwanieKoszyka);
        }
    }
    $miejscowosc=$_POST['Miejscowosc'];
    $ulica=$_POST['Ulica'];
    $adres=$_POST['Adres'];
    $kod_pocztowy=$_POST['Kod_pocztowy']; 
    $queryDostawy="INSERT INTO dostawy (id_zamowienia,Miejscowosc,Ulica,Adres,Kod_pocztowy) VALUES ('$lastInsertedId','$miejscowosc','$ulica','$adres','$kod_pocztowy')";
    mysqli_query($conn, $queryDostawy); 

    header("Location: PokazKoszyk.php");
} 
else 
{
    echo "Dane POST nie zostały przesłane.";
}
?>

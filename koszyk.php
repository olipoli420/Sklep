<?php
session_start();
require_once 'db_connect.php';
if(isset($_POST['id_przedmiotu'])) 
{
    // Przechwycenie identyfikatora przedmiotu
    $id_przedmiotu = $_POST['id_przedmiotu'];
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query3="SELECT id FROM uzytkownicy WHERE login='$username'";
    $result3=mysqli_query($conn, $query3);
    if($result3 && mysqli_num_rows($result3) > 0)
    {
        $row=mysqli_fetch_assoc($result3);
        $tableName="Koszyk".$row['id'];
        $query="CREATE TABLE ".$tableName." (id_przedmiotu INT,FOREIGN KEY (id_przedmiotu) REFERENCES przedmioty(id_przedmiotu) );";
        $query2="SHOW TABLES LIKE '$tableName'";
        $result2=mysqli_query($conn,$query2);
        if($result2 && mysqli_num_rows($result2)> 0)
        {   
            $query4 = "SELECT * FROM $tableName WHERE id_przedmiotu = $id_przedmiotu";
            $result4 = mysqli_query($conn, $query4);
            if(mysqli_num_rows($result4) > 0)
            {
                $query6="SELECT * FROM przedmioty WHERE id_przedmiotu=$id_przedmiotu";
                $result6=mysqli_query($conn,$query6);
                $row6=mysqli_fetch_assoc($result6);
                $result7=mysqli_query($conn,$query4);
                $row4=mysqli_fetch_assoc($result7);
                if($row4['ilosc'] < $row6['ilosc'])
                {
                    $query5="UPDATE $tableName SET ilosc= ilosc + 1 WHERE id_przedmiotu = $id_przedmiotu";
                    mysqli_query($conn,$query5);
                }
                header("Location: welcome.php");
            }
            else
            {
                $queryPrzedmioty="SELECT * FROM przedmioty WHERE id_przedmiotu=$id_przedmiotu";
                $result9=mysqli_query($conn,$queryPrzedmioty);
                $row9=mysqli_fetch_assoc($result9);
                if($row9['ilosc'] == 0)
                {

                }
                else
                {
                    $query3 = "INSERT INTO ".$tableName." (id_przedmiotu, ilosc) VALUES (".$id_przedmiotu.", 1)";
                    mysqli_query($conn, $query3);                    
                }

                header("Location: welcome.php");
            }

        }
        else
        {
            mysqli_query($conn, $query);
            $query3 = "INSERT INTO ".$tableName." (id_przedmiotu, ilosc) VALUES ($id_przedmiotu, 1)";
            mysqli_query($conn, $query3);
            header("Location: welcome.php");
        }
    } else
    {
        echo "Nie pobrało id uzytkownika";
    }

}
else
{
    echo "Nie pobrało id przedmiotu";
}
?>

<?php
session_start();
require_once 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
        }
        .star-rating input[type="radio"] {
            display: none;
        }
        .star-rating label {
            color: #bbb;
            font-size: 25px;
            cursor: pointer;
        }
        .star-rating input[type="radio"]:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f2b600;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
        }
        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .star-rating-display {
            color: #f2b600;
            font-size: 20px;
        }
    </style>
</head>
<body>
<header>
    <h1>Opinie</h1>
</header>
<nav>
    <ul>
        <li><a href="#">Strona główna</a></li>
        <li><a href="#">Produkty</a></li>
        <li><a href="PokazKoszyk.php">Koszyk</a></li>
        <li><a href="konto.php">Konto</a></li>
        <li><a href="opinie.php">Opinie</a></li>
        <li><a href="#">Kontakt</a></li>
    </ul>
</nav>
<div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="mt-4 mb-4">Opinie naszych klientów</h1>
                <?php
                $query="SELECT * FROM opinie";
                $result=mysqli_query($conn,$query);
                while($row=mysqli_fetch_assoc($result))
                {
                    $imie=htmlspecialchars($row['Imie']);
                    $tekst=htmlspecialchars($row['tekst']);
                    $stars=intval($row['gwiazdki']);
                    print   "<div class='review'>";
                    print   "<h5>".$row['Imie']."</h5>";
                    print   "<div class='star-rating-display'>";
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $stars) {
                            echo "<span class='star'>&#9733;</span>"; // Wypełniona gwiazdka
                        } else {
                            echo "<span class='star'>&#9734;</span>"; // Pusta gwiazdka
                        }
                    }
                    print   "<p class='text-muted'>".$row['data_dodania']."</p>";
                    print   "<p>".$row['tekst']."</p>";
                    print   "</div>";
                }
                ?>
                <div class="form-container">
                    <h5>Dodaj swoją opinię</h5>
                    <form action="dodajopinie.php" method="POST">
                        <div class="form-group">
                            <label for="name">Imię</label>
                            <input type="text" class="form-control" id="name" name="imie" placeholder="Twoje imię" required>
                        </div>
                        <div class="form-group">
                            <label for="review">Opinia</label>
                            <textarea class="form-control" id="review" rows="3" name="recenzja" placeholder="Twoja opinia" required></textarea>
                        </div>
                        <div class="star-rating">
                            <input type="radio" id="5-stars" name="stars" value="5" required /><label for="5-stars" class="star">&#9733;</label>
                            <input type="radio" id="4-stars" name="stars" value="4" /><label for="4-stars" class="star">&#9733;</label>
                            <input type="radio" id="3-stars" name="stars" value="3" /><label for="3-stars" class="star">&#9733;</label>
                            <input type="radio" id="2-stars" name="stars" value="2" /><label for="2-stars" class="star">&#9733;</label>
                            <input type="radio" id="1-stars" name="stars" value="1" /><label for="1-stars" class="star">&#9733;</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Dodaj opinię</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
<?php
session_start();
require_once 'db_connect.php';
$sort = isset($_POST['sortowanie']) ? $_POST['sortowanie'] : "Najn";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opinie</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
    <style>
        /* Dodatkowe style CSS */

        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: bold;
        }

        .nav-item {
            margin-right: 15px;
        }

        .reviews-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .reviews-section h1 {
            color: #343a40;
            margin-bottom: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-container h5 {
            color: #343a40;
            margin-bottom: 20px;
        }

        .star-rating label {
            color: #f2b600;
            font-size: 30px;
            cursor: pointer;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #343a40;
            border-color: #343a40;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #23272b;
            border-color: #23272b;
        }

        .btn-outline-primary {
            color: #343a40;
            border-color: #343a40;
            font-weight: bold;
        }

        .btn-outline-primary:hover {
            background-color: #f8f9fa;
            color: #343a40;
            border-color: #343a40;
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
    </style>
</head>
<body>
    <header>
        <h1>Opinie</h1>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="welcome.php">Sklep</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="welcome.php">Przedmioty</a></li>
                    <li class="nav-item"><a class="nav-link" href="PokazKoszyk.php">Koszyk</a></li>
                    <li class="nav-item"><a class="nav-link" href="opinie.php">Opinie</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="konto.php"><i class="bi bi-person-circle"></i> Konto</a></li>
                    <li class="nav-item"><a class="nav-link" href="logaut.php"><i class="bi bi-box-arrow-left"></i> Wyloguj</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="reviews-section">
            <h1>Opinie naszych klientów</h1>
            <h4>Sortowanie:</h4>
            <form action="opinie.php" method="POST">
                <select class="form-select" name="sortowanie" aria-label="Default select example" onchange="this.form.submit()">
                    <option value="Najl"<?php if($sort=="Najl") print "selected" ?>>Najlepiej oceniane</option>
                    <option value="Najg" <?php if($sort=="Najg") print "selected" ?>>Najgorzej oceniane</option>
                    <option value="Najn" <?php if($sort=="Najn") print "selected" ?>>Najnowsze</option>
                    <option value="Najs" <?php if($sort=="Najs") print "selected" ?>>Najstarsze</option>
                </select>
            </form>
            <?php
                $query = "SELECT * FROM opinie";
                switch($sort)
                {
                    case"Najn":
                        $query.=" ORDER BY data_dodania DESC";
                        break;
                    case"Najs":
                        $query.=" ORDER BY data_dodania ASC";
                        break;            
                    case"Najl":
                        $query.=" ORDER BY gwiazdki DESC";
                        break;
                    case"Najg":
                        $query.=" ORDER BY gwiazdki ASC";
                        break;
                }
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) 
                { 
                    $imie = htmlspecialchars($row['Imie']);
                    $tekst = htmlspecialchars($row['tekst']);
                    $stars = intval($row['gwiazdki']);
                    echo "<div class='review'>";
                    echo "<h5>" . $imie . "</h5>";
                    echo "<div class='star-rating-display'>";
                    for ($i = 1; $i <= 5; $i++) 
                    {
                        if ($i <= $stars) {
                            echo "<span class='star'>★</span>"; // Wypelniona gwiazdka
                        } else {
                            echo "<span class='star'>☆</span>"; // Pusta gwiazdka
                        }
                    }
                    echo "</div>";
                    echo "<p class='text-muted'>" . $row['data_dodania'] . "</p>";
                    echo "<p>" . $tekst . "</p>";
                    echo "</div>";
                    }
                    ?>
                    </div>
                    <div class="form-container">
                    <h5>Dodaj swoją opinię</h5>
                    <form action="dodajopinie.php" method="POST">
                    <div class="mb-3">
                    <label for="name" class="form-label">Imię</label>
                    <input type="text" class="form-control" id="name" name="imie" placeholder="Twoje imię" required>
                    </div>
                    <div class="mb-3">
                    <label for="review" class="form-label">Opinia</label>
                    <textarea class="form-control" id="review" rows="3" name="recenzja" placeholder="Twoja opinia" required></textarea>
                    </div>
                    <div class="star-rating mb-3">
                    <?php
                        // Wyświetlenie gwiazdek w formularzu
                        for ($i = 1; $i <= 5; $i++) {
                            echo "<input type='radio' id='star-{$i}' name='stars' value='{$i}' /><label for='star-{$i}' class='star'>★</label>";
                        }
                    ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Dodaj opinię</button>
                    </form>
                    </div>
                    </div>
                    
                    </body>
                    </html>
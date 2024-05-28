<?php
require_once 'db_connect.php';

if (isset($_POST['id_przedmiotu'])) {
    $id_przedmiotu = $_POST['id_przedmiotu'];
} else if (isset($_GET['id_przedmiotu'])) {
    $id_przedmiotu = $_GET['id_przedmiotu'];
} else {
    echo "Brak identyfikatora przedmiotu.";
    exit;
}

$query = "SELECT * FROM przedmioty WHERE id_przedmiotu = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_przedmiotu);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Sprawdź dostępność produktu
    $dostepnosc = $row['ilosc'] > 0 ? true : false;

    // Pobierz zdjęcia dla danego przedmiotu
    $queryImages = "SELECT * FROM zdjecia WHERE id_przedmiotu = ?";
    $stmtImages = mysqli_prepare($conn, $queryImages);
    mysqli_stmt_bind_param($stmtImages, "i", $id_przedmiotu);
    mysqli_stmt_execute($stmtImages);
    $resultImages = mysqli_stmt_get_result($stmtImages);
    $images = [];
    while ($rowImage = mysqli_fetch_assoc($resultImages)) {
        $images[] = $rowImage['sciezka'];
    }
} else {
    echo "Przedmiot nie znaleziony.";
    exit;
}

// Sortowanie opinii
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';
$sortQuery = "ORDER BY ";
switch ($sort) {
    case 'date_asc':
        $sortQuery .= "o.data ASC";
        break;
    case 'rating_desc':
        $sortQuery .= "o.il_gwiazdek DESC";
        break;
    case 'rating_asc':
        $sortQuery .= "o.il_gwiazdek ASC";
        break;
    case 'date_desc':
    default:
        $sortQuery .= "o.data DESC";
        break;
}

$queryOpinions = "SELECT o.*, u.imie, u.nazwisko FROM opiniePrzedmiotow o JOIN uzytkownicy u ON o.id_klienta = u.id WHERE o.id_przedmiotu = ? $sortQuery";
$stmtOpinions = mysqli_prepare($conn, $queryOpinions);
mysqli_stmt_bind_param($stmtOpinions, "i", $id_przedmiotu);
mysqli_stmt_execute($stmtOpinions);
$resultOpinions = mysqli_stmt_get_result($stmtOpinions);

// Sprawdzenie, czy użytkownik zmienił sortowanie
$openOpinions = isset($_GET['sort']);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Szczegóły produktu</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="szczegoly.css">
    <style>
        .disabled-button {
            background-color: red !important;
            cursor: not-allowed !important;
        }
        #productCarousel .carousel-item img {
            width: 100%; /* Ustawienie szerokości na 100%, aby dopasować do określonego obszaru */
            height: auto; /* Automatyczne dopasowanie wysokości, aby zachować proporcje */
            max-width: 500px; /* Maksymalna szerokość zdjęcia */
        }
    </style>
</head>
<body>
<header class="bg-dark text-white py-4">
    <div class="container text-center">
        <h1 class="display-4">Szczegóły produktu</h1>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="welcome.php">Sklep</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="welcome.php">Przedmioty</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="PokazKoszyk.php">Koszyk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="opinie.php">Opinie</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="konto.php">
                        <span class="fas fa-user"></span> Konto
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logaut.php">
                        <span class="fas fa-sign-out-alt"></span> Wyloguj
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <div id="productCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    foreach ($images as $index => $image) {
                        $activeClass = $index === 0 ? 'active' : '';
                        echo "<div class='carousel-item $activeClass'>
                                <img src='" . htmlspecialchars($image) . "' class='d-block w-100' alt='Product Image'>
                              </div>";
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($row['nazwa']); ?></h2>
            <p class="lead">Cena: <?php echo htmlspecialchars($row['cena']); ?> zł</p>
            <p class="lead">Opis: <?php echo htmlspecialchars($row['krotki_opis']); ?></p>
            <form action="dodaj_do_koszyka.php" method="POST">
                <input type="hidden" name="id_przedmiotu" value="<?php echo $id_przedmiotu; ?>">
                <button type="submit" class="btn btn-primary btn-lg <?php echo !$dostepnosc ? 'disabled-button' : ''; ?>" <?php echo !$dostepnosc ? 'disabled' : ''; ?>>
                    <?php echo !$dostepnosc ? 'Niedostępny' : 'Dodaj do koszyka'; ?>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="d-flex justify-content-around mb-3">
                <button class="btn btn-secondary option-btn" data-target="description">Opis produktu</button>
                <button class="btn btn-secondary option-btn" data-target="opinions">Opinie klientów</button>
            </div>
            <div id="description" class="option-content" style="display: <?php echo $openOpinions ? 'none' : 'block'; ?>;">
                <h3>Opis produktu</h3>
                <p><?php echo nl2br(htmlspecialchars($row['opis'])); ?></p>
            </div>
            <div id="opinions" class="option-content" style="display: <?php echo $openOpinions ? 'block' : 'none'; ?>;">
                <h3>Opinie klientów</h3>
                <div class="form-group">
                    <label for="sortOpinions">Sortuj według:</label>
                    <select class="form-control" id="sortOpinions" onchange="location = this.value;">
                        <option value="?id_przedmiotu=<?php echo $id_przedmiotu; ?>&sort=date_desc" <?php if ($sort == 'date_desc') echo 'selected'; ?>>Najpierw najnowsze</option>
                        <option value="?id_przedmiotu=<?php echo $id_przedmiotu; ?>&sort=date_asc" <?php if ($sort == 'date_asc') echo 'selected'; ?>>Najpierw najstarsze</option>
                        <option value="?id_przedmiotu=<?php echo $id_przedmiotu; ?>&sort=rating_desc" <?php if ($sort == 'rating_desc') echo 'selected'; ?>>Najwyżej oceniane</option>
                        <option value="?id_przedmiotu=<?php echo $id_przedmiotu; ?>&sort=rating_asc" <?php if ($sort == 'rating_asc') echo 'selected'; ?>>Najniżej oceniane</option>
                    </select>
                </div>
                <div id="opinionsList">
                    <?php
                    while ($opinion = mysqli_fetch_assoc($resultOpinions)) {
                        echo "<div class='card mb-3'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . htmlspecialchars($opinion['imie']) . " " . htmlspecialchars($opinion['nazwisko']) . "</h5>";
                        echo "<div class='star-rating'>";
                        $stars = intval($opinion['il_gwiazdek']);
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $stars) {
                                echo "<span class='star'>&#9733;</span>";
                            } else {
                                echo "<span class='star'>&#9734;</span>";
                            }
                        }
                        echo "</div>";
                        echo "<p class='card-text'>" . htmlspecialchars($opinion['tresc']) . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <button class="btn btn-primary mt-3" id="addOpinionBtn">Dodaj opinię</button>
                <div class="form-container" id="addOpinionForm" style="display: none;">
                    <h5>Dodaj swoją opinię</h5>
                    <form action="dodaj_opinie.php" method="POST">
                        <div class="form-group">
                            <label for="opinionContent">Treść opinii:</label>
                            <textarea class="form-control" id="opinionContent" name="opinionContent" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ilosc_gwiazdek">Ocena:</label>
                            <div class="star-rating">
                                <input type="radio" id="5-stars" name="ilosc_gwiazdek" value="5" required /><label for="5-stars" class="star">&#9733;</label>
                                <input type="radio" id="4-stars" name="ilosc_gwiazdek" value="4" /><label for="4-stars" class="star">&#9733;</label>
                                <input type="radio" id="3-stars" name="ilosc_gwiazdek" value="3" /><label for="3-stars" class="star">&#9733;</label>
                                <input type="radio" id="2-stars" name="ilosc_gwiazdek" value="2" /><label for="2-stars" class="star">&#9733;</label>
                                <input type="radio" id="1-stars" name="ilosc_gwiazdek" value="1" /><label for="1-stars" class="star">&#9733;</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Dodaj opinię</button>
                        <input type="hidden" name="id_przedmiotu" value="<?php echo $id_przedmiotu; ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const options = document.querySelectorAll(".option-btn");
    options.forEach(option => {
        option.addEventListener("click", function() {
            const targetId = this.getAttribute("data-target");
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                const allContents = document.querySelectorAll(".option-content");
                allContents.forEach(content => {
                    content.style.display = "none";
                });
                targetContent.style.display = "block";
            }
        });
    });

    const addOpinionBtn = document.getElementById("addOpinionBtn");
    const addOpinionForm = document.getElementById("addOpinionForm");

    addOpinionBtn.addEventListener("click", function() {
        if (addOpinionForm.style.display === "none" || addOpinionForm.style.display === "") {
            addOpinionForm.style.display = "block";
        } else {
            addOpinionForm.style.display = "none";
        }
    });
});
</script>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['nieudane_proby'])) {
    $_SESSION['nieudane_proby'] = 0;
    $_SESSION['czas_blokady'] = 0;
}
if (time() < $_SESSION['czas_blokady']) {
    header("Refresh: 1");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .register-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body class="container">
    <h2>Logowanie</h2>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" id="username" name="username" placeholder="Nazwa użytkownika">
        </div>
        <div class="form-group">
            <label for="password">Hasło:</label>
            <input type="password" id="password" name="password" placeholder="Hasło">
        </div>
        <button type="submit" <?php echo (time() < $_SESSION['czas_blokady']) ? 'disabled class="btn btn-danger"' : ''; ?>>Zaloguj</button>
    </form>
    <?php if(time() < $_SESSION['czas_blokady']) print "<p>Poczekaj ".$_SESSION['czas_blokady']-time()." sekund</p>";?>
    <a href="register.html" class="register-link">Nie masz jeszcze konta? Zarejestruj się tutaj</a>
</body>
</html>

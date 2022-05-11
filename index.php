<?php
    $title = 'Strona główna';
    include('base.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <div class="container">
            <div class="center_padded">
                <h2>Wirtualna Apteczka <i class="fa-solid fa-pills"></i></h2>
                <p>Dodaj swoje leki, śledź ich ilość oraz daty ważności.</p>
                    <a href = "./logowanie.php"  class="btn btn-primary"> Zaloguj się </a><br><br>
                    <!-- <a href = "./rejestracja.php" class="btn btn-secondary"> Zarejestruj się </a> -->
                    <a href = "./rejestracja_nowa_apteczka.php" class="btn btn-secondary"> Rejestracja z nową apteczką</a>
                    <a href = "./rejestracja_istniejaca.php" class="btn btn-secondary"> Rejestracja z istniejącą apteczką</a>
            </div>
        </div>
    <script src="https://kit.fontawesome.com/fbb6ee47b7.js" crossorigin="anonymous"></script>
    </body>
</html>
<?php
    $title = 'Błąd logowania';
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
        <h2 style="color:red">Logowanie nieudane</h2>
        <p>Błędny login/hasło. </p><br/>
        </form>

    <a href = "./logowanie.php"  class="btn btn-primary"> Spróbuj ponownie </a><br><br>
    <p>Nie masz jeszcze konta? <a href="./rejestracja.php">Zarejestruj się</a></p>
    <p>Powrót na<a href="./index.php"> stronę główną</a></p>

    </div>
</div>
    </body>
</html>
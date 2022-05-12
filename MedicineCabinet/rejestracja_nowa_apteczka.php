<?php
    $title = 'Rejestracja';
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
                    <h2>Rejestracja</h2><br>
                    <form method="POST" action="rejestrator_nowa_apteczka.php">
                        <input type="text" name = "imie" placeholder="Imię"><br><br>
                        <input type="email" name = "email" placeholder="E-mail"><br><br>
                        <input type="password" name = "haslo" placeholder="Hasło"><br><br>
                        <input type="text" name = "apteczka" placeholder="Nazwa apteczki"><br><br>
                        <input type="submit" name = "submit" value="Wyślij" class="btn btn-primary"><br/>
                    </form>
                    <hr color="#0275d8">
                    <?php echo "Masz już konto? " ?>
                    <a href="./logowanie.php">Zaloguj się</a><br/><br/>
                    <p>Powrót na<a href="./index.php"> stronę główną</a></p>
                </div>
        </div>
    </body>
</html>
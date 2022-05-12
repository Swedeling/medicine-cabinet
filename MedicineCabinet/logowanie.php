<?php
    $title = 'Logowanie';
    include('base.php');
    session_start();
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
        <h2>Logowanie</h2><br/>
        <form method="POST" action="login.php">
            <input type="email" name = "user_email" placeholder="E-mail"><br><br>
            <input type="password" name = "pass" placeholder="Hasło"><br><br>
            <input type="submit" name = "submit" value="Wyślij" class="btn btn-primary"><br/>
        </form>
    <hr color="#0275d8">
    <?php echo "Nie masz jeszcze konta? <br>" ?>
    <a href="./rejestracja_nowa_apteczka.php">Rejestracja z nową apteczką</a><br/>
    <a href="./rejestracja_istniejaca.php">Rejestracja z istniejącą apteczką</a><br/><br/>
    <p>Powrót na<a href="./index.php"> stronę główną</a></p>

    </div>
</div>
    </body>
</html>
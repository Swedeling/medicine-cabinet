<?php
    $title = 'Rejestracja';
    include('base.php');
    $servername = "mysql.agh.edu.pl";
    $username = "telesins";
    $password = "PWoHPsG1JofSzWm7";
    $dbname = "telesins";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM `apteczki` ORDER BY nazwaApteczki";
    $apteczki = mysqli_query($conn, $sql);
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
                    <form method="POST" action="rejestrator_istniejaca.php">
                        <input type="text" name = "imie" placeholder="Imię"><br><br>
                        <input type="email" name = "email" placeholder="E-mail"><br><br>
                        <input type="password" name = "haslo" placeholder="Hasło"><br><br>
                        <label for="apteczka">Nazwa apteczki: </label>
                        <select name = "apteczka">  
                            <option value="">--- Wybierz ---</option>  
                                <?php 
                                    while($cat =  mysqli_fetch_array($apteczki,MYSQLI_ASSOC)){
                                        $temp = $cat['nazwaApteczki'];
                                        echo "<option value='$temp'>$temp</option>";
                                }
                                ?>
                        </select><br>
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


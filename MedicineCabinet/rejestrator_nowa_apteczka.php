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

    <?php
    $user_imie=$user_email=$user_haslo=$user_apteczka="";
    function chgw($dane) {
        $dane=trim($dane);
        $dane=stripslashes($dane);
        $dane=htmlspecialchars($dane);
        return $dane;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST ["imie"])) {
            $imErr = "Musisz podac imie!";
        } else {
                $imie=chgw($_POST["imie"]);
        }
        if (empty($_POST["email"])) {
                $mailErr = "Musisz podac E-mail!";
        } else {
                $email=chgw($_POST["email"]);
        }
        if (empty($_POST["haslo"])) {
                $passErr = "Musisz podać hasło!";
        } else {
                $password_form = chgw($_POST["haslo"]);
        }
        if (empty($_POST["apteczka"])) {
            $aptErr = "Musisz podać nazwę apteczki!";
        } else {
                $apteczka = chgw($_POST["apteczka"]);
        }
    }
    $servername = "mysql.agh.edu.pl";
    $username = "telesins";
    $password = "********";
    $dbname = "telesins";

    $dbconn = mysqli_connect($servername, $username, $password, $dbname);
    $user_imie = mysqli_real_escape_string($dbconn, $imie);
    $user_email = mysqli_real_escape_string($dbconn, $email);
    $user_haslo = mysqli_real_escape_string($dbconn, $password_form);
    $user_apteczka = mysqli_real_escape_string($dbconn, $apteczka);

    $esql = "SELECT * FROM users WHERE email ='$user_email'";
    $sql_apteczka = "SELECT * FROM apteczki WHERE nazwaApteczki = '$user_apteczka'";
    if (mysqli_fetch_row(mysqli_query($dbconn,$esql)) > 0) {
        echo"<div class='container'><div class='center_padded'>";
        echo "<h1 style='color:red;'>Ten email już jest w bazie</h1><br/>";
        echo"<a href='./index.php' class = 'btn btn-primary'>Strona główna</a><br></div></div>";
    } elseif (mysqli_fetch_row(mysqli_query($dbconn,$sql_apteczka)) > 0){
        echo"<div class='container'><div class='center_padded'>";
        echo "<h1 style='color:red;'>Ta apteczka już jest w bazie</h1><br/>";
        echo"<a href='./index.php' class = 'btn btn-primary'>Strona główna</a><br></div></div>";
    } else {
        echo "nie udało sie<br>";
        $user_password_hash = password_hash($user_haslo, PASSWORD_DEFAULT);
        echo "<br>".$imErr."<br>".$mailErr."<br>".$passErr;
        $sql = "INSERT INTO apteczki (nazwaApteczki) VALUES ('$user_apteczka')";
        mysqli_query($dbconn,$sql);
        $sql2 = "INSERT INTO users (imie, email, haslo, apteczki_idapteczki) 
        VALUES ('$user_imie', '$user_email', '$user_password_hash', 
        (SELECT idapteczki FROM apteczki WHERE nazwaApteczki='$user_apteczka'))";
        if (mysqli_query($dbconn, $sql2)){
            header('Location: sukces_rejestracja.php');
        } else {
            echo "Nieoczekiwany błąd";
        }
    }
?>
    </body>
</html>


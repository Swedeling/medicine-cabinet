<?php
    $title = 'Rejestracja';
    include('base.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Rejestracja</title>
    </head>
    <body>

    <?php
    $user_imie=$user_email=$user_haslo="";
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
    }
    $servername = "mysql.agh.edu.pl";
    $username = "telesins";
    $password = "***********";
    $dbname = "telesins";

    $dbconn = mysqli_connect($servername, $username, $password, $dbname);
    $user_imie = mysqli_real_escape_string($dbconn, $imie);
    $user_email = mysqli_real_escape_string($dbconn, $email);
    $user_haslo = mysqli_real_escape_string($dbconn, $password_form);

    $user_password_hash = password_hash($user_haslo, PASSWORD_DEFAULT);

    echo "<br>".$imErr."<br>".$mailErr."<br>".$passErr;

if (mysqli_query($dbconn, "INSERT INTO users (imie, email, haslo) VALUES ('$user_imie', '$user_email', '$user_password_hash')")){
    header('Location: sukces_rejestracja.php');
} else {
    echo "Nieoczekiwany błąd";
}
?>
    </body>
</html>


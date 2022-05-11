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
<?php
    $servername = "mysql.agh.edu.pl";
    $username = "telesins";
    $password = "**********";
    $dbname = "telesins";

    $dbconn = mysqli_connect($servername, $username, $password, $dbname);
    $user_password = mysqli_real_escape_string($dbconn, $_POST["pass"]);
    $user_email = mysqli_real_escape_string($dbconn, $_POST["user_email"]);
    $query = mysqli_query($dbconn,"SELECT * FROM users WHERE email = '$user_email'");

    if (mysqli_num_rows($query) > 0) {
        $record = mysqli_fetch_assoc($query);
        $hash = $record["haslo"];

        if (password_verify($user_password, $hash)) {
            $_SESSION["current_user"] = $record["iduser"];
            $_SESSION["current_apteczka"] = $record["apteczki_idapteczki"];
        }
    }

    if (isset($_SESSION["current_user"])) {
        echo "Użytkownik jest zalogowany: ".$_SESSION["current_user"];
        header('Location: userpage.php');
    } else {
        header('Location: login_fail.php'); 
    }
    ?>
</body>
</html>

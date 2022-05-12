<?php
    $title = 'Utylizacja leku';
    include('base.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <link rel="stylesheet" href="styles.css">
    </head>
    <div class="container">
                <div class="center_padded">
    <body>

        <?php
        session_start();

        $current_apteczka = $_SESSION["current_apteczka"];
        $lekid=$uzytkownik="";

        $current_apteczka= $_SESSION["current_apteczka"];
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $lekid = $_POST['lekid'];
            $nazwaleku=$_POST['nazwaLeku'];
            $uzytkownik = $_SESSION["current_user"];
            $lekil=$_POST['lekil'];
            $data = $_POST["datawazn"];
            $idapteczki = $_POST["idapteczki"];
            $idleki_w_apteczce = $_POST["idleki_w_apteczce"];
            $uzytkownik = $_SESSION["current_user"];
        }

        $servername = "mysql.agh.edu.pl";
        $username = "telesins";
        $password = "*********";
        $dbname = "telesins";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        /*$sql1 = "SET FOREIGN_KEY_CHECKS=0";
        $result = mysqli_query($conn, $sql1);*/
        $sql_delete = "UPDATE `leki_w_apteczce` SET `is_deleted` = 1 WHERE `idleki_w_apteczce` = $idleki_w_apteczce";
        $sql_oper = "INSERT INTO `operacje` (`nazwaOperacji`, `ilosc`, `dataOperacji`, `users_iduser`, `apteczki_idapteczki`, `idleki_w_apteczce`) 
        VALUES ('utylizacja', '".$lekil."', CURRENT_DATE(), '".$uzytkownik."','".$idapteczki."','".$idleki_w_apteczce."')";
        //$sql = "DELETE FROM `leki_w_apteczce` WHERE `idleki_w_apteczce` = $idleki_w_apteczce";
        /*
        if ((mysqli_query($conn, $sql_oper)) &&  (mysqli_query($conn, $sql))){
            echo "Zutylizowano lek " .$nazwaleku. " pomyślnie! <br>";
        } else {
            echo"Błąd: " . $sql_oper . "<br>" . mysqli_error($conn);
            echo"Błąd: " . $sql . "<br>" . mysqli_error($conn);
        }
        */
        if (mysqli_query($conn, $sql_delete) && mysqli_query($conn, $sql_oper)){
            echo "Zutylizowano lek " .$nazwaleku. " pomyślnie! <br>";
        } else {
            echo"Błąd: " . $sql_oper . "<br>" . mysqli_error($conn);
        }
        
        
        echo"<br><a href='./userpage.php' class='btn btn-secondary'>Strona główna</a>";
        ?>
        </div>
    </div>
    </body>
    </html>

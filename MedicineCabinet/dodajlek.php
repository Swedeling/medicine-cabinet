<?php
    $title = 'Dodano lek';
    include('base.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <div class="container"><div class="center_padded">

    <?php
    session_start();

    $lekname=$lek_ilosc=$datawazn="";

    $servername = "mysql.agh.edu.pl";
    $username = "telesins";
    $password = "***********";
    $dbname = "telesins";
    $uzytkownik = $_SESSION["current_user"];
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
    $sql_idapteczki = "SELECT apteczki_idapteczki FROM users WHERE iduser = $uzytkownik";
    $result = mysqli_query($conn, $sql_idapteczki);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $idapteczki = $row['apteczki_idapteczki'];
            }}

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $lekname=$_POST["lekname"];
            $sql = "SELECT `idLeku` FROM `baza_lekow` WHERE `nazwaLeku` = '".$lekname."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $lekId = $row['idLeku'];
            $lek_ilosc=$_POST["lek_ilosc"];
            $datawazn = $_POST["datawazn"];
            $cena = $_POST["cena"];
            $not_deleted = 0;
        }

        $sql = "INSERT INTO leki_w_apteczce 
        (apteczki_idapteczki, baza_lekow_idleku, ilosc_kupiona, ilosc_pozostala, cena, datawazn, users_iduser, is_deleted) 
        VALUES ('".$idapteczki."','".$lekId."','".$lek_ilosc."','".$lek_ilosc."','".$cena."','".$datawazn."',
        '".$uzytkownik."', '".$not_deleted."')";

        if (mysqli_query($conn, $sql)) {
            echo "<h2 style='color:green'>Dopisano lek!</h2><br><br>";
        } else {
            echo "Błąd: " . $sql . "<br>" . mysqli_error($conn);
        }

        $sql_max_id = "SELECT MAX(idleki_w_apteczce) AS current_apteczka_id FROM leki_w_apteczce";
        $result = mysqli_query($conn, $sql_max_id );
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $idleki_w_apteczce = $row['current_apteczka_id'];
            }}

        $sql_oper = "INSERT INTO `operacje` (`nazwaOperacji`, `ilosc`, `dataOperacji`, `users_iduser`, `apteczki_idapteczki`, `idleki_w_apteczce`) VALUES ('zakup', '".$lek_ilosc."', CURRENT_DATE(), '".$uzytkownik."','".$idapteczki."','".$idleki_w_apteczce."')";
        if (mysqli_query($conn, $sql_oper)){
            echo "<h2>Dopisano!</h2><br>";
        } else {
            echo "Błąd: " . $sql_oper . "<br>" . mysqli_error($conn);
        }
        echo"<a href='./userBazaLekow.php' class='btn btn-primary'>Zawartość apteczki</a><br>";
        
    ?>
        </div></div>
    </body>
</html>

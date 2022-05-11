<?php
    $title = 'Apteczka';
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
        $password = "PWoHPsG1JofSzWm7";
        $dbname = "telesins";
        $uzytkownik = $_SESSION["current_user"];
        $apteczka = $_SESSION["current_apteczka"];

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

            echo"<div class='container'>
            <div class='row justify-content-md-center'>
                <div class='col'></div>
                <div class='col-md-auto' style='padding-bottom:25px; padding-top:25px; align-content:center;justify-content:center;border:solid #0275d8;border-radius:25px;border-width:2px;'>";

            // $sql = "SELECT BazaLekow.lekID, BazaLekow.nazwaLeku, userLeki.iloscLeku, userLeki.dataLeku FROM BazaLekow INNER JOIN userLeki ON  BazaLekow.lekID = userLeki.lekID AND userLeki.userId =  AND userLeki.dataLeku <  CURRENT_DATE() ORDER BY nazwaLeku";
            $sql = "SELECT baza_lekow.idleku, baza_lekow.nazwaLeku, leki_w_apteczce.ilosc_pozostala, leki_w_apteczce.datawazn , leki_w_apteczce.idleki_w_apteczce
            FROM baza_lekow 
            INNER JOIN leki_w_apteczce ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku 
            AND leki_w_apteczce.apteczki_idapteczki = ".$apteczka." AND leki_w_apteczce.datawazn < CURRENT_DATE() 
            WHERE leki_w_apteczce.is_deleted = 0 
            ORDER BY nazwaLeku";
            $result = mysqli_query($conn, $sql);
            $numer = 1;
            $link = "Zażyj";
            echo "";
            $color = "style='color:red';";
            if (mysqli_num_rows($result) > 0) {
                echo "<h2>Leki do utylizacji:</h2><br/>"; 
                echo"<table style ='margin-left:auto;margin-right:auto' class='table table-bordered table-striped w-auto'><thead class='thead-dark w-auto'><tr><th>Numer</th><th>Nazwa</th><th>Ilość</th><th>Data ważności</th><th>Utylizacja</th></tr></thead><tbody>";
                while($row = mysqli_fetch_assoc($result)) {
                    $id =$row['idleku'];
                    $date =$row['datawazn'];
                    $ilosc = $row['ilosc_pozostala'];
                    $id_leku_w_apteczce = $row['idleki_w_apteczce'];
                    echo "<tr><td>".$numer."</td><td>".$row['nazwaLeku']."</td><td>".$row['ilosc_pozostala']."</td><td ".$color.">".$row['datawazn']."</td><td>"."<a href = './utylizuj.php?ajdi=$id&date=$date&ile=$ilosc&idapteczki=$apteczka&idleki_w_apteczce=$id_leku_w_apteczce' class='btn btn-danger btn-sm'>Zutylizuj</a>"."</td></tr>";
                    $numer += 1;
                }
                } else {
                    echo "<h2>Nie masz w apteczce nic do utylizacji</h2><hr color='#0275d8'>";
                }
                mysqli_close($conn);

            echo"</tbody></table>";
            echo"<div class='row justify-content-md-center'><div class='col-md-auto' style='padding-bottom:25px;'> <a href = './userBazaLekow.php' class='btn btn-primary'> Twoje leki </a><br></div></div>";
            echo"<div class='row justify-content-md-center'><div class='col-md-auto'><a href = './nowylek.php' class='btn btn-primary'> Dodaj lek </a> <a href = './bazaLekow.php' class='btn btn-secondary'> Baza leków </a> <a href = './historia.php' class='btn btn-secondary'> Historia operacji </a> <a href = './raport_kosztow.php' class='btn btn-secondary'> Raport kosztów </a> <a href='./wyloguj.php' class='btn btn-danger'> Wyloguj </a> </div></div></div>";
            echo"<div class='col'></div></div></div>";
            ?>
    </body>
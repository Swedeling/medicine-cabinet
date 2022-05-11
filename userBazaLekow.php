<?php
    $title = 'Twoja apteczka';
    include('base.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Twoja apteczka</title>
        <link rel="stylesheet" href="styles.css">
    </head>
<body>
<?php
    session_start();
    $servername = "mysql.agh.edu.pl";
    $username = "telesins";
    $password = "PWoHPsG1JofSzWm7";
    $dbname = "telesins";
    $uzytkownik = $_SESSION["current_user"];
    $idapteczki = $_SESSION["current_apteczka"];
    $numer = 1;
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $not_deleted = 0;
    
    echo"<div class='container'>
    <div class='row justify-content-md-center'>
        <div class='col'></div>
        <div class='col-md-auto' style='padding-bottom:25px; padding-top:25px; align-content:center;justify-content:center;border:solid #0275d8;border-radius:25px;border-width:2px;'>";
    
    $sql = "SELECT baza_lekow.nazwaLeku, baza_lekow.subst_czynna, 
        leki_w_apteczce.baza_lekow_idleku, leki_w_apteczce.idleki_w_apteczce, leki_w_apteczce.apteczki_idapteczki, leki_w_apteczce.datawazn, leki_w_apteczce.users_iduser, 
        SUM(leki_w_apteczce.ilosc_pozostala) AS suma 
        FROM baza_lekow 
        INNER JOIN leki_w_apteczce 
        ON leki_w_apteczce.baza_lekow_idLeku = baza_lekow.idleku AND apteczki_idapteczki =".$idapteczki."
        WHERE leki_w_apteczce.is_deleted =".$not_deleted." 
        GROUP BY nazwaLeku, datawazn";
    
        $result = mysqli_query($conn, $sql);
        $link = "Zażyj";


    if (mysqli_num_rows($result) > 0) {
        echo "<h2 style='text-align:center'>Twoja apteczka:</h2>"; 
        echo"<table class='table table-bordered table-striped w-auto'><thead class='thead-dark w-auto'><tr style='text-align:center'><th>Numer</th><th>Nazwa</th><th>Substancja czynna</th><th>Ilość</th><th>Data ważności</th><th>Zażyj</th><th>Zutylizuj</th></tr></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            $id =$row['baza_lekow_idleku'];
            $date =$row['datawazn'];
            $ilosc = $row['suma'];
            $idleki_w_apteczce = $row['idleki_w_apteczce'];
            echo "<tr><td>".$numer."</td><td>".$row['nazwaLeku']."</td><td>".$row['subst_czynna']."</td><td>".$row['suma']."</td><td>".$row['datawazn']."</td><td>"."<a href = './zazycie.php?ajdi=$id&date=$date&ile=$ilosc&idapteczki=$idapteczki&idleki_w_apteczce=$idleki_w_apteczce' class='btn btn-secondary btn-sm'>Zażyj</a>"."</td><td>"."<a href = './utylizuj.php?ajdi=$id&date=$date&ile=$ilosc&idapteczki=$idapteczki&idleki_w_apteczce=$idleki_w_apteczce' class='btn btn-danger btn-sm'>Zutylizuj</a>"."</td></tr>";
            $numer += 1;
         }
        } else {
            echo "<center><h4>Twoja apteczka jest jeszcze pusta. Dodaj swoje leki :) </h4></center><br>";
        }
        mysqli_close($conn);

        echo"</tbody></table>";
        echo"<div class='row'><div class=col-8 col-sm-6><a href = './userpage.php' class='btn btn-secondary'> Strona główna </a></div>";
        echo"<div class=col-4 col-sm-6 align='right'><a href = './nowylek.php' class='btn btn-primary'> Dodaj lek </a></div></div></div>";
        echo"<div class='col'></div></div></div>";
?>
    </body>
</html>
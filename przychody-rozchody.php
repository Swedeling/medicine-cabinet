<?php
    $title = 'Raport szczegółowy';
    include('base.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
session_start();
echo "<meta charset='UTF-8'>";

$servername = "mysql.agh.edu.pl";
$username = "telesins";
$password = "PWoHPsG1JofSzWm7";
$dbname = "telesins";
$numer = 1;
$uzytkownik = $_SESSION["current_user"];
$idapteczki = $_SESSION["current_apteczka"];

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $operacja=$_POST["operacja"];
    $data_od = $_POST["data_od"];
    $data_do = $_POST["data_do"];
}
$conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

echo"<div class='container'>
<div class='row justify-content-md-center'>
    <div class='col-md-auto'></div>
    <div class='col-md-auto' style='padding-bottom:25px; padding-top:25px; align-content:center;justify-content:center;border:solid #0275d8;border-radius:25px;border-width:2px;'>";

    echo"<h2>Raport za okres od $data_od do $data_do</h2><br><br>";

    $sql = "SELECT  operacje.idOperacji, operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.idleki_w_apteczce, 
        leki_w_apteczce.cena,leki_w_apteczce.ilosc_kupiona, leki_w_apteczce.idleki_w_apteczce, 
        baza_lekow.nazwaLeku, baza_lekow.idleku
        FROM ((operacje 
        INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) 
        INNER JOIN baza_lekow ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku) 
        WHERE operacje.dataOperacji <= '$data_do' AND operacje.dataOperacji >= '$data_od' AND operacje.apteczki_idapteczki = $idapteczki AND operacje.nazwaOperacji = '$operacja' ORDER BY operacje.dataOperacji, operacje.idOperacji";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {


    echo"<table style ='margin-left:auto;margin-right:auto' class='table table-bordered table-striped w-auto'><thead class='thead-dark w-auto'><tr><th>Numer</th><th>Typ operacji</th><th>Nazwa leku</th><th>Data operacji</th><th>Ilość</th><th>Koszt (zł)</th></tr></thead><tbody>";
    $suma = 0;    
    while($row = mysqli_fetch_assoc($result)) {
            if ($row['nazwaOperacji'] != 'zakup'){
                $cena = ($row["cena"] / $row["ilosc_kupiona"])*$row["ilosc"];
            } else{
                $cena = $row["cena"];
            }
            $suma += $cena;
            $cena = round($cena,2);
            echo "<tr><td>".$numer."</td><td>".$row["nazwaOperacji"]."</td><td>".$row["nazwaLeku"]."</td><td>".$row["dataOperacji"]."</td><td>".$row["ilosc"]."</td><td>".$cena."</td></tr>";
            $numer += 1;
    }
} else {
    echo "Brak wyników!";
}

mysqli_close($conn);

echo"</tbody></table>";
$suma = round($suma,2);
echo '<h4><center>SUMA: '.$suma.' zł</center><h4><br>';
"</div>";
?>
    <a href = "./userpage.php" class="btn btn-secondary"> Strona główna </a>
    <a href = "./raport_kosztow.php" class="btn btn-secondary"> Raport kosztów </a>
    <?php echo"<div class='col-md-auto'></div></div></div>";?>
</body>
</html>

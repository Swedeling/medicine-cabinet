<?php
    $title = 'Historia';
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

$servername = "mysql.agh.edu.pl";
$username = "telesins";
$password = "PWoHPsG1JofSzWm7";
$dbname = "telesins";
$numer = 1;
$uzytkownik = $_SESSION["current_user"];
$idapteczki = $_SESSION["current_apteczka"];

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $operacja=$_POST["operacja"];
    $user = $_POST["user"];
    $data_od = $_POST["data_od"];
    $data_do = $_POST["data_do"];
    $lekname = $_POST["lekname"];
}
$conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

echo"<div class='container'>
<div class='row justify-content-md-center'>
    <div class='col-md-auto'></div>
    <div class='col-md-auto' 
    style='padding-bottom:25px; padding-top:25px; align-content:center;justify-content:center;
    border:solid #0275d8;border-radius:25px;border-width:2px;'>";

    echo"<center><h2>Historia operacji</h2></center><br>";

    if ($operacja != 'wszystkie' && $user != 'wszyscy' && $lekname != 'wszystkie'){
        $sql = "SELECT  operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.users_iduser, users.imie, users.iduser, operacje.idleki_w_apteczce, leki_w_apteczce.idleki_w_apteczce, baza_lekow.nazwaLeku, baza_lekow.idleku  FROM (((operacje INNER JOIN users ON users.iduser = operacje.users_iduser AND operacje.apteczki_idapteczki = $idapteczki AND operacje.nazwaOperacji = '$operacja' AND users.imie = '$user') INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) INNER JOIN baza_lekow ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku AND baza_lekow.nazwaLeku = '$lekname') WHERE operacje.dataOperacji <= '$data_do' AND operacje.dataOperacji >= '$data_od'";
    } elseif ($operacja == 'wszystkie' && $user != 'wszyscy' && $lekname != 'wszystkie') {
        $sql = "SELECT  operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.users_iduser, users.imie, users.iduser, operacje.idleki_w_apteczce, leki_w_apteczce.idleki_w_apteczce, baza_lekow.nazwaLeku, baza_lekow.idleku  FROM (((operacje INNER JOIN users ON users.iduser = operacje.users_iduser AND operacje.apteczki_idapteczki = $idapteczki AND users.imie = '$user') INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) INNER JOIN baza_lekow ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku AND baza_lekow.nazwaLeku = '$lekname') WHERE operacje.dataOperacji <= '$data_do' AND operacje.dataOperacji >= '$data_od'";
    } elseif ($operacja == 'wszystkie' && $user == 'wszyscy' && $lekname != 'wszystkie'){
        $sql = "SELECT  operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.users_iduser, users.imie, users.iduser, operacje.idleki_w_apteczce, leki_w_apteczce.idleki_w_apteczce, baza_lekow.nazwaLeku, baza_lekow.idleku  FROM (((operacje INNER JOIN users ON users.iduser = operacje.users_iduser AND operacje.apteczki_idapteczki = $idapteczki) INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) INNER JOIN baza_lekow ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku AND baza_lekow.nazwaLeku = '$lekname') WHERE operacje.dataOperacji <= '$data_do' AND operacje.dataOperacji >= '$data_od'";
    } elseif ($operacja == 'wszystkie' && $user != 'wszyscy' && $lekname == 'wszystkie'){
        $sql = "SELECT  operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.users_iduser, users.imie, users.iduser, operacje.idleki_w_apteczce, leki_w_apteczce.idleki_w_apteczce, baza_lekow.nazwaLeku, baza_lekow.idleku  FROM (((operacje INNER JOIN users ON users.iduser = operacje.users_iduser AND operacje.apteczki_idapteczki = $idapteczki AND users.imie = '$user') INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) INNER JOIN baza_lekow ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku) WHERE operacje.dataOperacji <= '$data_do' AND operacje.dataOperacji >= '$data_od'";
    } elseif ($operacja == 'wszystkie' && $user == 'wszyscy' && $lekname == 'wszystkie'){
        $sql = "SELECT  operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.users_iduser, users.imie, users.iduser, operacje.idleki_w_apteczce, leki_w_apteczce.idleki_w_apteczce, baza_lekow.nazwaLeku, baza_lekow.idleku  FROM (((operacje INNER JOIN users ON users.iduser = operacje.users_iduser AND operacje.apteczki_idapteczki = $idapteczki) INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) INNER JOIN baza_lekow ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku) WHERE operacje.dataOperacji <= '$data_do' AND operacje.dataOperacji >= '$data_od'";
    } elseif ($operacja != 'wszystkie' && $user == 'wszyscy' && $lekname != 'wszystkie'){
        $sql = "SELECT  operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.users_iduser, users.imie, users.iduser, operacje.idleki_w_apteczce, leki_w_apteczce.idleki_w_apteczce, baza_lekow.nazwaLeku, baza_lekow.idleku  FROM (((operacje INNER JOIN users ON users.iduser = operacje.users_iduser AND operacje.apteczki_idapteczki = $idapteczki AND operacje.nazwaOperacji = '$operacja') INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) INNER JOIN baza_lekow ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku AND baza_lekow.nazwaLeku = '$lekname') WHERE operacje.dataOperacji <= '$data_do' AND operacje.dataOperacji >= '$data_od'";
    }elseif ($operacja != 'wszystkie' && $user == 'wszyscy' && $lekname == 'wszystkie'){
        $sql = "SELECT  operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.users_iduser, users.imie, users.iduser, operacje.idleki_w_apteczce, leki_w_apteczce.idleki_w_apteczce, baza_lekow.nazwaLeku, baza_lekow.idleku  FROM (((operacje INNER JOIN users ON users.iduser = operacje.users_iduser AND operacje.apteczki_idapteczki = $idapteczki AND operacje.nazwaOperacji = '$operacja') INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) INNER JOIN baza_lekow ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku) WHERE operacje.dataOperacji <= '$data_do' AND operacje.dataOperacji >= '$data_od'";
    } elseif ($operacja != 'wszystkie' && $user != 'wszyscy' && $lekname == 'wszystkie'){
        $sql = "SELECT  operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.users_iduser, users.imie, users.iduser, operacje.idleki_w_apteczce, leki_w_apteczce.idleki_w_apteczce, baza_lekow.nazwaLeku, baza_lekow.idleku  FROM (((operacje INNER JOIN users ON users.iduser = operacje.users_iduser AND operacje.apteczki_idapteczki = $idapteczki AND operacje.nazwaOperacji = '$operacja' AND users.imie = '$user') INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) INNER JOIN baza_lekow ON baza_lekow.idleku = leki_w_apteczce.baza_lekow_idleku) WHERE operacje.dataOperacji <= '$data_do' AND operacje.dataOperacji >= '$data_od'";
    }
    
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo"<table style ='margin-left:auto;margin-right:auto' class='table table-bordered table-striped w-auto'><thead class='thead-dark w-auto'><tr><th>Numer</th><th>Typ operacji</th><th>Nazwa leku</th><th>Data operacji</th><th>Ilość</th><th>Użytkownik</th></tr></thead><tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$numer."</td><td>".$row["nazwaOperacji"]."</td><td>".$row["nazwaLeku"]."</td><td>".$row["dataOperacji"]."</td><td>".$row["ilosc"]."</td><td>".$row["imie"]."</td></tr>";
                $numer += 1;}
    } else {
        echo "Brak wyników!";
    }

    mysqli_close($conn);

    echo"</tbody></table>";
?>

    <hr color="#0275d8">
    <?php
    echo"<div class='row justify-content-md-center'>
    <div class='col-md-auto' style='padding-bottom:25px;'>
    <a href = './userpage.php' class='btn btn-secondary'> Strona główna </a>  
    <a href = './historia.php' class='btn btn-secondary'> Powrót do historii </a><br></div></div>";
    echo"<div class='col-md-auto'></div></div></div>"; ?>
    </body>
</html>
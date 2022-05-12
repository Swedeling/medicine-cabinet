<?php
    $title = 'Zażyto lek!';
    include('base.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
            <div class="center_padded">
<?php
session_start();
echo "<meta charset='UTF-8'>";

$lekid = $lekil = $uzytkownik="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $lekid = $_POST["lekid"];
    $idleki_w_apteczce = $_POST["idleki_w_apteczce"];
    $lekil = $_POST["lekil"];
    $data = $_POST["datawazn"];
    $idapteczki = $_POST["idapteczki"];
    $uzytkownik = $_SESSION["current_user"];
}

$servername = "mysql.agh.edu.pl";
$username = "telesins";
$password = "**********";
$dbname = "telesins";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO `operacje` (`nazwaOperacji`, `ilosc`, `dataOperacji`, `users_iduser`, `apteczki_idapteczki`, `idleki_w_apteczce`) VALUES ('zażycie', '".$lekil."', CURRENT_DATE(), '".$uzytkownik."','".$idapteczki."','".$idleki_w_apteczce."')";
if (mysqli_query($conn, $sql)){
    echo "<h2>Dopisano!</h2><br>";
} else {
    echo "Błąd: " . $esql . "<br>" . mysqli_error($conn);
}


$esql = "SELECT ilosc_pozostala FROM `leki_w_apteczce` WHERE `idleki_w_apteczce` = '$idleki_w_apteczce' AND `apteczki_idapteczki` = '$idapteczki'";
$eresult = mysqli_query($conn, $esql);

if (mysqli_num_rows($eresult) > 0) {
    while($erow = mysqli_fetch_assoc($eresult)) {
        $zostalo = $erow["ilosc_pozostala"] - $lekil;
    }
}

$sqle = "UPDATE `leki_w_apteczce` SET `ilosc_pozostala`= $zostalo WHERE `idleki_w_apteczce` = '$idleki_w_apteczce' AND `apteczki_idapteczki` = '$idapteczki'";

if (mysqli_query($conn, $sqle)){
    echo "<h2>Zaktualizowano!</h2><br>";
} else {
    echo "Błąd: " . $sqle . "<br>" . mysqli_error($conn);
}

?><br>
<a href = './nowylek.php' class="btn btn-primary"> Dodaj lek </a>
<a href = './userpage.php' class="btn btn-secondary"> Strona główna </a>
<a href = './userBazaLekow.php'  class="btn btn-secondary"> Podgląd apteczki </a>
</div>
</div>
</body>
</html>

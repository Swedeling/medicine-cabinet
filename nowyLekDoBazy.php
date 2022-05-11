<!DOCTYPE html>
<html>
<head>
        <meta charset = "UTF-8">
        <title>Dodawanie leku do bazy</title>
        <link rel="stylesheet" href="styles.css">
    </head>
<body>
<?php
session_start();
echo "<meta charset='UTF-8'>";
include('base.php');
$lekname=$leksubst="";

function chgw($dane) {
    $dane = trim($dane);
    $dane = stripslashes($dane);
    $dane = htmlspecialchars($dane);
    return $dane;
}

$userId = $_SESSION["current_user"]; 

$servername = "mysql.agh.edu.pl";
$username = "telesins";
$password = "*********";
$dbname = "telesins";
$conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $lekname=$_POST["lekname"];
    $leksubst=$_POST["leksubst"];
    
    $esql = "SELECT * FROM baza_lekow WHERE nazwaLeku ='$lekname'";
    if (mysqli_fetch_row(mysqli_query($conn,$esql)) > 0) {
        echo"<div class='container'><div class='center_padded'>";
        echo "<h1 style='color:red;'>Ten lek już jest w bazie</h1><br/>";
        echo"<a href='./bazaLekow.php' class = 'btn btn-primary'>Baza leków</a><br></div></div>";
    } 
    else {
        $sql = "INSERT INTO baza_lekow (nazwaLeku, subst_czynna) VALUES ('$lekname', '$leksubst')";
            if (mysqli_query($conn, $sql)) {
                echo "Dopisano!";
                header('Location: bazaLekow.php');
            } else {
                echo "Błąd: " . $sql . "<br>" . mysqli_error($conn);
            }
            echo"<a href='./bazaLekow.php' class = 'btn btn-primary'>Baza leków</a><br>";
}
}

?>
</body>
</html>

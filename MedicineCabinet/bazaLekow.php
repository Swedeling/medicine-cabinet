<?php
    $title = 'Baza leków';
    include('base.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <link rel="stylesheet" href="styles.css">
    </head>

<body>
<div class="text-center">
<h4>Leki znajdujące się w bazie: </h4><br/>
    <?php
        $servername = "mysql.agh.edu.pl";
        $username = "telesins";
        $password = "**************";
        $dbname = "telesins";
        $numer = 1;

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo"<table style ='margin-left:auto;margin-right:auto' class='table table-bordered table-striped w-auto'>
        <thead class='thead-dark w-auto'><tr><th>Numer</th><th>Nazwa</th><th>Substancja czynna</th></tr></thead>";

        $sql = "SELECT * FROM baza_lekow ORDER BY nazwaLeku";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$numer."</td><td>".$row["nazwaLeku"]."</td><td>".$row["subst_czynna"]."</td></tr>";
                $numer += 1;
            }
            } else {
                echo "brak wyników!";
            }
            mysqli_close($conn);
        echo"</table><br/>";
        ?>
    </div>
    <div class="text-center">
    <a href = "./nowapozycja.php" class="btn btn-primary"> Dodaj nowy lek do bazy </a><br/><br/>
    <a href = "./userpage.php" class="btn btn-secondary"> Powrót na stronę główną </a><br/><br/>
</div>
<html>

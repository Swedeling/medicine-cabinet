<?php
    $title = 'Raport kosztów';
    include('base.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
<?php 
    session_start();
    $servername = "mysql.agh.edu.pl";
    $username = "telesins";
    $password = "PWoHPsG1JofSzWm7";
    $dbname = "telesins";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $numer = 1;
    $uzytkownik = $_SESSION["current_user"];
    $idapteczki =  $_SESSION["current_apteczka"];

    echo"<div class='container'>
    <div class='row justify-content-md-center'>
    <div class='col-md-auto'></div>
    <div class='col-md-auto' style='padding-bottom:25px; padding-top:25px; align-content:center;justify-content:center;border:solid #0275d8;border-radius:25px;border-width:2px;'>";
    echo"<h2><center>Raport kosztów </center></h2><br>";

    $sql = "SELECT operacje.idleki_w_apteczce, operacje.nazwaOperacji, leki_w_apteczce.idleki_w_apteczce, leki_w_apteczce.cena, leki_w_apteczce.ilosc_kupiona,
            SUM(leki_w_apteczce.cena) as cena_sum, 
            SUM(operacje.ilosc) as ilosc,  
            EXTRACT(MONTH FROM operacje.dataOperacji) as month 
            FROM operacje 
            INNER JOIN leki_w_apteczce 
            ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce AND operacje.apteczki_idapteczki = $idapteczki 
            GROUP BY operacje.nazwaOperacji, month 
            ORDER BY month, operacje.nazwaOperacji";
    
    $result = mysqli_query($conn, $sql);
    

    if (mysqli_num_rows($result) > 0) {

        echo"<table style ='margin-left:auto;margin-right:auto' class='table table-bordered table-striped w-auto'><thead class='thead-dark w-auto'><tr><th>Numer</th><th>Typ operacji</th><th>Miesiąc</th><th>Koszt</th></tr></thead><tbody>";
        
        while($row = mysqli_fetch_assoc($result)) {
            if ($row['nazwaOperacji'] != 'zakup'){
                $cena = ($row["cena"] / $row["ilosc_kupiona"])*$row["ilosc"];
            } else{
                $cena = $row["cena_sum"];
            }

            $cena = round($cena,2);

            $monthNum = $row["month"];
            $dateObj = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F');

            echo "<tr><td>".$numer."</td><td>".$row["nazwaOperacji"]."</td><td>".$monthName."</td><td>".$cena." zł</td></tr>";

            $numer += 1;
         }} else {
            echo "Brak wyników!";
        }
        echo"</tbody></table>
        <div class = 'row justify-content-md-center'>
        <div class = 'col-md-auto' style='padding-bottom:25px; padding-top:25px; align-content:center;justify-content:center;'>";
    
        $sql_max_date = "SELECT MAX(dataOperacji) AS date_do, MIN(dataOperacji) AS date_od FROM operacje";
        $result = mysqli_query($conn, $sql_max_date );
        
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $date_do = $row['date_do'];
                $date_od = $row['date_od'];
            }}
    ?>
    
    <hr color="#0275d8">
    <h5>Raport szczegółowy</h5><br>

    <form method="POST" action = "przychody-rozchody.php"> 
        <label for="operacja">Rodzaj operacji: </label>
        <select name = "operacja">   
            <option value="zażycie">Zażycie</option> 
            <option value="utylizacja">Utylizacja</option> 
            <option value="zakup">Zakup</option> 
        </select><br>

            <label for="data_od">Operacje od: </label>
            <input type = "date" id = "data_od" name = "data_od" value = "<?php echo $date_od; ?>"><br>

            <label for="data_do">Operacje do: </label>
            <input type = "date" id = "data_do" name = "data_do" value = "<?php echo $date_do; ?>"><br><br>

        <input type = "submit" name = "submit" value = "Pokaż" class="btn btn-primary">
    </form>


    <hr color="#0275d8">

    <?php
    echo"<div class='col-md-auto'></div></div></div>"; 
    mysqli_close($conn);
    echo"<div class='row justify-content-md-center'><div class='col-md-auto' style='padding-bottom:25px;'> <a href = './userpage.php' class='btn btn-secondary'> Strona główna </a><br></div></div>";
   ?>
    </body>
</html>
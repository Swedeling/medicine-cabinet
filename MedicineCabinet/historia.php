<?php
    $title = 'Historia operacji';
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
    $password = "**********";
    $dbname = "telesins";
    $numer = 1;
    $uzytkownik = $_SESSION["current_user"];
    $idapteczki = $_SESSION["current_apteczka"];

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
   
    echo"<div class='container'>
            <div class='row justify-content-md-center'>
                <div class='col'></div>
                <div class='col-md-auto' style='padding-bottom:25px; padding-top:25px; align-content:center;justify-content:center;border:solid #0275d8;border-radius:25px;border-width:2px;'>";
    echo"<center><h2>Historia operacji </h2></center><br>";
    
    $sql = "SELECT  operacje.idOperacji, operacje.nazwaOperacji, operacje.dataOperacji, operacje.ilosc, operacje.users_iduser, operacje.idleki_w_apteczce,
        users.imie, users.iduser, 
        leki_w_apteczce.idleki_w_apteczce, 
        baza_lekow.nazwaLeku, baza_lekow.idleku  
        FROM (((operacje 
        INNER JOIN users ON  operacje.users_iduser = users.iduser AND operacje.apteczki_idapteczki = $idapteczki) 
        INNER JOIN leki_w_apteczce ON leki_w_apteczce.idleki_w_apteczce = operacje.idleki_w_apteczce) 
        INNER JOIN baza_lekow ON leki_w_apteczce.baza_lekow_idleku = baza_lekow.idleku) 
        ORDER BY operacje.dataOperacji,operacje.idOperacji";

    $result = mysqli_query($conn, $sql);
    

    if (mysqli_num_rows($result) > 0) {
        echo"<table style ='margin-left:auto;margin-right:auto' class='table table-bordered table-striped w-auto'><thead class='thead-dark w-auto'><tr><th>Numer</th><th>Typ operacji</th><th>Nazwa leku</th><th>Data operacji</th><th>Ilość</th><th>Użytkownik</th></tr></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>".$numer."</td><td>".$row["nazwaOperacji"]."</td><td>".$row["nazwaLeku"]."</td><td>".$row["dataOperacji"]."</td><td>".$row["ilosc"]."</td><td>".$row["imie"]."</td></tr>";
            $numer += 1;
         }
        } else {
            echo "Brak wyników!";
        }
    echo"</tbody></table>
        <div class = 'row justify-content-md-center'>
            <div class = 'col-md-auto' style='padding-bottom:25px; padding-top:25px; align-content:center;justify-content:center;'>";
    
    $sql_users = "SELECT * FROM `users` WHERE apteczki_idapteczki = $idapteczki";
    $users = mysqli_query($conn, $sql_users);

    $sql_leki = "SELECT * FROM `baza_lekow` ORDER BY nazwaLeku";
    $leki = mysqli_query($conn, $sql_leki);

    $sql_max_date = "SELECT MAX(dataOperacji) AS date_do, MIN(dataOperacji) AS date_od FROM operacje";
    $result = mysqli_query($conn, $sql_max_date );
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $date_do = $row['date_do'];
            $date_od = $row['date_od'];
        }}
    ?>    

    <hr color="#0275d8">
    <h5>Filtrowanie</h5>
    <form method="POST" action = "historia_zaawansowane.php"> 
        <label for="operacja">Rodzaj operacji: </label>
        <select name = "operacja">  
            <option value="wszystkie">wszystkie</option>  
            <option value="zażycie">Zażycie</option> 
            <option value="utylizacja">Utylizacja</option> 
            <option value="zakup">Zakup</option> 
        </select><br>

        <label for="user">Użytkownik: </label>
        <select name = "user">  
            <option value="wszyscy">wszyscy</option>  
                <?php 
                    while($cat =  mysqli_fetch_array($users,MYSQLI_ASSOC)){
                        $temp = $cat['imie'];
                        echo $cat['imie'];
                        echo "<option value='$temp'>$temp</option>";
                }
                ?>     
            </select><br>

            <label for="lekname">Nazwa leku: </label>
            <select name = "lekname">  
            <option value="wszystkie">wszystkie</option>  
                <?php 
                    while($cat =  mysqli_fetch_array($leki,MYSQLI_ASSOC)){
                        $temp = $cat['nazwaLeku'];
                        echo "<option value='$temp'>$temp</option>";
                }
                ?>
            </select><br>

            <label for="data_od">Operacje od: </label>
            <input type = "date" id = "data_od" name = "data_od" value = "<?php echo $date_od; ?>"><br>

            <label for="data_do">Operacje do: </label>
            <input type = "date" id = "data_do" name = "data_do" value = "<?php echo $date_do; ?>"><br>

        <input type = "submit" name = "submit" value = "Filtruj" class="btn btn-primary">
</form>
<hr color="#0275d8">
<a href = "./userpage.php" class="btn btn-secondary"> Strona główna </a>
            </div></div></div>
            <div class='col'></div></div></div>


<?php 
mysqli_close($conn);
?>

    </body>
</html>

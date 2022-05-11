<?php
    $title = 'Nowy lek';
    include('base.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nowy lek</title>
        <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
    $servername = "mysql.agh.edu.pl";
    $username = "telesins";
    $password = "**********";
    $dbname = "telesins";
  

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM `baza_lekow` ORDER BY nazwaLeku";
    $leki = mysqli_query($conn, $sql);
    ?>    
<div class="container">
            <div class="center_padded">
    <h2>Dodaj lek do apteczki</h2><br/>
    <form method="POST" action = "dodajlek.php"> 
        <label for="lekname">Nazwa leku: </label>
        <select name = "lekname">  
            <option value="">--- Wybierz ---</option>  
                <?php 
                    while($cat =  mysqli_fetch_array($leki,MYSQLI_ASSOC)){
                        $temp = $cat['nazwaLeku'];
                        echo "<option value='$temp'>$temp</option>";
                }
                ?>
        </select><br>
        <label for="lek_ilosc">Ilość: </label>
        <input type = "number" name = "lek_ilosc" placeholder = "1" min = 1><br>
        <label for="cena">Cena: </label>
        <input type = "number" name = "cena" placeholder = "0.00" min = 0 step="0.01"><br>
        <label for="datawazn">Data ważności: </label>
        <input type = "date" id = "datawazn" name = "datawazn"><br><br>
        <input type = "submit" name = "submit" value = "Dodaj" class="btn btn-primary">
</form>
<hr color="#0275d8">
<a href = "./userBazaLekow.php" class="btn btn-primary"> Twoja apteczka </a>
    <a href = "./bazaLekow.php" class="btn btn-secondary"> Baza leków </a>
    <a href = "./userpage.php" class="btn btn-secondary"> Strona główna </a><br>
            </div>
            </div>
</body>
</html>



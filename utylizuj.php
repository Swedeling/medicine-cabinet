<?php
    $title = 'Utylizacja leku';
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
            echo "<meta charset='UTF-8'>";

            $lekid = $lekil = $uzytkownik="";

            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                $lekid = $_POST["lekid"];
                $lekil = $_POST["lekil"];
                $data = $_POST["datawazn"];
                $uzytkownik = $_SESSION["current_user"];
            }

            $servername = "mysql.agh.edu.pl";
            $username = "telesins";
            $password = "*********";
            $dbname = "telesins";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $id = $_GET['ajdi'];
            $sql = "SELECT nazwaLeku  FROM baza_lekow WHERE idleku = $id";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                $nazwa =$row['nazwaLeku'];
                }
            }
            ?>
        <div class="container">
        <div class="center_padded">
        <h2>Zutylizuj lek</h2><br/>
        <form method="POST" action="./utylizacja.php">
            <input type="hidden" name = "lekid" value="<?php echo $_GET['ajdi']; ?>">

            <input type="hidden" name = "idleki_w_apteczce" value="<?php echo $_GET['idleki_w_apteczce']; ?>">

            <input type="hidden" name = "idapteczki" value="<?php echo $_GET['idapteczki']; ?>">

            <label for="nazwaLeku">Nazwa leku: </label> 
            <input type="text" name = "nazwaLeku" value="<?php echo $nazwa; ?>" readonly><br> 

            <label for="lekil">Ilość: </label> 
            <input type="number" name = "lekil" value="<?php echo $_GET['ile'];?>" readonly><br>

            <label for="datawazn">Data ważności na opakowaniu: </label>
            <input type="date" name = "datawazn" value="<?php echo $_GET['date']; ?>" readonly><br>

            <input type="submit" name = "submit" value="Zutylizuj" class="btn btn-primary">
        </form>
    <hr color="#0275d8">
    <a href="./userpage.php" class="btn btn-secondary">Strona główna</a>
    </div>
    </div>
</body>

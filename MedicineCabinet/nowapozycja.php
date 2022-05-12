<?php
    $title = 'Dodawanie leku do bazy';
    include('base.php');
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Dodawanie leku do bazy</title>
        <link rel="stylesheet" href="styles.css">
    </head>
<body>
<div class="container">
    <div class="center_padded">
    <h2>Dodaj lek do bazy</h2><br/>
    <form method="POST" action = "nowyLekDoBazy.php"> 
    <div class="form-group">
        <label for="lekname">Nazwa leku: </label>
        <input type = "text" class = "form-control" name = "lekname"><br><br/>
        <label for="leksubst">Substancja czynna: </label>
        <input type = "text" class = "form-control" name = "leksubst"><br><br/>
        <input type = "submit" name = "submit" value = "Dodaj" class="btn btn-primary">
    </div>
    </form>
    
    <hr color="#0275d8">
    <a href = "./bazaLekow.php" class="btn btn-secondary"> Baza leków </a>
    <a href = "./userpage.php" class="btn btn-secondary"> Strona główna </a><br>
</div>
</div>
</body>
</html>

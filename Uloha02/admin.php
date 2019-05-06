<?php
/*
 * formular
 * dvojjazycnost
 * vypis studentov
 */



?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--jQuery Datatables CSS-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">


    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>ADMIN</title>
</head>
<body>

<div class="container">

    <form action="" method="post">

        <h2>Pridanie vysledkov</h2>

        <div class="form-inline">

        <div class="form-group ">

            <label for="schoolYear">Skolsky rok</label>
            <select class="form-control" id="schoolYear">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>

        </div>

        <div class="form-group">

            <label for="subject">Nazov predmetu</label>
            <input type="text" class="form-control" id="subject" placeholder="Nazov predmetu">

        </div>

        </div>

        <div class="form-inline">

        <div class="form-group">

            <label for="resultCSV">CSV subor s vysledkami</label>

            <div class="custom-file">
                <input type="file" class="custom-file-input" id="resultCSV" lang="es">
                <label class="custom-file-label" for="customFileLang">Vyberte subor</label>
            </div>

        </div>

        <div class="form-group">

            <label for="separator">Oddelovac</label>
            <select class="form-control" id="separator">
                <option>,</option>
                <option>;</option>
            </select>

        </div>

        </div>


    </form>


</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <title>
        Mail Info
    </title>

</head>
<body>
<header>
    <h1 id="tit_mail">
        Mail Info
    </h1>
    <nav>
        <ul class="menu">
            <li class="menu"><a href="index.php">Upload csv</a></li>
            <li class="menu"><a href="mailinfo.php">Mail info</a></li>
        </ul>
    </nav>

</header>

<div class='container'>
    <table class='table' id="email_table">
        <thead class="thead-light">
        <tr>
            <th scope='col'>Dátum odoslania</th>
            <th scope='col'>Príjmateľ</th>
            <th scope='col'>Predmet</th>
            <th scope='col'>ID šablóny</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>";


<script>
    $(document).ready( function () {
        $('#email_table').DataTable();
    } );

    $('#email_table').DataTable( {
    } );


</script>

</body>
</html>

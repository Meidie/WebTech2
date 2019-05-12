<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="../Login/css/style.css">

    <title><?php echo $language['title']?></title>

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
 <!--   <h1 id="tit_mail">
        Mail Info
    </h1>
    <nav>
        <ul class="menu">
            <li class="menu"><a href="index.php">Upload csv</a></li>
            <li class="menu"><a href="mailinfo.php">Mail info</a></li>
        </ul>
    </nav> -->

    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="https://147.175.121.210:4171/files/SkuskoveZadanie/WebTech2/index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="../Login/img/logo.png"> </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <!--<h1 class="text-white"></h1>-->
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="index.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['profile']?>Upload csv</a>
            </li>
            <li class="navbar-nav mr-auto active">
                <a class="nav-link" href="mailinfo.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['results']?>Mail info</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="index.php?lang=sk"> <img src="../Login/img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="index.php?lang=en"> <img src="../Login/img/uk.png" height="30" alt="uk"></a></div>
                <?php

                //vykreslenie spravnej vlajky
                if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){

                    echo '<script>document.getElementById("skDiv").style.display = "none";</script>';
                    echo '<script>document.getElementById("enDiv").style.display = "";</script>';
                }else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){

                    echo '<script>document.getElementById("skDiv").style.display = "";</script>';
                    echo '<script>document.getElementById("enDiv").style.display = "none";</script>';
                }else{

                    echo '<script>document.getElementById("skDiv").style.display = "none";</script>';
                    echo '<script>document.getElementById("enDiv").style.display = "";</script>';
                }
                ?>
            </li>
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

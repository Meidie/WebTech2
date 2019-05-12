<?php

//index.php
session_start();
if(isset($_SESSION['admin'])){header('Location: Uloha01/php/admin_results.php?lang='.$language['websiteLang']); exit();}

?>
<!DOCTYPE html>
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


    <title>Import CSV File into Jquery Datatables using PHP Ajax</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        .box
        {
            max-width:800px;
            width:100%;
            margin: 0 auto;;
        }
    </style>
</head>
<body>
<header>
   <!-- <h1 id="tit_load">
        Načítanie údajov
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
            <li class="navbar-nav mr-auto active">
                <a class="nav-link" href="index.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['profile']?>Upload csv</a>
            </li>
            <li class="navbar-nav mr-auto">
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
<!--------------------------------------------------------------------
-----------------------Prve nacitavanie udajov------------------------>
<div class="container">
    <br />
    <h3 align="center">Prvé načítanie údajov</h3>
    <br />
    <form id="upload_csv1" method="post" enctype="multipart/form-data">
        <div class="col-md-4">
            <input type="file" name="csv_file1" id="csv_file1" accept=".csv" style="margin-top:15px;" />
        </div>
        <div class="col-md-5">
            <input type="submit" name="upload" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-info" />
        </div>
        <div style="clear:both"></div>
    </form>
    <br />
    <br />
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="customer-data">
            <thead>
            <tr>
                <th>ID</th>
                <th>Meno</th>
                <th>Email</th>
                <th>Prihlasovacie meno</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!---------------------------------------------------------------------
------------------------Druhe nacitavanie udajov------------------------->
<div class="container">
    <br />
    <h3 align="center">Druhé načítanie údajov</h3>
    <br />
    <form id="upload_csv2" method="post" enctype="multipart/form-data">
        <div class="col-md-4">
            <input type="file" name="csv_file2" id="csv_file2" accept=".csv" style="margin-top:15px;" />
        </div>
        <div class="col-md-5">
            <input type="submit" name="upload" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-info" />
        </div>
        <div style="clear:both"></div>
    </form>
    <br />
    <br />
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Meno</th>
                <th>Email</th>
                <th>Prihlasovacie meno</th>
                <th>Heslo</th>
                <th>verejná IP</th>
                <th>privátna IP</th>
                <th>ssh</th>
                <th>http</th>
                <th>https</th>
                <th>misc1</th>
                <th>misc2</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
</body>
</html>

<script>



    $(document).ready(function(){

        $('#upload_csv1').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"loadfile.php",
                method:"POST",
                data:new FormData(this),
                dataType:'json',
                contentType:false,
                cache:false,
                processData:false,
                success:function(jsonData)
                {
                    $('#csv_file1').val('');
                    $('#customer-data').DataTable({
                        data  :  jsonData,
                        columns :  [
                            { data : "id" },
                            { data : "name" },
                            { data : "email" },
                            { data : "login" }
                        ]
                    });
                }
            });
        });
    });

    $(document).ready(function(){
        $('#upload_csv2').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"loadfile.php",
                method:"POST",
                data:new FormData(this),
                dataType:'json',
                contentType:false,
                cache:false,
                processData:false,
                success:function(jsonData)
                {
                    $('#csv_file2').val('');
                    $('#data-table').DataTable({
                        data  :  jsonData,
                        columns :  [
                            { data : "id" },
                            { data : "name" },
                            { data : "email" },
                            { data : "login" },
                            { data : "heslo" },
                            { data : "verejnaIP" },
                            { data : "privatnaIP" },
                            { data : "ssh" },
                            { data : "http" },
                            { data : "https" },
                            { data : "misc1" },
                            { data : "misc2" }
                        ]
                    });
                }
            });
        });
    });

</script>


<?php
session_start();
if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../lang/eng.php');
}else{$language = include('../lang/svk.php');}

if(!isset($_SESSION['loggedIn'])){header('Location: ../../index.php?lang='.$language['websiteLang']);}

?>

<!DOCTYPE html>
<html lang="<?php echo $language['websiteLang']?>">
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


    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <title><?php echo $language['titleMain']?></title>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="https://147.175.121.210:4171/files/SkuskoveZadanie/WebTech2/index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="../img/logo.png"> </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <!--<h1 class="text-white"></h1>-->
            </li>
            <li class="navbar-nav mr-auto active">
                <a class="nav-link" href="user_main.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['profile']?></a>
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="user_results.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['results']?></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="user_main.php?lang=sk"> <img src="../img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="user_main.php?lang=en"> <img src="../img/uk.png" height="30" alt="uk"></a></div>
                <?php

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
            <li class="navbar-item">
                <a class="nav-link" id="logout" href="../../Login/php/logout.php?lang=<?php echo $language['websiteLang'];?>"><?php echo $language['logout']?></a>
            </li>
        </ul>
    </nav>

</header>
<div class="container">

    <div id="caption">
        <h2><?php echo $language['h2main']?></h2>
        <div class="or-seperator"></div>
    </div>
   <div id="data">

       <table style="margin-top: 50px">
           <tbody>
           <tr>
               <th class="" style="width: 200px"><?php echo $language['name']?></th>
               <td><?php echo $_SESSION['name']; ?></td>
           </tr>
           <tr>
               <th class="" style="width: 200px"><?php echo $language['surname']?></th>
               <td><?php echo $_SESSION['lastName']; ?></td>
           </tr>
           <tr>
               <th class="" style="width: 200px"><?php echo $language['id']?></th>
               <td><?php echo $_SESSION['id']; ?></td>
           </tr>
           <tr>
               <th class="" style="width: 200px"><?php echo $language['email1']?></th>
               <td><?php echo $_SESSION['mail1']; ?></td>
           </tr>
           <tr>
               <th class="" style="width: 200px"><?php echo $language['email2']?></th>
               <td><?php echo $_SESSION['mail2']; ?></td>
           </tr>
           </tbody>
       </table>


   </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
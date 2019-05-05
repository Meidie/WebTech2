
<?php
session_start();
if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('Login/lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('Login/lang/eng.php');
}else{$language = include('Login/lang/svk.php');}

if(isset($_SESSION['loggedIn'])){header('Location: Uloha01/php/user_main.php?lang='.$language['websiteLang']);}
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

    <link rel="stylesheet" type="text/css" href="Login/css/style.css">

    <title><?php echo $language['title']?></title>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="https://147.175.121.210:4171/files/SkuskoveZadanie/WebTech2/index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="Login/img/logo.png"> </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <h1 class="text-white"><?php echo $language['h1']?></h1>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="index.php?lang=sk"> <img src="Login/img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="index.php?lang=en"> <img src="Login/img/uk.png" height="30" alt="uk"></a></div>
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
        </ul>
    </nav>

</header>
<div class="login-form">
    <form enctype="multipart/form-data" action="Login/php/authentication.php?lang=<?php echo $language['websiteLang']?>" method="Post">
        <div class="avatar">
            <i class="fa fa-user-circle-o fa-5x"></i>
        </div>
        <h2 class="text-center"><?php echo $language['h2']?></h2>

        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
            </div>
            <input type="text"  id="userName" class="form-control" name="username" placeholder="<?php echo $language['name']?>" required="required">
            <div class='invalid-feedback'></div>
        </div>
        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
            </div>
            <input id="userPassword" type="password" class="form-control" name="password" placeholder="<?php echo $language['password']?>" required="required">
            <div class='invalid-feedback'><?php echo $language['failedLogin']?></div>

        </div>
        <?php
            if(isset($_SESSION['login_failed'])){
                echo "<script> document.getElementById('userName').classList.add('is-invalid')</script>";
                echo "<script> document.getElementById('userPassword').classList.add('is-invalid')</script>";
                unset($_SESSION['login_failed']);
            }
        ?>
        <div class="form-group">
            <button type="submit" name="submitLogin" id="login" class="btn btn-primary btn-lg btn-block"><i class="fa fa-graduation-cap" style="margin-right: 5px"></i><?php echo $language['loginButton']?></button>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="Login/js/main.js"></script>
</body>
</html>
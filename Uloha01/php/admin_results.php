
<?php
session_start();
if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../lang/eng.php');
}else{$language = include('../lang/svk.php');}

if(!isset($_SESSION['admin'])){header('Location: ../../index.php?lang='.$language['websiteLang']);}

//pre select
/*foreach ($language['array'] as $select){
    echo $select;
}*/

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

    <title><?php echo $language['results']?></title>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="https://147.175.121.210:4171/files/SkuskoveZadanie/WebTech2/index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="../img/logo.png"> </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <!--<h1 class="text-white"></h1>-->
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="admin_main.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['profile']?></a>
            </li>
            <li class="navbar-nav mr-auto  active">
                <a class="nav-link" href="admin_results.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['results']?></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="admin_results.php?lang=sk"> <img src="../img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="admin_results.php?lang=en"> <img src="../img/uk.png" height="30" alt="uk"></a></div>
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
        <h2><?php echo $language['h2AdminResults'];?></h2>
        <div class="or-seperator"></div>

        <form>
            <div class="form-check form-check-inline">
                <input class='form-check-input' type='radio' name='choice' id='add' onchange="change(id)"  <?php if(isset($_POST['submitAdd']) || !isset($_POST['submitCheck'])){ echo 'checked';} ?> >
                <label class="form-check-label" for="add"><?php echo $language['radio1'];?></label>
            </div>

            <div class="form-check form-check-inline" >
                <input class='form-check-input' type='radio' name='choice' id='show' onchange="change(id)" <?php if(isset($_POST['submitCheck'])){ echo 'checked';} ?>>
                <label class='form-check-label' for='show'><?php echo $language['radio2'];?></label>
            </div>
        </form>
    </div>
    <div id="data">

        <div class="alert alert-warning" role="alert" id="alert">
            <?php echo $language['alert'];?>
        </div>
        <form enctype="multipart/form-data" action="admin_results.php?lang=<?php echo $language['websiteLang'];?>" method="post" id="addForm" <?php if(isset($_POST['submitCheck'])){ echo 'style="display: none"';} ?> >
            <div class="form-row" >
                <div class="form-group col-md-6">
                    <label for="inputSubject"><?php echo $language['lSubject'];?></label>
                    <input type="text" class="form-control" id="inputSubject" name="subject" placeholder="<?php echo $language['phSubject'];?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputYear"><?php echo $language['lYear'];?></label>
                    <select class="form-control" id="inputYear" name="year">
                        <option data-option="">--</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputSeparator"><?php echo $language['separator'];?></label>
                    <input type="text" class="form-control" id="inputSeparator" name="separator" placeholder="" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputFile"><?php echo $language['file'];?></label>
                    <input type="file" id="inputFile"  name="file" style="background-color:#D8D8D8" placeholder="" required>
                    <br>
                    <input type="text" id="fileName" value="" readonly >
                    <button type="button" class="btn color-black text-white" id="uploadButton"><?php echo $language['selectFile'];?></button>
                </div>
            </div>
            <input type="submit" name="submitAdd" value="<?php echo $language['submit1'];?>" class="btn btn-primary mb-2" id="button">
        </form>

        <form enctype="multipart/form-data" method="post"  action="admin_results.php?lang=<?php echo $language['websiteLang'];?>" id="showForm" <?php if(isset($_POST['submitAdd']) || !isset($_POST['submitCheck'])){ echo 'style="display: none"';} ?>>
            <div class="form-row" >
                <div class="form-group col-md-6">
                    <label for="inputName"><?php echo $language['lSubject'];?></label>
                    <input type="text" class="form-control" id="inputSubject" name="name" placeholder="<?php  if(isset($_POST['submitCheck'])){echo $_POST['name'];}else{echo $language['phSubject']; }?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputYear"><?php echo $language['lYear'];?></label>
                    <select class="form-control" id="inputYear" name="year">
                        <option data-option="">--</option>
                    </select>
                </div>
            </div>
            <input type="submit" name="submitCheck" value="<?php echo $language['submit2'];?>" class="btn btn-primary mb-2" id="submitCheck">
        </form>

        <div id="table">


            <?php



            if(isset($_POST['submitCheck'])){
                echo $_POST['name'];
                echo $_POST['year'];
            }
            else if(isset($_POST['submitAdd'])){
                echo $_POST['subject'];
                echo $_POST['year'];
                echo $_POST['separator'];
                echo $_POST['file'];
            }
            ?>
        </div>
    </div>



</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
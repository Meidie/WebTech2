<?php

if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../lang/eng.php');
}else{$language = include('../lang/svk.php');}

/*
 * formular
 * dvojjazycnost
 * vypis studentov
 */


?>

<!DOCTYPE html>
<html lang="<?php echo $language['websiteLang']; ?>">
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

    <title>ADMIN</title>
</head>


<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="https://147.175.121.210:4171/files/SkuskoveZadanie/WebTech2/index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="../img/logo.png"> </a>

        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="admin.php?lang=sk"> <img src="../img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="admin.php?lang=en"> <img src="../img/uk.png" height="30" alt="uk"></a></div>

            </li>
            <li class="navbar-item">
                <a class="nav-link" id="logout" href="logout.php"><?php echo $language['logout']?></a>
            </li>
        </ul>
    </nav>

</header>

<body>

<div class="container">

    <form action="" method="post">

        <h2><?php echo $language['formHeader']; ?></h2>

        <div class="form-inline">

        <div class="form-group ">

            <label for="schoolYear"> <?php echo $language['schoolYear']; ?> </label>
            <select class="form-control" id="schoolYear">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>

        </div>

        <div class="form-group">

            <label for="subject"><?php echo $language['subjectName']; ?></label>
            <input type="text" class="form-control" id="subject" placeholder="<?php echo $language['subjectNamePlaceholder']; ?>">

        </div>

        </div>

        <div class="form-inline">

        <div class="form-group">

            <label for="resultCSV"><?php echo $language['CSVfile']; ?></label>

            <div class="custom-file">
                <input type="file" class="custom-file-input" id="resultCSV" lang="es">
                <label class="custom-file-label" for="customFileLang"><?php echo $language['CSVfilePlaceholder']; ?></label>
            </div>

        </div>

        <div class="form-group">

            <label for="separator"><?php echo $language['separator']; ?></label>
            <select class="form-control" id="separator">
                <option>,</option>
                <option>;</option>
            </select>

        </div>

        </div>


    </form>

    <h2><?php echo $language['teamOverview']; ?></h2>


</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
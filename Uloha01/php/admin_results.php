
<?php
session_start();

//zistenie a pridanie jazyka
if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../lang/eng.php');
}else{$language = include('../lang/svk.php');}

//kontrola prihlasenia
if(!isset($_SESSION['admin'])){header('Location: ../../index.php?lang='.$language['websiteLang']); exit();}

$deleted = FALSE;

//zobrazenie udajov
if(isset($_POST['submitCheck'])){
    $subject = $_POST['name'];
    $year = $_POST['year'];
    $subjectName = $subject." ".$year;
}

//vymazanie predmetu
if(isset($_POST['submitDelete'])){

    require('config.php');
    $conn = new mysqli($hostname, $username, $password, $dbname);
    if ($conn->connect_error) {
        header('Location: admin_results.php?msg=connectionFailed&lang='.$language['websiteLang']);
        die("Connection failed: " . $conn->connect_error);
    }

    $subject = $_POST['name'];
    $year = $_POST['year'];
    $subjectName = $subject." ".$year;

    $sql = "DROP TABLE `$subjectName`";
    if($conn->query($sql) === TRUE){

        $sql = "DELETE FROM `Predmety` WHERE `Predmet` = '$subjectName'";
        if($conn->query($sql) === TRUE){

            $deleted = TRUE;
        }else{

            $deleted = FALSE;
        }
    }else{
        $deleted = FALSE;
    }

    $conn->close();
}

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
        <a class="navbar-brand" href="../../index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="../img/logo.png"> </a>
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
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="../../Uloha02/php/admin.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['point']?></a>
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="../../Uloha03/indexlu.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['mail']?></a>
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="../../Uloha03/mailinfo.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['mailinfo']?></a>
            </li>

        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="admin_results.php?lang=sk"> <img src="../img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="admin_results.php?lang=en"> <img src="../img/uk.png" height="30" alt="uk"></a></div>
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
                <input class='form-check-input' type='radio' name='choice' id='add' onchange="change(id)"  <?php if(!isset($_POST['submitCheck']) && !isset($_POST['submitDelete'])){ echo 'checked';} ?> >
                <label class="form-check-label" for="add"><?php echo $language['radio1'];?></label>
            </div>

            <div class="form-check form-check-inline" >
                <input class='form-check-input' type='radio' name='choice' id='show' onchange="change(id)" <?php if(isset($_POST['submitCheck']) || isset($_POST['submitDelete'])){ echo 'checked';} ?>>
                <label class='form-check-label' for='show'><?php echo $language['radio2'];?></label>
            </div>
        </form>
    </div>
    <div id="data">


        <?php

        //informacia o uspesnosti/neuspesnocti uploadu dat z csv suboru
        if(isset($_GET['msg'])){

            $result = $_GET['msg'];

            switch ($result){
                case 'success':
                    echo "<div class='alert alert-success' id='success' role='alert'>".$language['success']."</div>";
                    break;
                case 'createFailed':
                    echo "<div class='alert alert-danger' id='createFailed' role='alert'>".$language['createFailed']."</div>";
                    break;
                case 'noSubmitData':
                    echo "<div class='alert alert-warning' id='noSubmitData' role='alert'>".$language['noSubmitData']."</div>";
                    break;
                case 'wrongFile':
                    echo "<div class='alert alert-info' id='wrongFile' role='alert'>".$language['wrongFile']."</div>";
                    break;
                case 'wrongSize';
                    echo "<div class='alert alert-info' id='wrongSize' role='alert'>".$language['wrongSize']."</div>";
                    break;
                case 'connectionFailed':
                    echo "<div class='alert alert-danger' id='connectionFailed' role='alert'>".$language['connectionFailed']."</div>";
                    break;
                case 'wrongSeparator':
                    echo "<div class='alert alert-warning' id='wrongSeparator' role='alert'>".$language['wrongSeparator']."</div>";
                    break;
                case 'unableToOpen':
                    echo "<div class='alert alert-danger' id='unableToOpen' role='alert'>".$language['unableToOpen']."</div>";
                    break;
                case 'unsuccessful':
                    echo "<div class='alert alert-danger' id='unableToOpen' role='alert'>".$language['unsuccessful']."</div>";
                    break;
            }
        }
        ?>
        <form enctype="multipart/form-data" action="file.php?lang=<?php echo $language['websiteLang'];?>" method="post" id="addForm" <?php if(isset($_POST['submitCheck']) || isset($_POST['submitDelete'])){ echo 'style="display: none"';} ?> >
            <div class="form-row" >
                <div class="form-group col-md-6">
                    <label for="inputSubject1"><?php echo $language['lSubject'];?></label>
                    <input type="text" class="form-control" id="inputSubject1" name="subject" placeholder="<?php echo $language['phSubject'];?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputYear1"><?php echo $language['lYear'];?></label>
                    <select class="form-control" id="inputYear1" name="year">
                        <?php
                        //select pre rok od 2015 po aktualny rok
                        $startYear = date("Y", 1420070400); //2015
                        $currentYear = date("Y");
                        $tmpYear = $currentYear;

                        while ($startYear < $tmpYear){

                            echo  " <option>".($tmpYear-1)."/".$tmpYear."</option>";
                            $tmpYear--;
                        }
                        ?>
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

                    <br>
                    <input type="file" id="inputFile"  name="csvFile"  accept=".csv" style="background-color:#D8D8D8" required>
                    <input type="text" id="fileName" value="" readonly >
                    <button type="button" class="btn color-black text-white" id="uploadButton"><?php echo $language['selectFile'];?></button>
                </div>
            </div>
            <input type="submit" name="submitAdd" value="<?php echo $language['submit1'];?>" class="btn btn-primary mb-2" id="button">
        </form>

        <form enctype="multipart/form-data" method="post"  action="admin_results.php?lang=<?php echo $language['websiteLang'];?>" id="showForm" <?php if(!isset($_POST['submitCheck']) && !isset($_POST['submitDelete'])){ echo 'style="display: none"';} ?>>
            <div class="form-row" >
                <div class="form-group col-md-6">
                    <label for="inputSubject2"><?php echo $language['lSubject'];?></label>
                    <select class="form-control" id="inputSubject2" name="name">
                        <?php

                            //select pre predmety
                            require('config.php');
                            $conn = new mysqli($hostname, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                header('Location: admin_results.php?msg=connectionFailed&lang='.$language['websiteLang']);
                                die("Connection failed: " . $conn->connect_error);
                            }

                            //vyhladanie predmetov v databaze
                            $sql = "SELECT Predmet FROM `Predmety` GROUP BY `Predmet`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {

                                $results = array();

                                while($row = $result->fetch_assoc()) {

                                    $option = explode('/',$row['Predmet']);
                                    $option = substr($option[0],0,strlen($option[0])-5);

                                    if(!in_array($option,$results)) {
                                        array_push($results,$option);
                                    }
                                }

                                //vypisanie predmetov
                                foreach ($results as $options){

                                    if ($options == $subject)
                                        echo "<option selected>" . $options . "</option>";
                                    else
                                        echo "<option>" . $options . "</option>";

                                }

                                $results = array();
                            }
                        ?>

                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputYear2"><?php echo $language['lYear'];?></label>
                    <select class="form-control" id="inputYear2" name="year">
                        <?php
                            //select pre rok od 2015 po aktualny rok
                            $startYear = date("Y", 1420070400); //2015
                            $currentYear = date("Y");
                            $tmpYear = $currentYear;

                            while ($startYear < $tmpYear){

                                $fullYear = ($tmpYear-1)."/".$tmpYear;
                                if($fullYear == $year)
                                    echo  " <option selected>".($tmpYear-1)."/".$tmpYear."</option>";
                                else
                                    echo  " <option>".($tmpYear-1)."/".$tmpYear."</option>";
                                $tmpYear--;
                            }
                        ?>
                    </select>
                </div>
            </div>
            <input type="submit" name="submitCheck" value="<?php echo $language['submit2'];?>" class="btn btn-primary mb-2" id="submitCheck">
            <input type="submit" name="submitDelete" value="<?php echo $language['delete'];?>" class="btn btn-danger mb-2" id="submitDelete">
        </form>

        <div id="table" style="overflow-x: auto ">
            <?php

            //ak bolo submitnute vymazanie premetu
            if(isset($_POST['submitDelete'])){

                if ($deleted){
                    echo "<div style='text-align: center'>";
                    echo $language['dataDelete'];
                    echo "</div>";
                }else{
                    echo "<div style='text-align: center'>";
                    echo $language['notDeleted'];
                    echo "</div>";
                }
            }

            //ak bolo submitnute vyhladanie premetu
            if(isset($_POST['submitCheck'])){

                $subject = $_POST['name'];
                $year = $_POST['year'];
                $subjectName = $subject." ".$year;

                //vyhladam nazvy stlpcov
                $sql = "SHOW columns FROM `$subjectName`";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    echo "<table class=\"table table-striped table-bordered text-center\"  data-show-print=\"true\" >
                            <thead><tr class=\"color-black text-white\">";

                    while($row = $result->fetch_assoc()) {

                        //vypisem nazvy stlpcov do tabulky
                        if($row['Field'] != 'rok'){

                                if(strtolower($row['Field']) == 'id')
                                    echo "<th scope=col>ID</th>";
                                else if(strtolower($row['Field']) == 'spolu')
                                    echo "<th scope=col>" . $language['sum'] . "</th>";
                                else if(strtolower($row['Field']) == 'znamka')
                                    echo "<th scope=col>" . $language['grade'] . "</th>";
                                else if(strtolower($row['Field']) == 'meno')
                                    echo "<th scope=col>" . $language['name'] . "</th>";
                                else
                                    echo "<th scope=col>".$row['Field']."</th>";
                        }
                    }
                }

                //vyberiem vsetky data pre zadany predmet
                $sql = "SELECT * FROM `$subjectName`";


                $result = $conn->query($sql);
                if ($result->num_rows > 0) {

                    echo "</tr></thead><tbody>";

                    while($row = $result->fetch_assoc()) {
                       echo "<tr>";
                       $count = 1;
                       //vypisem data do tabulky
                       foreach ($row as $col){

                           //stlpec rok vynechame
                           if($count !=3) {
                                echo "<th>" . $col . "</th>";
                           }
                           $count++;

                       }
                       echo "</tr>";
                    }

                    echo "</tbody>
                          </table>";

                    $data = TRUE;
                }
                else{//ak sa data nenasli
                    echo "<div style='text-align: center'>";
                    echo $language['noData'];
                    echo "</div>";

                }

                $conn->close();
            }
            ?>
        </div>

        <a id="pdfLink" <?php if($data == TRUE) echo 'style="display: block"'; ?> href="pdf.php?lang=<?php echo $language['websiteLang']?>&subject=<?php echo $subject?>&year=<?php echo $year ?>" target="_blank"><?php echo $language['pdf'] ?></a>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
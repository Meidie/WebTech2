<?php

if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../lang/eng.php');
}else{$language = include('../lang/svk.php');}

//vyberiem data zo submitu
if(isset($_POST['submitAdd'])){

    //spojenie s databazou
    require('config.php');
    $conn = new mysqli($hostname, $username, $password, $dbname,4171);
    if ($conn->connect_error) {
        header('Location: admin_results.php?msg=connectionFailed&lang='.$language['websiteLang']);
        die("Connection failed: " . $conn->connect_error);
    }

    $subjectName = $_POST['subject'];
    $schoolYear = $_POST['year'];
    $separator = $_POST['separator'];
    $file  = $_FILES["csvFile"];
    $name = $subjectName." ".$schoolYear;

    //zistime ci uz tabulka s danym meno existuje v databaze
    $exist = checkTable($name);
    //ak existuje tabulka v databaze
    if($exist){
        //spocitam kolko ma tabulka stlpcov
        $cols = countColumns($name);
        //ziskam header tabulky
        $header = tableHeader($name);
    }

    //ziskam koncovku inportnuteho suboru
    $fileType = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));

    //kontrola ci sa jedna o csv subor
    if($fileType != 'csv'){
        header('Location: admin_results.php?msg=wrongFile&lang='.$language['websiteLang']);
    }

    //pomocne premenne
    $row = 1;
    $col = 1;
    $id_student = "";
    $sql = "CREATE TABLE `skuskove_zadanie`.`".$name."` ( ";
    $sql2 = "INSERT INTO `$name` (";
    $sql2Part = "";

    if($exist){
        $sql2 = $sql2.$header." VALUES (";
    }

    //citanie csv suboru
    if (($handle = fopen( $_FILES["csvFile"]["tmp_name"], "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {

            $num = count($data);  //pocet stlpcov

            //ak nema csv subor rovnaky pocet stlpcov ako uz vytvorena tabulka v databaze
            if($num != $cols && $exist){
                header('Location: admin_results.php?msg=wrongSize&lang='.$language['websiteLang']);
            }

            $size = 0;

            //prechadzam vsetky stlpce v riadku
            for ($c=0; $c < $num; $c++) {

                //ak sme na prvom riadku a tabulka este neexistuje bude ju chciet vytvorit
                if($row == 1 && !$exist){

                    //ak je prvy stlpec
                    if($col == 1){
                        $id = $data[$c];
                        $sql = $sql."`".$data[$c]."` INT NOT NULL , ";
                        $sql2 = $sql2."`".$data[$c]."`";

                    }//kazdy dalsi stlpec
                    else{

                        //pri tretom stlpci pridam este rok
                        if($col == 3){
                            $sql = $sql."`rok` VARCHAR(60) NOT NULL, ";
                            $sql2 = $sql2.", `rok`";
                        }

                        $sql = $sql."`".$data[$c]."` VARCHAR(60) NOT NULL, ";
                        $sql2 = $sql2.", `".$data[$c]."`";
                    }

                    $col++;
                }// druhy a kazdy dalsi riadok v csv subore
                else{

                    if($size == 0){
                       $sql2Part  = $sql2Part ."'".$data[$c]."'";
                       $id_student = $data[$c];

                    }else{

                        if($size == 2){
                            $sql2Part = $sql2Part.", '".$schoolYear."', '".$data[$c]."'";
                        }else{
                            $sql2Part = $sql2Part.", '".$data[$c]."'";
                        }
                    }

                    $size++;
                }
            }

            //vytvorenie tabulky (ak neexistuje) po prejdeni prveho riadku
            if($row == 1 && !$exist){

                $sql = $sql."PRIMARY KEY (`".$id."`));";
                $sql2 = $sql2.") VALUES (";

                createTable($sql);
            }//pridanie dat do tabulky
            else{

                $sql2Call = $sql2.$sql2Part.")";
                $sql2Part = "";

                if ($conn->query($sql2Call) === TRUE) {
                    echo "INSERTED";
                }

                $sql3 = "INSERT INTO `Predmety` (`id`, `id_student`, `Predmet`) VALUES (NULL, '".$id_student."', '".$name."')";
                if ($conn->query($sql3) === TRUE) {
                    echo "INSERTED";
                }
            }

            $row++;
        }

        fclose($handle);
    }

    $conn->close();
    header('Location: admin_results.php?msg=success&lang='.$language['websiteLang']);
}else{

    header('Location: admin_results.php?msg=noSubmitData&lang='.$language['websiteLang']);
}


function createTable($sql){

    global $conn;
    global $language;

    if ($conn->query($sql) === TRUE) {
        echo "Table MyGuests created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
        header('Location: admin_results.php?msg=createFailed&lang='.$language['websiteLang']);
    }
}

function countColumns($name){

    global $conn;
    $count = 0;

    $sql = "SHOW columns FROM `$name`";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result)){

        $count++;
    }

    return $count-1;
}

function checkTable($name){

    global $conn;

    $sql = "SHOW TABLES LIKE '".$name."'";

    if($result = $conn->query($sql)){
        if($result->num_rows == 1){
            return true;
        }else{
            return false;
        }
    }

    return null;
}

function tableHeader($name){

    global $conn;
    $header = "";
    $count = 0;

    $sql = "SHOW columns FROM `$name`";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result)){
        if($count == 0){
            $header = $header."`".$row['Field']."`";
            $count++;
        }else{
            $header = $header.", `".$row['Field']."`";
        }
    }

    return $header.")";
}
?>
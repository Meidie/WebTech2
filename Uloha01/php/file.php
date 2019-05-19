<?php

//zistenie a pridanie jazyka
if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../lang/eng.php');
}else{$language = include('../lang/svk.php');}

//vyberiem data zo submitu
if(isset($_POST['submitAdd'])){

    //spojenie s databazou
    require('config.php');
    $conn = new mysqli($hostname, $username, $password, $dbname);
    if ($conn->connect_error) {
        header('Location: admin_results.php?msg=connectionFailed&lang='.$language['websiteLang']);
        die("Connection failed: " . $conn->connect_error);
    }

    $subjectName = $_POST['subject'];
    $schoolYear = $_POST['year'];
    $separator = $_POST['separator'];
    $file  = $_FILES["csvFile"];
    $name = $subjectName." ".$schoolYear;
    $idColumn = "";
    $inputData = array();
    $inputHeaderData = array();
    $updated = TRUE;

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
        $conn->close();
        header('Location: admin_results.php?msg=wrongFile&lang='.$language['websiteLang']);
        exit();
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

        $added = TRUE;

        while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {

           $num = count($data);  //pocet stlpcov

            if($num == 1 && $num != $cols){
                $conn->close();
                header('Location: admin_results.php?msg=wrongSeparator&lang='.$language['websiteLang']);
                exit();
            }

            //ak nema csv subor rovnaky pocet stlpcov ako uz vytvorena tabulka v databaze
            if($num != $cols && $exist){
                $conn->close();
                header('Location: admin_results.php?msg=wrongSize&lang='.$language['websiteLang']);
                exit();
            }

            $size = 0;

            //prechadzam vsetky stlpce v riadku
            for ($c=0; $c < $num; $c++) {

                //ak sme na prvom riadku a tabulka este neexistuje budeme ju chciet vytvorit
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
                }//druhy a kazdy dalsi riadok v csv subore
                else if($row >= 2){

                    if($size == 0){

                       $sql2Part  = $sql2Part ."'".$data[$c]."'";
                       $id_student = $data[$c];
                    }else{

                        if($size == 2){
                            $sql2Part = $sql2Part.", '".$schoolYear."', '".$data[$c]."'";
                            array_push($inputData , $data[$c]);

                        }else{
                            $sql2Part = $sql2Part.", '".$data[$c]."'";
                            array_push($inputData , $data[$c]);

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

                    $sql3 = "INSERT INTO `Predmety` (`id`, `id_student`, `Predmet`) VALUES (NULL, '".$id_student."', '".$name."')";
                    if ($conn->query($sql3) === TRUE) {
                        echo "INSERTED";
                    }else{//ak nastane chyba pri pridavani tabulku vymazem
                        $sql = "DELETE FROM `$name` WHERE `$id` = '$id_student'";
                        if ($conn->query($sql) === TRUE) {
                            echo "DELTED";
                            $added = FALSE;
                        }
                    }
                }else{

                    //ak sa v tabulke udaj s rovnakym PK uz nachadza udpdatneme data
                    if(sizeof($inputData) == sizeof($inputHeaderData)){

                        $sqlUpdate = "UPDATE `$name` SET";

                        for($i = 0 ; $i < sizeof($inputHeaderData);$i++){

                            if($i == 0){
                                $sqlUpdate = $sqlUpdate."`".$inputHeaderData[$i]."` = '".$inputData[$i]."'";
                            }else{
                                $sqlUpdate = $sqlUpdate.", `".$inputHeaderData[$i]."` = '".$inputData[$i]."'";
                            }
                        }
                        $sqlUpdate = $sqlUpdate." WHERE `$idColumn` = $id_student";

                        if ($conn->query($sqlUpdate) === TRUE) {
                            $updated = TRUE;
                            echo "Record updated successfully";
                        } else {
                            $updated = FAlSE;
                            echo "Error updating record: " . $conn->error;
                        }
                    }

                    $inputData = array();
                }
            }

            $row++;
        }

        fclose($handle);
    }else{//ak sa nepodari citat csv subor

        $conn->close();
        header('Location: admin_results.php?msg=unableToOpen&lang='.$language['websiteLang']);
        exit();
    }

    //ak zlyha pridanie dat alebo update
    if(!$added && !$updated){

        $conn->close();
        header('Location: admin_results.php?msg=unsuccessful&lang='.$language['websiteLang']);
        exit();

     //ak vsetko prebehne bez problemov
    }else if($added){

        $conn->close();
        header('Location: admin_results.php?msg=success&lang='.$language['websiteLang']);
        exit();
    }

}else{

    $conn->close();
    header('Location: admin_results.php?msg=noSubmitData&lang='.$language['websiteLang']);
    exit();
}

//funkcia an vytvorenie tabulky
function createTable($sql){

    global $conn;
    global $language;

    if ($conn->query($sql) === TRUE) {
        echo "Table MyGuests created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
        header('Location: admin_results.php?msg=createFailed&lang='.$language['websiteLang']);
        exit();
    }
}

//funkcia na spocitanie stlpcov
function countColumns($name){

    global $conn;
    $count = 0;

    $sql = "SHOW columns FROM `$name`";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {

            $count++;
        }
    }

    return $count-1;
}

//funkcia na zistenie ci tabulka existuje
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

//funkcia na ziskanie vsetkych nazvov stlpcov z tabulky
function tableHeader($name){

    global $conn;
    global $idColumn;
    global $inputHeaderData;

    $header = "";
    $count = 0;

    $sql = "SHOW columns FROM `$name`";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {

            if($count == 0){
                $idColumn = $row['Field'];
                $header = $header."`".$row['Field']."`";
                $count++;
            }else{
                $header = $header.", `".$row['Field']."`";

                if($row['Field'] != 'rok'){
                    array_push($inputHeaderData , $row['Field']);
                }
            }
        }
    }

    return $header.")";
}
?>
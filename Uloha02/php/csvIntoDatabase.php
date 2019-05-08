<?php
include_once 'config.php';
/*Todo

osetrit vybratie suboru, co nie je csv

zabezpecit proti droptable, etc
*/

    if(strcmp($_POST['permission'],"granted")) // ak sem neprisiel cez formular, je poslany na index.php
        header("Location: ../../index.php");


/*
 $_POST['schoolYear']='2019';
 $_POST['subject']="Webtech2";
 $_POST['separator']=';';
*/

 // PREDMET SA MUSI PRIDAT ESTE PRED CYKLOM INAK BY SA ZAPISAL DO TABULKY VZDY PRI PRIDANI NOVEHO STUDENTA
// sled pridavania Studneti, predmet, timy, clenovia timov

$GLOBALS['conn']=$conn; // global conn pouzitelny vo funkciach


$file = fopen($_FILES['csvPath']['tmp_name'], 'r');

insertIntoPredmety($_POST['subject']); // nie je v cykle, zapisuje sa len raz

while (($row = fgetcsv($file, 0, $_POST['separator'])) !== FALSE) {

    if(!is_null($row[0])){

        $columns=fetchRowData($row);

        insertIntoStudenti($columns);
        insertIntoTimy($columns['teamNumber'],lastAddedSubjectID(),$_POST['schoolYear']);
        insertIntoClenoviaTimov($columns['ID'],$columns['teamNumber']);

    }

}

fclose($file);


// prida do tabulky predmety predmet
function insertIntoPredmety($subjectName){

    $sql = "insert into predmety(nazov)
VALUES('".$subjectName."')";

    $GLOBALS['conn']->query($sql);

}

// prida do tabulky studenti, studenta
function insertIntoStudenti($columns){

   // if(is_null($columns['heslo'])){
    if(!strcmp($columns['heslo'],"") ){

        $sql = "insert into studenti(ID, meno, email,heslo)
VALUES('".$columns['ID']."','".$columns['meno']."','".$columns['mail']."',null)";

    }
    else{
        $sql = "insert into studenti(ID, meno, email,heslo)
VALUES('".$columns['ID']."','".$columns['meno']."','".$columns['mail']."','".$columns['heslo']."')";

    }

    $GLOBALS['conn']->query($sql);
}

function insertIntoTimy($teamNumber,$subjectID,$schoolYear){


    if(doesTeamExist($teamNumber)) // ak uz taky tim existuje, nepridavaj dalsi
        return;

    $sql = "insert into timy(cisloTimu,IDpredmetu,rok)
            VALUES('".$teamNumber."','".$subjectID."','".$schoolYear."')";

    $GLOBALS['conn']->query($sql);

}

function insertIntoClenoviaTimov($studentID,$teamNumber){

    // prvy clovek zapisany do timu, bude kapitanom
    // so student id zistit team, vratit ID a cisloTimu. ID vlozim do SQL, s cislomTimu zistim ci ma kapitana

    if(doesTeamHaveCaptain($teamNumber))
        $kapitanstvo='0';
    else
        $kapitanstvo='1';

    $sql = "insert into clenovaTimov(IDziaka,IDtimu,jeKapitan)
            VALUES('".$studentID."','".fetchTeamIDbyTeamNumber($teamNumber)."','".$kapitanstvo."')";

    $GLOBALS['conn']->query($sql);

}

//vrati prehladny fromat stlpcov
function fetchRowData($columns){ // add delimeter

    return array (

        'ID' => $columns[0],
        'meno' => $columns[1],
        'mail' => $columns[2],
        'heslo' => $columns[3],
        'teamNumber' => $columns[4]

    );

}

// najde v tabulke ID posledneho vlozeneho predmetu
function lastAddedSubjectID(){

    $sql = "select MAX(ID) as lastID from predmety";

    $result=$GLOBALS['conn']->query($sql);

    $row = $result->fetch_assoc();

    return $row['lastID'];

}

function doesTeamHaveCaptain($teamNumber){

    $sql = "SELECT jeKapitan
from clenovaTimov,timy
where clenovaTimov.IDtimu=timy.ID and cisloTimu='".$teamNumber."' and jeKapitan=true";

    $result=$GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0)
        return true;
    else
        return false;

}

function doesTeamExist($teamNumber){

    $sql = "SELECT ID
            from timy 
            WHERE cisloTimu='".$teamNumber."'";

    $result=$GLOBALS['conn']->query($sql);

    if ($result->num_rows > 0)
        return true;
    else
        return false;


}

function fetchTeamIDbyTeamNumber($teamNumber){

    $sql = "SELECT ID
            from timy
            where cisloTimu='".$teamNumber."'";

    $result=$GLOBALS['conn']->query($sql);

    $row = $result->fetch_assoc();

   return $row['ID'];

}
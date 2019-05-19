<?php
include 'config.php';

if(isset($_POST['teamID']) && isset($_POST['points'])) {


$sql = "UPDATE timy
set body='".$_POST['points']."' 
where ID='".$_POST['teamID']."'";

    $conn->query($sql); // updatovanie pointov

    $sql = "update clenovaTimov
set suhlas=null
where IDtimu='".$_POST['teamID']."'";

    $conn->query($sql); // ak admin zmenil hodnotenie, hlasovanie zacina odznovu




/*
    $sql = "UPDATE timy
        set body='".$_POST['points']."'
        where ID='".$_POST['teamID']."'";
    $conn->query($sql);
*/
/*
  echo var_dump($_POST['teamID']) ;
  echo var_dump($_POST['points'])  ;
*/

}




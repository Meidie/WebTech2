<?php
include 'config.php';

if(isset($_POST['teamID']) && isset($_POST['points'])) {


$sql = "UPDATE timy
set body='".$_POST['points']."' 
where ID='".$_POST['teamID']."'";
$conn->query($sql);


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




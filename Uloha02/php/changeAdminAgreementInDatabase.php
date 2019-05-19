<?php
include 'config.php';

if(isset($_POST['teamID']) && isset($_POST['agreement'])) {


$sql = "UPDATE timy
set schvaleneAdminom='".$_POST['agreement']."'
           where ID ='".$_POST['teamID']."'";
$conn->query($sql);



/*

  echo var_dump($_POST['teamID']) ;
  echo var_dump($_POST['agreement'])  ;
*/

}


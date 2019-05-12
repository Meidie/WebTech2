<?php

$dbServerName='localhost';
$dbUserName= "samuelP";
$dbPassword="Kiaarena3326";
$dbName="finalProjekt";

$conn=new mysqli($dbServerName,$dbUserName,$dbPassword,$dbName);

mysqli_set_charset($conn,"utf8");
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
//echo "Connected successfully";


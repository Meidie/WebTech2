<?php

$dbServerName="localhost";
$dbUserName= "xmacakn";
$dbPassword="Heslo12345";
$dbName="finalProjekt";

$conn=new mysqli($dbServerName,$dbUserName,$dbPassword,$dbName);

mysqli_set_charset($conn,"utf8");
/*
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

*/
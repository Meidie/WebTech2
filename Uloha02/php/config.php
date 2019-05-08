<?php

$dbServerName="localhost";
$dbUserName= "xmacakn";
$dbPassword="Heslo12345";
$dbName="finalProjekt";

$conn=new mysqli($dbServerName,$dbUserName,$dbPassword,$dbName);

mysqli_set_charset($conn,"utf8");

/*
mysql_query("SET character_set_results=utf8", $conn);
mb_language('uni');
mb_internal_encoding('UTF-8');
mysql_select_db($dbServerName, $conn);
mysql_query("set names 'utf8'",$conn);
*/


/*
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
*/






<?php

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$pieces = explode("/", $actual_link);


$servername="localhost";
$username="xorths";
$password="qjj6unGaBIaw";
$db="webtech2";
$conn = new mysqli($servername, $username, $password, $db, 8105);
mysqli_set_charset($conn, "utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    // echo"Pripojeny";
}
$id_sablony = $pieces[6];

switch ($method) {
    case 'GET':

        if($id_sablony != null || $id_sablony != ""){
            $sql = "SELECT text FROM sablony WHERE id =$id_sablony";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo  $row["text"];
                    http_response_code(200);
                }
            }
            else {
                http_response_code(404);
            }
            break;
        }
}
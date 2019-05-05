<?php

//import.php


function generateRandomString($length = 10){
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)))),1, $length);
}

function verejnaip()
{
    $x = "147.175.121.210";
    return $x;
}
function privatnaip($i)
{
    $x="192.168.0.";
    $x .=$i;
    return $x;
}

if(!empty($_FILES['csv_file']['name']))
{
    $file_data = fopen($_FILES['csv_file']['name'], 'r');
    fgetcsv($file_data);
    $i=0;
    while($row = fgetcsv($file_data /*,10000,",")) !==FALSE*/))
    {
        $data[] = array(
            'id'  => $row[0],
            'name'  => $row[1],
            'email'  => $row[2],
            'login'  => $row[3],
            'heslo'  => generateRandomString(15),
            'verejnaIP' => verejnaip(),
            'privatnaIP' => privatnaip($i)
        );
        $i++;
    }
    echo json_encode($data);
}

?>

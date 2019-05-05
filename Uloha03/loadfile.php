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
function ssh()
{
    $x = "2201";
    return $x;
}
function http()
{
    $x = "8001";
    return $x;
}
function https()
{
    $x = "4401";
    return $x;
}
function misc1()
{
    $x = "9001";
    return $x;
}
function misc2()
{
    $x = "1901";
    return $x;
}
if(!empty($_FILES['csv_file1']['name']))
{
    $file_data = fopen($_FILES['csv_file1']['name'], 'r');
    fgetcsv($file_data);
    while($row = fgetcsv($file_data /*,10000,",")) !==FALSE*/))
    {
        $data[] = array(
            'id'  => $row[0],
            'name'  => $row[1],
            'email'  => $row[2],
            'login'  => $row[3]
        );

    }
    echo json_encode($data);
}


if(!empty($_FILES['csv_file2']['name']))
{
    $file_data = fopen($_FILES['csv_file2']['name'], 'r');
    fgetcsv($file_data);
    $i=1;
    while($row = fgetcsv($file_data /*,10000,",")) !==FALSE*/))
    {
        $data[] = array(
            'id'  => $row[0],
            'name'  => $row[1],
            'email'  => $row[2],
            'login'  => $row[3],
            'heslo'  => generateRandomString(15),
            'verejnaIP' => verejnaip(),
            'privatnaIP' => privatnaip($i++),
            'ssh' => ssh(),
            'http' =>http(),
            'https' => https(),
            'misc1' => misc1(),
            'misc2' => misc2()
        );

    }
    echo json_encode($data);
}
?>

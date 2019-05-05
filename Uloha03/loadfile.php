<?php

//import.php

if(!empty($_FILES['csv_file']['name']))
{
    $file_data = fopen($_FILES['csv_file']['name'], 'r');
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

?>

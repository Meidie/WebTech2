<?php
include_once 'config.php';

$sql = "SELECT ID,body, suhlas from clenovaTimov
        where EXISTS (
    select ID
    from timy
    where IDpredmetu = (SELECT max(ID) from predmety)
    and timy.ID=clenovaTimov.Idtimu
    )";
$result = $conn->query($sql);


if ($result->num_rows > 0) { // ak existuju zaznamy

    $idArray=array(); // pole pre suradnice
    $pointArray=array();
    $agreementArray=array();

    while($row = $result->fetch_assoc()) { // cyklus pre vypis krajiny a poctu pristupov


        array_push($idArray,$row['ID']); // do pola suradnice pushnem suradnice z databazy

        array_push($pointArray,$row['body']);

        array_push($agreementArray,$row['suhlas']);

    }

    $arrays->idArray= $idArray; // vytvorim objekt a zapisem donho pole suradnice
    $arrays->pointArray= $pointArray;
    $arrays->agreementArray= $agreementArray;

   // var_dump($arrays);

    echo json_encode($arrays);


}else{  // ak neexistuju poslem json kde lat je null
    $data->idArray=null;
    echo json_encode($arrays);}


<?php
include_once 'config.php';


$sql = "select count(IDziaka) as vsetci,
(SELECT COUNT(*) from clenovaTimov where suhlas=true and EXISTS (
    select ID
    from timy
    where IDpredmetu = (SELECT max(ID) from predmety)
    and timy.ID=clenovaTimov.Idtimu
    )) as suhlasiaci,

(SELECT count(*) from clenovaTimov where suhlas=false and EXISTS (
    select ID
    from timy
    where IDpredmetu = (SELECT max(ID) from predmety)
    and timy.ID=clenovaTimov.Idtimu
    )) as nesuhlasiaci,
    
    
(SELECT count(*) from clenovaTimov where suhlas is null and EXISTS (
    select ID
    from timy
    where IDpredmetu = (SELECT max(ID) from predmety)
    and timy.ID=clenovaTimov.Idtimu
    ) ) as nevyjadreni


from clenovaTimov
where EXISTS (
    select ID
    from timy
    where IDpredmetu = (SELECT max(ID) from predmety)
    and timy.ID=clenovaTimov.Idtimu
    )";

$result = $conn->query($sql);



if ($result->num_rows > 0){

    $row = $result->fetch_assoc();


    $statistic->allStudents=$row['vsetci'];
    $statistic->agreedStudents=$row['suhlasiaci'];
    $statistic->disagreedStudents=$row['nesuhlasiaci'];
    $statistic->unexpressedStudents=$row['nevyjadreni'];

    $sql = "select count(ID) as vsetci,
(SELECT COUNT(*) from timy where schvaleneKapitanom=true and schvaleneAdminom=true and IDpredmetu = (SELECT max(ID) from predmety)) as uzavrete,

(SELECT COUNT(*) from timy where schvaleneKapitanom is not null and schvaleneAdminom is null and IDpredmetu = (SELECT max(ID) from predmety)) as nevyjadreneAdminom,

(SELECT COUNT(*) from timy where schvaleneKapitanom is null and schvaleneAdminom is null and IDpredmetu = (SELECT max(ID) from predmety)) as nevyjadreneStudentmi
from timy
where IDpredmetu = (SELECT max(ID) from predmety)"; // vypise statistiky posledneho pridatenho predmetu

    $result = $conn->query($sql);

    $row = $result->fetch_assoc();

    $statistic->allTeams=$row['vsetci'];
    $statistic->closedTeams=$row['uzavrete'];
    $statistic->undexpresseBydAdmin=$row['nevyjadreneAdminom'];
    $statistic->unexpressedByStudents=$row['nevyjadreneStudentmi'];


    echo json_encode($statistic);

}



//$coordinates->hi= "aloha";

//echo "aloha";

//echo json_encode($coordinates);
<?php
/*TODO

dokoncit dvojjazycnost
umoznit rozklikavacie riadky tabulky

odsuhlasenie adminom
vypisanie stavu
*/

include_once 'config.php';

$GLOBALS['conn']=$conn;


if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../lang/eng.php');
}else{$language = include('../lang/svk.php');}

$GLOBALS['language']=$language; // pre zmenu jazyku vo funkciach

/*

 * vypis studentov
 * js name of file after chosing
 * school year - moznosti vygenerovane by php date
 */


?>

<!DOCTYPE html>
<html lang="<?php echo $language['websiteLang']; ?>">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--jQuery Datatables CSS-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <!--jQuery Animation-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <title>ADMIN</title>
</head>


<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="https://147.175.121.210:4171/files/SkuskoveZadanie/WebTech2/index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="../img/logo.png"> </a>

        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="admin.php?lang=sk"> <img src="../img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="admin.php?lang=en"> <img src="../img/uk.png" height="30" alt="uk"></a></div>

            </li>
            <li class="navbar-item">
                <a class="nav-link" id="logout" href="logout.php"><?php echo  $language['logout']?></a>
            </li>
        </ul>
    </nav>

</header>

<body>

<div class="container">

    <form action="csvIntoDatabase.php" method="post" id="addResults" enctype="multipart/form-data">

        <h2><?php echo $language['formHeader']; ?></h2>

        <div class="form-inline">

        <div class="form-group ">

            <label for="schoolYear"> <?php echo $language['schoolYear']; ?> </label>
            <select name="schoolYear" class="form-control" id="schoolYear">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
            </select>

        </div>

        <div class="form-group">

            <label for="subject"><?php echo $language['subjectName']; ?></label>
            <input name="subject" type="text" class="form-control" id="subject" placeholder="<?php echo $language['subjectNamePlaceholder']; ?>">

        </div>

        </div>

        <div class="form-inline">

        <div class="form-group">

            <label for="resultCSV"><?php echo $language['CSVfile']; ?></label>

            <div class="custom-file">
                <input  name="csvPath" type="file" class="custom-file-input" id="resultCSV" lang="es">
                <label class="custom-file-label" for="resultCSV"><?php echo $language['CSVfilePlaceholder']; ?></label>
            </div>

        </div>


            <div class="form-group" id="separatorDiv">

            <label for="separator"><?php echo $language['separator']; ?></label>
            <select name="separator" class="form-control" id="separator">
                <option value=";">;</option>
                <option value=",">,</option>

            </select>

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    <input type="hidden" name="permission" value="granted">


    </form>

    <div id="test">p</div>

    <h2><?php echo $language['teamOverview']; ?></h2>


    <table class="table">
        <thead>
        <tr>
            <th scope="col"><?php echo $language['teamNumber']; ?></th>
            <th scope="col"><?php echo $language['points']; ?></th>
            <th scope="col"><?php echo $language['state']; ?></th>

        </tr>
        </thead>

        <tbody>

        <?php
        $sql = "SELECT * FROM timy";
        $result = $conn->query($sql);

        $GLOBALS['generatedID']=0; // toto ID je pridelovane inputom vo vyslednej tabulke

        if ($result->num_rows > 0){

            while($row = $result->fetch_assoc()) {

                $stateToPrint=stateToPrint(stateOfEvaluating($row['body'], $row['schvaleneKapitanom'], $row['schvaleneAdminom']));

            echo "<tr class=\"header\">";

            echo "<td>".$row['cisloTimu']."</td><td>".manageTeamPoints($row['body'],$row['ID'])."</td>
            
                  <td>".$stateToPrint."</td>";

            echo "</tr>";

            teamTable($row['ID']);

            adminAgreement($row['ID']);

            $GLOBALS['generatedID']++; // Iteruje sa s kazdym novym zaznamom

            }

        }

        ?>

        </tbody>
    </table>



    <?php

    function stateToPrint($state){

        if(!strcmp($state,"noPoints"))
            return $GLOBALS['language']['enteringPoints'];

        else if(!strcmp($state,"adminAgrees"))
            return $GLOBALS['language']['successfullyClosed'];

        else if(!strcmp($state,"adminDisagrees"))
            return $GLOBALS['language']['deniedByAdmin'];

        else if(!strcmp($state,"teamAgrees"))
            return $GLOBALS['language']['teamInAgreement'];

        else if(!strcmp($state,"teamDisagrees"))
            return $GLOBALS['language']['teamInDisagreement'];

        else if(!strcmp($state,"voting"))
            return $GLOBALS['language']['teamIsVoting'];

    }

    function stateOfEvaluating($points, $teamAgreement, $adminAgreement){
        if(is_null($points))
            return "noPoints";
        else{
            if(!strcmp($adminAgreement,"1"))
                return "adminAgrees";

            else if(!strcmp($adminAgreement,"0"))
                return "adminDisagrees";

            else if(!strcmp($teamAgreement,"1"))
                return "teamAgrees";

            else if(!strcmp($teamAgreement,"0"))
                return "teamDisagrees";

            else
                return "voting";

        }



    }

    function adminAgreement($teamID){

        $stateOfButtons=shouldBeDisabled($teamID); // vrati null ak tlacidla maju byt aktivne
                                                    // vrati disabled ak sa tim este nedohodol

        echo "<tr class=\"overview\">";
        echo "<td>Rozhodnutie administrátora</td>";
        echo "<td colspan=\"2\">";          // posiela request na zmenu stplca schvaleneAdminom v dbs. Success button posle 1. danger button 0
        echo "<button type=\"button\"  class=\"btn btn-success\" onclick='changeAdminAgreementInDatabase($teamID,1)' $stateOfButtons >".$GLOBALS['language']['agree']."</button>";
        echo "<button type=\"button\"  class=\"btn btn-danger\"  onclick='changeAdminAgreementInDatabase($teamID,0)' $stateOfButtons >".$GLOBALS['language']['disagree']."</button>";
        echo "</td>";
        echo "</tr>";

    }

    function teamTable($teamID){

                    $sql = "SELECT studenti.ID as id, email, meno, body, suhlas
        FROM studenti, clenovaTimov
        WHERE studenti.ID=clenovaTimov.IDziaka and IDtimu='".$teamID."'";
                    $result = $GLOBALS['conn']->query($sql);

        echo "<tr class=\"overview\">";

        echo "<td colspan=\"3\">";

        echo "<table class=\"table\">";
        echo "<thead><tr>";

        echo "<td>Email </td><td>Meno </td><td>Body </td><td>Suhlas </td>";

        echo "</tr></thead>";

        echo "<tbody>";

    while($row = $result->fetch_assoc()) {

        echo "<tr>";

        echo "<td>".$row['email']."</td><td>".$row['meno']."</td><td>".printPoints($row['body'])."</td>";

        // treba spravit funkciu na rozhodnutie o pouziti agree obrazku
        echo "<td>
       <img alt=\"palec\" class=\"agreementIcon\" src=\"../teamOverviewIcons/".agreementIcon($row['suhlas'])."\"> 
             </td>";

        echo "</tr>";

    }

        echo "</tbody></table></td>";

        echo "</tr>";


    }

    function manageTeamPoints($teamPoints,$teamID){
    /*
     V globalanej premennej sa generuje ID, ktore sa prideluje inputom v tabulkach.
    Iteruje sa s kazdym opakovanim cyklu (s kazdou novou tabulkou timu).
    Preto ma kazdy input v kazdej tabulke jedinecne ID
    generatedID sa pouzije pri deklaracii id pre input a nasledne je pouzite vo funkcii, ktora odosiela ajax poziadavku.

     */


        return

            "<form class=\"form-inline\">".

            "<button  type=\"button\" class=\"btn btn-light\" onclick='changeTeamPointsInDatabase($teamID,".$GLOBALS['generatedID'].")'>".$GLOBALS['language']['confirm']."</button>".

            "<input id='pointsInput".$GLOBALS['generatedID']."' type=\"number\" class=\"form-control pointInput\" placeholder=\" ".$teamPoints."\">".


            "</form>";

    }

    function printPoints($points){

        if(is_null($points)) // body nie su zadane
            return "--";

        else                // body su zadane
            return $points;

    }

    function agreementIcon($agreement){

        if(is_null($agreement)) // suhlas je null
            return "questionMark.png";

        else if(!strcmp($agreement,"1")) // suhlas je true
            return "studentAgree.png";

        else if(!strcmp($agreement,"0")) // suhlas je false
            return "studnetDisagree.png";

    }

    function shouldBeDisabled($teamID){

        $sql = "SELECT 
case 
	when schvaleneKapitanom=true THEN 'null'
    ELSE 'disabled'
    end as stav
from timy
where ID='".$teamID."'";

        $result = $GLOBALS['conn']->query($sql);

        $row = $result->fetch_assoc();

        return $row['stav'];

    }

    function stateOfTeam($points,$agreementOfTeam,$agreementOfAdmin){
        if(is_null($points)) // ak admin este nezadal body
            echo "nezadane body";

        else{
            if($agreementOfAdmin==true)
                echo "Uspesne uzavrete";

            else if($agreementOfAdmin==false)
                echo "Zamietnute adminom";


            else if( $agreementOfTeam==false)
                echo "Nezhoda timu";

            else if( $agreementOfTeam==true)
                echo "Tim sa dohodol";


        }





    }

    ?>

    <script>


        function changeAdminAgreementInDatabase(teamID,agreement){

            $.post("changeAdminAgreementInDatabase.php",{ // asynchronne vykonany subor

                teamID: teamID,
                agreement: agreement // id inputu. Jedinenecne pre kazdu tabulku

            }, function (data) {

                $("#test").html(data); // data su udaje poslane echom z php scriptu
            })
        }

        function changeTeamPointsInDatabase(teamID,inputID){

            $.post("changePointsInDatabase.php",{ // asynchronne vykonany subor

                teamID: teamID,
                points: $("#pointsInput"+inputID).val() // id inputu. Jedinenecne pre kazdu tabulku

            }, function (data) {

                $("#test").html(data); // data su udaje poslane echom z php scriptu
            })
        }


        //   $(document).ready(function() {

/*
        $(document).ready(function(){

            $('.header').click(function () {
                //  $(this).find('span').text(function(_, value){return value=='-'?'+':'-'});
                $(this).nextUntil('tr.header').slideToggle(100); // or just use "toggle()"
            });

        });
*/
        //});

    </script>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
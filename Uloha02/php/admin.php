<?php
/*TODO

jquery auto load každých 10 sec

Export csv translate

odstranit funkciu z setTeamPointsIndatabse v JS

umoznit rozklikavacie riadky tabulky

skontrolovať koncovku .csv

remove maring from nested table

po importe poslať na admin.php s oznamom o vložení údajov. Succesdiv, čo po pár sec zmizne s animáciou

už ste zadali body. ste si istý, že ich chcete zmeniť ? alebo if value is null, zobrazi sa tlacidlo zmenit, namiesto potvrdit

delete osoby.csv,test.php,teamOverviewGeneratingFunctions.php

uprava css{
zarovanie contentu formularov

Num input v tabulke osestrit pri resize

buttons pre schvalenie

sfarbenie riadkov tabulky podla procesu+ohranicenie

}

dat do formu requied

file chooser prelozit browse do sk
*/

include_once 'config.php';

$GLOBALS['conn']=$conn;


if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../Adminlang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../Adminlang/eng.php');
}else{$language = include('../Adminlang/svk.php');}

$GLOBALS['language']=$language; // pre zmenu jazyku vo funkciach

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

    <link rel="stylesheet" type="text/css" href="../css/Adminstyle.css">
    <!--Graph.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <title>ADMIN</title>
</head>

<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="https://147.175.121.210:4171/files/SkuskoveZadanie/WebTech2/index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="../img/logo.png"> </a>

        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <?php
                if(strcmp($language['websiteLang'],"sk"))
                    echo "<div id=\"skDiv\"  ><a class=\"nav-link\" id=\"svk\" href=\"admin.php?lang=sk\"> <img src=\"../img/sk.png\" height=\"30\" alt=\"sk\"></a></div>";

                else
                    echo "<div id=\"enDiv\"  ><a class=\"nav-link\" id=\"eng\" href=\"admin.php?lang=en\"> <img src=\"../img/uk.png\" height=\"30\" alt=\"uk\"></a></div>";

                ?>
            </li>
            <li class="navbar-item">
                <a class="nav-link" id="logout" href="logout.php"><?php echo  $language['logout']?></a>
            </li>
        </ul>
    </nav>

</header>


<body onload="getStatisticFromDatabase();getStudentDataFromDatabase()">



<div class="container">

    <form action="csvIntoDatabase.php" method="post" id="csvImport" enctype="multipart/form-data" class="float-left col-md-6 col-sm-12 col-xs-12">

        <h2 class="text-center"><?php echo $language['formImportHeader']; ?></h2>

          <div class="form-inline">

        <div class="form-group col-xs-4">

            <label for="schoolYear"> <?php echo $language['schoolYear']; ?> </label>
            <select name="schoolYear" class="form-control" id="schoolYear">
                <?php
                for($i=0;$i<=2;$i++){
                        $year=date("Y",strtotime("-".$i." year"));

                        echo "<option value=\"".$year."\">".$year."</option>";
                }

                ?>
            </select>

        </div>

        <div class="form-group col-xs-4 ">

            <label for="subject"><?php echo $language['subjectName']; ?></label>
            <input name="subject" type="text" class="form-control" id="subject" placeholder="<?php echo $language['subjectNamePlaceholder']; ?>">

        </div>

          </div>

        <div class="form-inline">

        <div class="form-group col-xs-4" >

            <label  for="resultCSV"><?php echo $language['CSVfile']; ?></label>

            <div class="custom-file">
                <input  name="csvPath" type="file" class="custom-file-input" id="resultCSV" lang="es">
                <label class="custom-file-label" for="resultCSV"><?php echo $language['CSVfilePlaceholder']; ?></label>
            </div>

        </div>


            <div class="form-group form-inline col-xs-4" id="separatorDiv">

            <label for="separator"><?php echo $language['separator']; ?></label>
            <select name="separator" class="form-control" id="separator">
                <option value=";">;</option>
                <option value=",">,</option>
            </select>

            </div>

        </div>

        <div class="form-group form-inline">

            <button   type="submit" id="submitButton" class="btn btn-primary ">Submit</button>

        </div>

    <input type="hidden" name="permission" value="granted">

    </form>



        <form action="csvexport.php" method="post" id="csvExport" class="float-right col-md-6 col-sm-12 col-xs-12" >
            <h2 class="text-center"><?php echo $language['formExportHeader']; ?></h2>

            <div class="form-inline">
                <div>
                    <select class="form-control" required name="predmet">
                        <option value="" selected disabled>Vyberte možnosť</option>
                        <?php
                        $sql = "SELECT nazov from predmety;";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                print ("<option value='" . $row['nazov'] . "'>" . $row['nazov'] . "</option>");
                            }
                        }
                        ?>
                    </select>
                </div>
                <div >
                    <select class="form-control" required name="rok">
                        <option value="" selected disabled>Vyberte možnosť</option>
                        <?php
                        $sql = "SELECT distinct (rok)from timy;";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                print ("<option value='" . $row['rok'] . "'>" . $row['rok'] . "</option>");
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-warning">
            </div>
        </form>

    <div id="graphs">

        <canvas class="col-lg-6 col-sm-12 col-xs-12" id="studentsChart"></canvas>

        <canvas class="col-lg-6 col-sm-12 col-xs-12" id="teamsChart" ></canvas>

    </div>

    <script>
        /*


        select IDziaka
from clenovaTimov
where EXISTS (
select ID
from timy
where IDpredmetu=12
and timy.ID=clenovaTimov.Idtimu
)

select count(IDziaka) as vsetci,
(SELECT COUNT(*) from clenovaTimov where suhlas=true) as suhlasiaci,
(SELECT count(*) from clenovaTimov where suhlas=false) as nesuhlasiaci,
(SELECT count(*) from clenovaTimov where suhlas is null ) as nevyjadreni
from clenovaTimov
where EXISTS (
select ID
from timy
where IDpredmetu=12
and timy.ID=clenovaTimov.Idtimu
)


select count(ID) as vsetci,
(SELECT COUNT(*) from timy where schvaleneKapitanom=true and schvaleneAdminom=true) as uzavrete,
(SELECT COUNT(*) from timy where schvaleneKapitanom=true and schvaleneAdminom is null) as nevyjadreneAdminom,
(SELECT COUNT(*) from timy where schvaleneKapitanom is null and schvaleneAdminom is null) as nevyjadreneStudentmi
from timy
where IDpredmetu=12



         */

        function getStatisticFromDatabase() {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {




                    var myObj = JSON.parse(this.responseText);

                    /* width="400" height="100"
                    document.getElementById("test").innerText=
                        myObj.allStudents+','+myObj.agreedStudents+','+myObj.disagreedStudents+','+myObj.unexpressedStudents+
                    ','+myObj.allTeams+','+myObj.closedTeams+','+myObj.undexpresseBydAdmin+','+myObj.unexpressedByStudents;
                   */

                    let studentAxioms;
                    let teamAxioms;

                    if(!document.documentElement.lang.localeCompare("sk")){
                        studentAxioms=["Študenti", "Súhlasiaci", "Nesúhlasiaci", "Nevyjadrení"];
                        teamAxioms=["Tímy", "Úspešne uzavreté", "Zatiaľ neschválené", "Nevyjadrené"];
                    }
                    else {
                        studentAxioms=["Students", "In agreement", "In disagreement", "Unexpressed"];
                        teamAxioms=["Teams", "Successfully closed", "Not approved yet", "Unexpressed"];
                    }


                    crateChart("studentsChart",studentAxioms,
                        myObj.agreedStudents,myObj.disagreedStudents,myObj.unexpressedStudents);

                    crateChart("teamsChart",teamAxioms,
                        myObj.closedTeams,myObj.undexpresseBydAdmin,myObj.unexpressedByStudents);


                }
            };
            xmlhttp.open("GET", "getStatisticFromDatabase.php", true);
            xmlhttp.send();
        }


        function crateChart(chartCanvas,axioms,data1,data2,data3) {
            new Chart(document.getElementById(chartCanvas), {
                type: 'pie',
                data: {
                    labels: [axioms[1],axioms[2],axioms[3]],
                    datasets: [{
                        label: "Population (millions)",
                        backgroundColor: ["#7DF780", "#B51B12","#F0B705"],
                        data: [data1,data2,data3]
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: axioms[0]
                    }
                }
            });
        }
        /*
                    new Chart(document.getElementById("pie-chart"), {
                        type: 'pie',
                        data: {
                            labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                            datasets: [{
                                label: "Population (millions)",
                                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                                data: [2478,5267,734,784,433]
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: 'Predicted world population (millions) in 2050'
                            }
                        }
                    });

                  */

    </script>


    <!--  <div id="test">p</div> -->


    <div>
    <h2 class="text-center"><?php echo $language['teamOverview']; ?></h2>


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
        $sql = "SELECT * FROM timy order by cisloTimu";
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
        echo "<td>".$GLOBALS['language']['approval']."</td>";
        echo "<td  colspan=\"2\">";          // posiela request na zmenu stplca schvaleneAdminom v dbs. Success button posle 1. danger button 0
        echo "<div class=\"text-center\">";
        echo "<button type=\"button\"  class=\"btn btn-success mr-5  \" onclick='changeAdminAgreementInDatabase($teamID,1)' $stateOfButtons >".$GLOBALS['language']['agree']."</button>";
        echo "<button type=\"button\"  class=\"btn btn-danger \"  onclick='changeAdminAgreementInDatabase($teamID,0)' $stateOfButtons >".$GLOBALS['language']['disagree']."</button>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";

    }

    function teamTable($teamID){

                    $sql = "SELECT clenovaTimov.ID as id, email, meno, body, suhlas
        FROM studenti, clenovaTimov
        WHERE studenti.ID=clenovaTimov.IDziaka and IDtimu='".$teamID."'";
                    $result = $GLOBALS['conn']->query($sql);

        echo "<tr class=\"overview\">";

        echo "<td colspan=\"3\">";

        echo "<table class=\"table\">";
        echo "<thead><tr>";

        echo "<td>Email </td><td>".$GLOBALS['language']['name']."</td><td>".$GLOBALS['language']['points']."</td><td>".$GLOBALS['language']['agreement']."</td>";

        echo "</tr></thead>";

        echo "<tbody>";

    while($row = $result->fetch_assoc()) {

        echo "<tr>";

     //   echo "<td>".$row['email']."</td><td>".$row['meno']."</td><td >".printPoints($row['body'])."</td>";
        echo "<td>".$row['email']."</td><td>".$row['meno']."</td><td id='pointsOfstudent".$row['id']."'>'pointsOfstudent".$row['id']."'</td>";

        echo "<td id='agreementIconOfstudent".$row['id']."'></td>";
/*
        // treba spravit funkciu na rozhodnutie o pouziti agree obrazku
        echo "<td>
       <img alt=\"palec\" class=\"agreementIcon\" src=\"../teamOverviewIcons/".agreementIcon($row['suhlas'])."\"> 
             </td>";
*/
        echo "</tr>";

    }

        echo "</tbody></table></td>";

        echo "</tr>";
/*
 grafy

 server bude posielat json array kazdych 10 sec.
v nom bude id(clenovia timov), body, suhlas

aplikacia to bude vykreslovat v cykle pre kazdy zaznam v tabulke

v tabulke staci ked bude id. nic viac netreba --------------------------------------------------------------------------------------------


  */

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

            "<input id='pointsInput".$GLOBALS['generatedID']."' type=\"number\" class=\"form-control pointInput\" value=\"".$teamPoints."\">".


            "</form>";
            // Body su v placeholderi. Nie predvyplnene
        // "<input id='pointsInput".$GLOBALS['generatedID']."' type=\"number\" class=\"form-control pointInput\" placeholder=\" ".$teamPoints."\">".

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

    </div>

    <script>
        /*
        $(document).ready(function(){
            setInterval(function(){
                getStatisticFromDatabase();
                getStudentDataFromDatabase()
                //$("#graphs").load('admin.php')
            }, 2000);
        });*/
    </script>

    <script>


        function getStudentDataFromDatabase() {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {




                    var myObj = JSON.parse(this.responseText);

                    /* width="400" height="100"
                    document.getElementById("test").innerText=
                        myObj.allStudents+','+myObj.agreedStudents+','+myObj.disagreedStudents+','+myObj.unexpressedStudents+
                    ','+myObj.allTeams+','+myObj.closedTeams+','+myObj.undexpresseBydAdmin+','+myObj.unexpressedByStudents;
                   */

                    updateRows(myObj);

                }
            };
            xmlhttp.open("GET", "getStudentDataFromDatabase.php", true);
            xmlhttp.send();
        }

        function updateRows(jsonData) { // zavola placeMarker n krat

            for(let i=0; i<jsonData.idArray.length;i++){ // dlzka pola

                updateDataInRow(jsonData.idArray[i], jsonData.pointArray[i],jsonData.agreementArray[i]) // suradnice su string. nutna kovnerzia na Numeric data type

            }
        }

        function updateDataInRow(id, points, agreement){

            $("#pointsOfstudent"+id).html(points);

            appendAgreementPicture(id,agreement);

        }
    // do stlpca pre suhlas appenduje obrazok podla suhlasu clena
        function appendAgreementPicture(id, agreement){

            let iconName;
            let agreementPicture=document.createElement("img");


            if(!agreement)  // vybera vhodnu ikonu podla suhlasu
                iconName="questionMark";

            else if(!agreement.localeCompare("1"))
                iconName="studentAgree";

            else if(!agreement.localeCompare("0"))
                iconName="studnetDisagree";



            agreementPicture.src="../teamOverviewIcons/"+iconName+".png";
           // agreementPicture.src="../teamOverviewIcons/studnetDisagree.png";
            agreementPicture.alt="agreement icon";
            agreementPicture.classList.add("agreementIcon");

            document.getElementById("agreementIconOfstudent"+id).appendChild(agreementPicture);


        }



        function changeAdminAgreementInDatabase(teamID,agreement){

            $.post("changeAdminAgreementInDatabase.php",{ // asynchronne vykonany subor

                teamID: teamID,
                agreement: agreement // id inputu. Jedinenecne pre kazdu tabulku

            })
        }

        function changeTeamPointsInDatabase(teamID,inputID){

            $.post("changePointsInDatabase.php",{ // asynchronne vykonany subor

                teamID: teamID,
                points: $("#pointsInput"+inputID).val() // id inputu. Jedinenecne pre kazdu tabulku

            })
        }

    </script>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
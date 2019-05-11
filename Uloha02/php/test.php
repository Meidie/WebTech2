<?php
/*
if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../lang/eng.php');
}else{$language = include('../lang/svk.php');}
*/
/*

 * vypis studentov
 * js name of file after chosing
 * school year - moznosti vygenerovane by php date
 */

/*
Stavy
prebieha hlasovanie
schvalene timom
zamietnute timom
schvalene adminom
zamietnute adminom


 */


?>

<!DOCTYPE html>
<html lang="sk">
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

    <title>TEST</title>
</head>


<body>

<div class="container">


    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Team number</th>
            <th scope="col">Body</th>
            <th scope="col">Stav</th>

        </tr>
        </thead>
        <tbody>
        <tr class="header">
            <td> 42</td>
            <td> 55.5</td>
            <td> Prebieha hlasovanie</td>
        </tr>

        <tr class="overview">

            <td class="col-sm" colspan="3">
                <table class="table">
                    <thead>
                    <tr>
                        <td class="mail">Email </td>
                        <td>Meno </td>
                        <td>Body </td>
                        <td>Suhlas </td>

                    </tr>
                        </thead>
                    <tbody>
                    <tr>
                        <td>xmacakn@gmail.com </td>
                        <td>Nicolas Macak </td>
                        <td>25 </td>
                        <td><img alt="palec" class="agreementIcon" src="../teamOverviewIcons/studentAgree.png"> </td>

                    </tr>
                    <tr>
                        <td>xpohancenikm@gmail.com </td>
                        <td>Matus Pohancenik </td>
                        <td>30 </td>
                        <td>Dosnt </td>

                    </tr>
                    </tbody>
                </table>


            </td>

        </tr>

        <tr class="overview">
            <td>Rozhodnutie administrátora</td>
            <td colspan="2">
                <button type="button"  class="btn btn-success" >Súhlasím</button>
                <button type="button"  class="btn btn-danger" >Nesúhlasím</button>
            </td>
        </tr>




                    </tbody>
                </table>

    <style>

        .overview{
          /*  display: none; */
        }

        .agreementIcon{
            width: 25px;
            height: 25px;
        }
        

    </style>

    <div id="time">
        <?php echo date('H:i:s');?>
    </div>

    


    <script>

        //   $(document).ready(function() {


        $(document).ready(function(){

        $('.header').click(function () {
            //  $(this).find('span').text(function(_, value){return value=='-'?'+':'-'});
            $(this).nextUntil('tr.header').slideToggle(100); // or just use "toggle()"
        });

        });

        //});

    </script>




</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
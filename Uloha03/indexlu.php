<?php
//index.php
?>
<!DOCTYPE html>
<html>
<head>


    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Webtech Projekt</title>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        .box
        {
            max-width:800px;
            width:100%;
            margin: 0 auto;;
        }
    </style>
</head>
<body>
<header>
    <!-- <h1 id="tit_load">
         Načítanie údajov
     </h1>
     <nav>
         <ul class="menu">
             <li class="menu"><a href="index.php">Upload csv</a></li>
             <li class="menu"><a href="mailinfo.php">Mail info</a></li>
         </ul>
     </nav> -->

    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="https://147.175.121.210:4171/files/SkuskoveZadanie/WebTech2/index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="../Login/img/logo.png"> </a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <!--<h1 class="text-white"></h1>-->
            </li>
            <li class="navbar-nav mr-auto active">
                <a class="nav-link" href="indexlu.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['profile']?>Upload csv</a>
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="mailinfo.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['results']?>Mail info</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="index.php?lang=sk"> <img src="../Login/img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="index.php?lang=en"> <img src="../Login/img/uk.png" height="30" alt="uk"></a></div>
                <?php

                //vykreslenie spravnej vlajky
                if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){

                    echo '<script>document.getElementById("skDiv").style.display = "none";</script>';
                    echo '<script>document.getElementById("enDiv").style.display = "";</script>';
                }else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){

                    echo '<script>document.getElementById("skDiv").style.display = "";</script>';
                    echo '<script>document.getElementById("enDiv").style.display = "none";</script>';
                }else{

                    echo '<script>document.getElementById("skDiv").style.display = "none";</script>';
                    echo '<script>document.getElementById("enDiv").style.display = "";</script>';
                }
                ?>
            </li>
        </ul>
    </nav>

</header>

<!--------------------------------------------------------------------
-----------------------Prve nacitavanie udajov------------------------>
<div class="container">
    <br />
    <h3 align="center">Prvé načítanie údajov</h3>
    <br />
    <form id="upload_csv1" method="post" enctype="multipart/form-data" action="">
        <div class="col-md-4">
            <input type="file" name="csv_file1" id="csv_file1" accept=".csv" style="margin-top:15px;" />
        </div>
        <div class="col-md-5">
            <br>Čiarka / bodkočiarka: <input type="text" name="ciarka1" id="ciarka"  pattern=",|;" required>
        </div>
        <div class="col-md-5">
            <input type="submit" name="upload1" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-info" />
        </div>

        <div style="clear:both"></div>
        <br>
        <a href="upraveny_subor.csv" >Stiahnuť upravený súbor </a>
    </form>
    <br />
    <br />

           <?php
           if(!empty($_FILES['csv_file1'])) {
               $path = "uploads/";
               $path = $path . basename($_FILES['csv_file1']['name']);
               if (move_uploaded_file($_FILES['csv_file1']['tmp_name'], $path)) {
                  /* echo "The file " . basename($_FILES['csv_file1']['name']) .
                       " has been uploaded";*/
               } else {
                   echo "There was an error uploading the file, please try again!";
               }


               $premenna = $_POST["ciarka1"];
               $jedenkrat = 0;
                $list=array();

               if (($handle = fopen($path, 'r')) !== FALSE) { // Check the resource is valid
                   echo "    <div class=\"table-responsive\">
                               <table class=\"table table-striped table-bordered\" id=\"customer-data\">
                                 <thead>
                                  <tr>";
                   while (($data = fgetcsv($handle, 1000, "$premenna")) !== FALSE) {
                       $i = 0;

                           if($jedenkrat == 0){
                               while ($i < count($data)) {
                                   echo "<th>" . utf8_encode($data[$i]) . "</th>";
                                   $i++;
                               }
                               echo"<th>Heslo</th>
                                    </tr>
                                    </thead>";
                               $jedenkrat = 1;
                           }

                       echo "<tr>";

                       while ($i < count($data)) {

                           echo "<td>" . $data[$i] . "</td>";
                           array_push($list,$data[$i]);
                           $i++;
                           if($i == count($data)) {
                               $heslo=generateRandomString(15);
                               array_push($list,$heslo);

                               echo "<td>" . $heslo . "</td>";
                               echo "</tr>"; }
                       }

                   }
                   $pole=array_chunk($list,5, true);
                   $file = fopen("upraveny_subor.csv","w");
                    if($premenna==';')
                    {
                        foreach ($pole as $line)
                        {
                            fputcsv($file,$line,";");
                        }
                    }
                    else
                    {
                        foreach ($pole as $line)
                        {
                            fputcsv($file,$line,",");
                        }
                    }

                   fclose($file);
                   fclose($handle);
               }
           }
           $jedenkrat = 0;
                    ?>
        </table>

    </div>
</div>


<!---------------------------------------------------------------------
------------------------Druhe nacitavanie udajov------------------------->
<div class="container">
    <br />
    <h3 align="center">Druhé načítanie údajov</h3>
    <br />
    <form id="upload_csv2" method="post" enctype="multipart/form-data">
        <div class="col-md-4">
            <input type="file" name="csv_file2" id="csv_file2" accept=".csv" style="margin-top:15px;" />
        </div>
        <div class="col-md-5">
            <br>Čiarka / bodkočiarka: <input type="text" name="ciarka2" id="ciarka"  pattern=",|;" required>
        </div>
        <div class="col-md-5">
            <input type="submit" name="upload" id="upload" value="Upload" style="margin-top:10px;" class="btn btn-info" />
        </div>
        <div style="clear:both"></div>
    </form>
    <br />
    <br />

            <?php

            function generateRandomString($length = 10)
            {
                return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
            }

   /*         function verejnaip()
            {
                $x = "147.175.121.210";
                return $x;
            }

            function privatnaip($i)
            {
                $x = "192.168.0.";
                $x .= $i;
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
            }*/
            if(!empty($_FILES['csv_file2'])) {
                $path = "uploads/";
                $path = $path . basename($_FILES['csv_file2']['name']);
                if (move_uploaded_file($_FILES['csv_file2']['tmp_name'], $path)) {
                    /*echo "The file " . basename($_FILES['csv_file2']['name']) .
                        " has been uploaded";*/
                } else {
                    echo "There was an error uploading the file, please try again!";
                }
                if (!empty($_FILES['csv_file2']['name'])) {
                    $premenna = $_POST["ciarka2"];
                    if (($handle = fopen($path, 'r')) !== FALSE) { // Check the resource is valid
                        $poc = 1;
                        echo "    <div class=\"table-responsive\">
                               <table class=\"table table-striped table-bordered\" id=\"customer-data\">
                                 <thead>
                                  <tr>";
                        while (($data = fgetcsv($handle, 1000, "$premenna")) !== FALSE) {
                                $i = 0;

                                if($jedenkrat == 0){
                                    while ($i < count($data)) {
                                        echo "<th>" . utf8_encode($data[$i]) . "</th>";
                                        $i++;
                                    }
                                    echo"</tr>
                                    </thead>";
                                }
                                else{
                                    echo"<tr>";
                                }


                            while ($i < count($data)) {
                                echo "<td>" . $data[$i] . "</td>";$i++;
                            }
                                if($jedenkrat == 0){
                                    $jedenkrat = 1;
                                }
                                else{
                                    echo"</tr>";
                                }

                        }
                        fclose($handle);
                    }
                }
            }
            $jedenkrat = 0;

            ?>
        </table>
    </div>
</div>
<!-----------------------------------------------------------------------------
---------------------------Odosielanie mailu---------------------------------->
<form action="" method="post">
    Y/N:<br>
    <input type="text" name="pismeno">
    <br>

    <input type="submit" value="Submit">
</form>
<?php
/*if (isset($_POST["pismeno"])) {
   // phpinfo();

    $mailto = 'xorths@stuba.sk';
    $subject = 'the subject';
    $message = 'the message';
    $from = 'xorths@stuba.sk\r\n';
    $header = 'From:'.$from;


  //  $headers = "From:xorths@stuba.sk\r\n";
  //  $recipients = "samuelorth62@gmail.com, samuelorth68@gmail.com";
  //  if (mail($recipients, "Predmet", "Ahoj, rad by som sa ti podakoval za", $headers))
    if(mail($mailto,$subject,$message,$header))
    {
        echo "mail is send";
    }

    else {
        echo "Can not send mail";
    }

}*/

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = "mail.stuba.sk";
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'xkolumber@stuba.sk';
$mail->Password = 'eFa.ohi.2.sir';

$mail->setFrom('xkolumber@stuba.sk', 'Ľuboš Kolumber');
$mail->addAddress('xkolumber@stuba.sk');
$mail->Subject = 'SMTP email test';
$mail->Body = 'this is some body';

if ($mail->send())
    echo "Mail sent";
?>
</body>
</html>

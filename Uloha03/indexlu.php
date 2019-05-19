<?php

session_start();

//if(!isset($_SESSION['admin'])){header('Location: ../index.php?lang='.$language['websiteLang']); exit();}

if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('lang/eng.php');
}else{$language = include('lang/svk.php');}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" lang="<?php echo $language['websiteLang']?>">
<head>


    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Mail</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <style>
        .box
        {
            max-width:800px;
            width:100%;
            margin: 0 auto;;
        }
    </style>
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=gq5pnp077xwzrzk122wbe3c92dfl5qx4cvh0bnc9z8g00gcf"></script>

    <script>tinymce.init({selector:'#froala-editor'});</script>

    <script>
        $(document).ready(function(){
        $("#get_sablona").click(function(){

        var d = document.getElementById("sablona").value;
        var url = 'https://147.175.121.210:4161/zadania/final/WebTech2/Uloha03/sablonky.php';
        url = url + '/getsablona/' + d;
        //alert(url);

            $.ajax({
                type: 'GET',
                url: url,
                success: function(msg){
                    tinyMCE.activeEditor.setContent('');
                    tinymce.activeEditor.execCommand('mceInsertContent', false, msg);
                    $("#plaintext_area").html(msg);
                          }});
        });
        });
    </script>



</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="../index.php?lang=<?php echo $language['websiteLang']?>"> <img height="60"  alt="logo" src="../Login/img/logo.png"> </a>
        <ul class="navbar-nav mr-auto">
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="../Uloha01/php/admin_main.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['profile']?></a>
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="../Uloha01/php/admin_results.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['results']?></a>
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="../Uloha02/php/admin.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['point']?></a>
            </li>
            <li class="navbar-nav mr-auto active">
                <a class="nav-link" href="indexlu.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['mail']?></a>
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="mailinfo.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['mailinfo']?></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="indexlu.php?lang=sk"> <img src="../Login/img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="indexlu.php?lang=en"> <img src="../Login/img/uk.png" height="30" alt="uk"></a></div>
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
            <li class="navbar-item">
                <a class="nav-link" id="logout" href="../Login/php/logout.php?lang=<?php echo $language['websiteLang'];?>"><?php echo $language['logout']?></a>
            </li>
        </ul>
    </nav>

</header>

<!--------------------------------------------------------------------
-----------------------Prve nacitavanie udajov------------------------>
<div class="container">
    <br />
    <h3 align="center"><?php echo $language['generated']?></h3>
    <br />
    <form id="upload_csv1" method="post" enctype="multipart/form-data" action="">
        <div class="col-md-4">
            <input type="file" name="csv_file1" id="csv_file1" accept=".csv" style="margin-top:15px;" />
        </div>
        <div class="col-md-5">
            <br><?php echo $language['separator']?><input type="text" name="ciarka1" id="ciarka"  pattern=",|;" required>
        </div>
        <div class="col-md-5">
            <input type="submit" name="upload1" id="upload" value="<?php echo $language['upload']?>" style="margin-top:10px;" class="btn btn-info" />
        </div>

        <div style="clear:both"></div>
        <br>
        <a href="upraveny_subor.csv" ><?php echo $language['download']?></a>
    </form>
    <br />
    <br />

    <?php
    if(!empty($_FILES['csv_file1'])) {
        $path = "uploads/";
        $path = $path . basename($_FILES['csv_file1']['name']);
        if (move_uploaded_file($_FILES['csv_file1']['tmp_name'], $path)) {
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
    <h3 align="center"><?php echo $language['nongenerated']?></h3>
    <br />
    <form id="upload_csv2" method="post" enctype="multipart/form-data">
        <div class="col-md-4">
            <input type="file" name="csv_file2" id="csv_file2" accept=".csv" style="margin-top:15px;" />
        </div>
        <div class="col-md-5">
            <br><?php echo $language['separator']?><input type="text" name="ciarka2" id="ciarka"  pattern=",|;" required>
        </div>
        <div class="col-md-5">
            <input type="submit" name="upload" id="upload" value="<?php echo $language['upload']?>" style="margin-top:10px;" class="btn btn-info" />
        </div>
        <div style="clear:both"></div>
    </form>
    <br />
    <br />

    <?php
    require 'phpmailer/PHPMailerAutoload.php';
    function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    if(!empty($_FILES['csv_file2'])) {
        $path = "uploads/";
        $path = $path . basename($_FILES['csv_file2']['name']);
        if (move_uploaded_file($_FILES['csv_file2']['tmp_name'], $path)) {

        } else {
            echo "There was an error uploading the file, please try again!";
        }
        if (!empty($_FILES['csv_file2']['name'])) {
            $premenna = $_POST["ciarka2"];
            if (($handle = fopen($path, 'r')) !== FALSE) { // Check the resource is valid

                $poc = 1;
                $pole_email=array();
                $pole_mena=array();
                $prve_udaje=array();
                $obsah_spravy=array();
                echo "    <div class=\"table-responsive\">
                               <table class=\"table table-striped table-bordered\" id=\"customer-data\">
                                 <thead>
                                  <tr>";
                $o=-1;
                while (($data = fgetcsv($handle, 1000, "$premenna")) !== FALSE) {
                    $i = 0;

                    if($jedenkrat == 0){
                        while ($i < count($data)) {
                            echo "<th>" . utf8_encode($data[$i]) . "</th>";
                            array_push($prve_udaje, utf8_encode($data[$i]));
                            $i++;
                        }
                        echo"</tr>
                                    </thead>";
                    }
                    else{
                        echo"<tr>";
                    }
                    $o++;
                    while ($i < count($data)) {
                        if(strpos( utf8_encode($data[$i]) ," ") != FALSE){
                            array_push($pole_mena, utf8_encode($data[$i]));

                        }
                        if(strpos( utf8_encode($data[$i]) ,"@") != FALSE){
                            array_push($pole_email, utf8_encode($data[$i]));

                        }
                        $obsah_spravy[$o][$i]= utf8_encode($data[$i]);
                        echo "<td>" . utf8_encode($data[$i]) . "</td>";$i++;

                    }
                    if($jedenkrat == 0){
                        $jedenkrat = 1;
                    }
                    else{
                        echo"</tr>";
                    }
                }
                fclose($handle);
                $_SESSION['mena']=$pole_mena;
                $_SESSION['email']=$pole_email;
                $_SESSION['prve_udaje']=$prve_udaje;
                $_SESSION['obsah_spravy']=$obsah_spravy;

            }
            /*-----------------------------------Posielanie mailov------------------------------------
            ------------------------------------------------------------------------------------------*/

        }
    }
    $jedenkrat = 0;
    ?>
    </table>
    <div class="container-fluid">
    <h2><?php echo $language['send']?></h2>

    <label><?php echo $language['template']?>
        <select id="sablona" name="combo_sablona" class="form-control" onchange="changesabl()">
            <option value="1" class="form-control" selected="selected">1</option>
            <option value="2" class="form-control">2</option>
        </select>
        <button id="get_sablona" class="btn btn-info"><?php echo $language['use_temp']?></button>
    </label>

    <form action="" method="post" accept-charset="UTF-8" class="form-group">
        <input type="text" name="sablid" id="sablid" class="form-control" style="display: none">
        <?php echo $language['sender']?> <input type="email" name="email" placeholder="Email" class="col-5" required><br>
        <?php echo $language['pw_mail']?><input type="password" name="heslo" class="col-5" placeholder="<?php echo $language['pw']?>" required><br>
        <?php echo $language['name']?><input type="text" name="meno" class="col-5" placeholder="<?php echo $language['name2']?>" required><br>
        <?php echo $language['subject']?>
        <input type="text" name="predmet" class="col-5" placeholder="<?php echo $language['subject2']?>" required>
        <br>
        <?php echo $language['message']?><br>
        <input type="radio" name="rad1" id="yescheck1" onchange="changeradio()" value="1" checked> Plain text
        <input type="radio" name="rad1" id="yescheck2" onchange="changeradio()" value="2"> Html text

        <div id="plaintext"><textarea id="plaintext_area" name="plaintext_name" class="form-control" style="width: 50%; height: 300px"></textarea></div>
        <div id="htmltext"><textarea id="froala-editor" name="noise"></textarea></div>

        <input type="submit" value="<?php echo $language['submit']?>" required>
    </form>
</div>
</div>
<!-----------------------------------------------------------------------------
---------------------------Odosielanie mailu-------------------------------->

<?php



if(isset($_POST["predmet"]))
{
    $message = "";
    $zaver = "";
    $answer;
    $subject=$_POST["predmet"];
    if(isset($_POST['rad1']))
    {
        $answer=$_POST['rad1'];
        if($answer=="1")
        {
            $message=$_POST['plaintext_name'];
            $zaver =" S pozdravom, ".$_POST["meno"];

        }
        else{

            $message=$_POST['noise'];
            $message = html_entity_decode($message);

           // $message = slugify($message);
            $zaver ="<br/><p> S pozdravom, ".$_POST["meno"]."</p>";
        }

    }


    $date= date("Y-m-d");
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "mail.stuba.sk";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = $_POST["email"];
    $mail->Password = $_POST["heslo"];
    $mail->setFrom($_POST["email"], $_POST["meno"]);


    $mail->Subject = $subject;


    ///////////nacitanie udajov do spravy////////////////////
    /// /////////////////////////////////////////////
    $pocet_stlpcov=count($_SESSION['prve_udaje']);
    $pocet_riadkov=count($_SESSION['email']);

    for($i=1;$i<=$pocet_riadkov;$i++)
    {
        $str=$message;
        for($j=3;$j<$pocet_stlpcov;$j++)
        {
            if($answer == "1"){
                $str.="\r\n";
                $str.=$_SESSION['prve_udaje'][$j];
                $str.=": ";
                $str.=$_SESSION['obsah_spravy'][$i][$j];
                $str.="\r\n";
            }
            else{
                $str.="<br/><p>";
                $str.=$_SESSION['prve_udaje'][$j];
                $str.=": ";
                $str.=$_SESSION['obsah_spravy'][$i][$j];
                $str.='</p><br/>';
            }
        }
        $str.=$zaver;
        $mail->Body = $str;
        $mail->AddAddress($_SESSION['email'][$i-1]);
        if ($mail->send()) {
            //echo "Mail sent";
            $servername = "localhost";
           // $username = "xorths";
           // $password = "qjj6unGaBIaw";

            $username = "xmacakn";
            $password = "Heslo12345";

            $db = "webtech2";
            $conn = new mysqli($servername, $username, $password, $db);
            $conn->set_charset(utf8);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                // echo"Pripojeny";
            }

            $selectOption=$_POST['sablid'];
            for($k=0;$k<count($_SESSION['mena']);$k++) {
                $meno = $_SESSION['mena'][$k];
                $sql = "INSERT INTO odoslane_spravy (datum, meno_studenta, predmet, id_sablony) VALUES ('$date', '$meno','$subject', '$selectOption')";
                if ($conn->query($sql) === TRUE) {
                   //  echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }      // echo "Viacnasobne ukladanie e-mailovych adries";
            }

        } else {
           // echo "Nieco nefunguje";
        }

        $mail->clearAddresses();

    }


}

?>
<?php

?>
</body>
</html>

<script>

    var plainradio = document.getElementById('yescheck1');
    var htmlradio = document.getElementById('yescheck2');
    var htmleditor = document.getElementById('htmltext');
    var plaineditor = document.getElementById('plaintext');
    htmleditor.style.display = "none";


    function changesabl(){
        var sablvec = document.getElementById('sablid');
        var sablreal = document.getElementById('sablona');
        sablid.value = sablona.value;
    }
    function changeradio() {

        if(plainradio.checked){
            htmleditor.style.display = "none";
            plaineditor.style.display = "block";

        }
        else if(htmlradio.checked){
            htmleditor.style.display = "block";
            plaineditor.style.display = "none";
        }
    }


</script>

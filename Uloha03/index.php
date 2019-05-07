<?php
//index.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Webtech Projekt</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
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
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="customer-data">
            <thead>
            <tr>
                <th>ID</th>
                <th>Meno</th>
                <th>Email</th>
                <th>Prihlasovacie meno</th>
                <th>Heslo</th>
            </tr>
            </thead>
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
                $list=array();
               if (($handle = fopen($path, 'r')) !== FALSE) { // Check the resource is valid
                   while (($data = fgetcsv($handle, 1000, "$premenna")) !== FALSE) {
                       $i = 0;
                       while ($i < count($data)) {
                           echo "<tr>";

                           echo "<td>" . $data[$i] . "</td>";
                           array_push($list,$data[$i]);
                           $i++;

                           echo "<td>" . $data[$i] . "</td>";
                           array_push($list,$data[$i]);
                           $i++;

                           echo "<td>" . $data[$i] . "</td>";
                           array_push($list,$data[$i]);
                           $i++;

                           echo "<td>" . $data[$i] . "</td>";
                           array_push($list,$data[$i]);
                           $i++;
                           $heslo=generateRandomString(15);
                           array_push($list,$heslo);

                           echo "<td>" . $heslo . "</td>";
                           echo "</tr>";

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
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Meno</th>
                <th>Email</th>
                <th>Prihlasovacie meno</th>
                <th>Heslo</th>
                <th>verejná IP</th>
                <th>privátna IP</th>
                <th>ssh</th>
                <th>http</th>
                <th>https</th>
                <th>misc1</th>
                <th>misc2</th>
            </tr>
            </thead>
            <?php

            function generateRandomString($length = 10)
            {
                return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
            }

            function verejnaip()
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
            }
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
                        while (($data = fgetcsv($handle, 1000, "$premenna")) !== FALSE) {
                            $i = 0;

                            while ($i < count($data)) {

                                echo "<tr>";
                                echo "<td>" . $data[$i] . "</td>";$i++;
                                echo "<td>" . $data[$i] . "</td>";$i++;
                                echo "<td>" . $data[$i] . "</td>";$i++;
                                echo "<td>" . $data[$i] . "</td>";$i++;
                                echo "<td>" . generateRandomString(15) . "</td>";
                                echo "<td>" . verejnaip() . "</td>";
                                echo "<td>" . privatnaip($poc) . "</td>";$poc++;
                                echo "<td>" . ssh() . "</td>";
                                echo "<td>" . http() . "</td>";
                                echo "<td>" . https() . "</td>";
                                echo "<td>" . misc1() . "</td>";
                                echo "<td>" . misc2() . "</td>";
                            }

                        }
                        fclose($handle);
                    }
                }
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>

<?php
session_start();

//if(!isset($_SESSION['admin'])){header('Location: ../index.php?lang='.$language['websiteLang']); exit();}

if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('lang/eng.php');
}else{$language = include('lang/svk.php');}

?>
<!DOCTYPE HTML>
<html lang="<?php echo $language['websiteLang']?>">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Mail info</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <title>
        Mail Info
    </title>

</head>
<body style=" background: #FAFAFA;">
<header>
 <!--   <h1 id="tit_mail">
        Mail Info
    </h1>
    <nav>
        <ul class="menu">
            <li class="menu"><a href="index.php">Upload csv</a></li>
            <li class="menu"><a href="mailinfo.php">Mail info</a></li>
        </ul>
    </nav> -->

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
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="indexlu.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['mail']?></a>
            </li>
            <li class="navbar-nav mr-auto active">
                <a class="nav-link" href="mailinfo.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['mailinfo']?></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"> <a class="nav-link" id="svk" href="mailinfo.php?lang=sk"> <img src="../Login/img/sk.png" height="30" alt="sk"></a></div>
                <div id="enDiv" ><a class="nav-link" id="eng" href="mailinfo.php?lang=en"> <img src="../Login/img/uk.png" height="30" alt="uk"></a></div>
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

<div class='container'>
    <table class='table' id="email_table">
        <thead class="thead-light">
        <tr>
            <th scope='col'><?php echo $language['date']?></th>
            <th scope='col'><?php echo $language['recipient']?></th>
            <th scope='col'><?php echo $language['subject2']?></th>
            <th scope='col'><?php echo $language['temp_id']?></th>
        </tr>
        </thead>
        <tbody>
<?php

$servername="localhost";
//$username="xorths";
//$password="qjj6unGaBIaw";

$username = "xmacakn";
$password = "Heslo12345";

$db="webtech2";
$conn = new mysqli($servername, $username, $password, $db);
mysqli_set_charset($conn, "utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    // echo"Pripojeny";
}

$sql = "SELECT datum, meno_studenta, predmet, id_sablony FROM odoslane_spravy";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo " <tr><td>" . $row["datum"] . "</td><td>" . $row["meno_studenta"] . "</td><td>" . $row["predmet"] . "</td><td>" . $row["id_sablony"] . "</td></tr>";
    }

    echo"</tbody>
    </table>
    </div>";
}
?>

<script>
    $(document).ready( function () {
        $('#email_table').DataTable();
    } );

    $('#email_table').DataTable( {
    } );


</script>

</body>
</html>

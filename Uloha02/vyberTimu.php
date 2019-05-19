<?php

if (isset($_GET['lang']) && $_GET['lang'] == 'sk') {
    $language = include('lang/sk.php');
} else if (isset($_GET['lang']) && $_GET['lang'] == 'en') {
    $language = include('lang/eng.php');
} else {
    $language = include('lang/sk.php');
}


?>
<!doctype html>
<html lang="<?php echo $language['websiteLang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--jQuery Datatables CSS-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title><?php echo $language['VyberTitle'] ?></title>
</head>
<body>
<?php
include "congif.php";
session_start();

//kontrola prihlasenia
if(!isset($_SESSION['loggedIn'])){header('Location: ../index.php?lang='.$language['websiteLang']);  exit();}

//TODO zrušiť mazanie SESSION, toto bolo použité len na testovanie!!!!!
$_SESSION = array();
?>
<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="kapitanNahlad.php"> <img height="60" alt="logo" src="img/logo.png"> </a>



        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"><a class="nav-link" id="svk" href="vyberTimu.php?lang=sk"> <img src="img/sk.png"
                                                                                                height="30"
                                                                                                alt="sk"></a></div>
                <div id="enDiv"><a class="nav-link" id="eng" href="vyberTimu.php?lang=en"> <img src="img/uk.png"
                                                                                                height="30"
                                                                                                alt="uk"></a></div>
            </li>

            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="admin_main.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['profile']?></a>
            </li>
            <li class="navbar-nav mr-auto  active">
                <a class="nav-link" href="admin_results.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['results']?></a>
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="../../Uloha02/php/admin.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['point']?></a>
            </li>

            <li class="navbar-item">
                <a class="nav-link" id="logout" href="logout.php"><?php echo $language['Logout'] ?></a>
            </li>
            <?php

            if (isset($_GET['lang']) && $_GET['lang'] == 'sk') {

                echo '<script>document.getElementById("skDiv").style.display = "none";</script>';
                echo '<script>document.getElementById("enDiv").style.display = "";</script>';
            } else if (isset($_GET['lang']) && $_GET['lang'] == 'en') {

                echo '<script>document.getElementById("skDiv").style.display = "";</script>';
                echo '<script>document.getElementById("enDiv").style.display = "none";</script>';
            } else {

                echo '<script>document.getElementById("skDiv").style.display = "none";</script>';
                echo '<script>document.getElementById("enDiv").style.display = "";</script>';
            }
            ?>
        </ul>
    </nav>
</header>
<div class="container">
    <div class="cont">
        <form action="redirect.php" method="post">
            <div class="row text-center">
                <div class="col-md-6 offset-md-3">
                    <select class="form-control" required name="tim">
                        <option value="" selected disabled><?php echo $language['Select'] ?></option>
                        <?php
                        //TODO treba ešte doplniť IDziaka podľa prihláseného uživateľa
                       // $_SESSION['uziv'] = 86223;
                        $sql = "SELECT IDtimu FROM clenovaTimov WHERE IDziaka = " . $_SESSION['uziv'] . ";";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $sql2 = "SELECT nazov FROM predmety where ID = (SELECT IDpredmetu from timy where ID = " . $row['IDtimu'] . ")";
                                $stmt2 = $conn->prepare($sql2);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                                if ($result2->num_rows > 0 && $row2 = $result2->fetch_assoc()) {
                                    print ("<option value='" . $row['IDtimu'] . "'>" . $row2['nazov'] . "</option>");
                                }
                            }
                        }
                        ?>
                    </select>
                    <input class='btn btn-success' type='submit' value='<?php echo $language['Submit'] ?>'>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
    <script type="text/javascript">
        var auto_refresh = setInterval(
            function () {
                $('.container').load('vyberTimu.php?lang=<?php echo $_GET['lang']?> .cont');
            }, 10000); // refresh every 10000 milliseconds
    </script>
</div>
</body>
</html>

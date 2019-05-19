<?php
session_start();
include "congif.php";
if (isset($_SESSION['tim'])) {
    $tim = $_SESSION['tim'];
    //TODO doriešiť vyhľadávanie pomocou ID prihláseného uživateľa ak to je riesene inak ako cez session
} else header("Location: vyberTimu.php");

if (isset($_GET['lang']) && $_GET['lang'] == 'sk') {
    $language = include('lang/sk.php');
} else if (isset($_GET['lang']) && $_GET['lang'] == 'en') {
    $language = include('lang/eng.php');
} else {
    $language = include('lang/sk.php');
}

if (isset($_POST['suhlas'])) {
    if($_POST['suhlas']=="súhlasi" || $_POST['suhlas']=="agree") {
        $sql = "UPDATE clenovaTimov SET suhlas = 1 where IDtimu = " . $_SESSION['tim'] . " AND IDziaka = " . $_SESSION['uziv'] . ";";
    }
    if($_POST['suhlas']=="nesúhlasí" || $_POST['suhlas']=="disagree") {
        $sql = "UPDATE clenovaTimov SET suhlas = 0 where IDtimu = " . $_SESSION['tim'] . " AND IDziaka = " . $_SESSION['uziv'] . ";";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $sql = "SELECT distinct (suhlas) from clenovaTimov where  IDtimu = " . $_SESSION['tim'] . ";";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $celkovy_suhlas = false;
    $row = $result->fetch_assoc();
    if ($result->num_rows == 1 && $row['suhlas'] == 1) {
        $sql = "update timy set schvaleneKapitanom = 1 where ID = " . $_SESSION['tim'] . ";";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
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
    <title>Tim</title>
</head>
<body style="background: #FAFAFA">
<?php
$tim = $_SESSION['tim'];
$sql = "SELECT nazov FROM predmety where ID = (SELECT IDpredmetu from timy where ID = " . $tim . ");";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
    $nazov_predmetu = $row['nazov'];
}
$sql = "SELECT body FROM timy where ID = " . $tim . ";";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
    $body_tim = $row['body'];
}
$zvysne_body = $body_tim;
$sql = "SELECT IDziaka,jeKapitan,body FROM clenovaTimov WHERE IDtimu =" . $tim . ";";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $zvysne_body = $zvysne_body - $row['body'];
    }
}
?>
<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="../index.php"> <img height="60" alt="logo" src="img/logo.png"> </a>

        <ul class="navbar-nav mr-auto">
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="../Uloha01/php/user_main.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['profile']?></a>
            </li>
            <li class="navbar-nav mr-auto">
                <a class="nav-link" href="../Uloha01/php/user_results.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['results']?></a>
            </li>
            <li class="navbar-nav mr-auto active">
                <a class="nav-link" href="vyberTimu.php?lang=<?php echo $language['websiteLang']?>"><?php echo $language['VyberTitle']?></a>
            </li>
        </ul>


        <ul class="navbar-nav ml-auto">

            <li class="navbar-item">
                <div id="skDiv"><a class="nav-link" id="svk" href="student.php?lang=sk"> <img src="img/sk.png"
                                                                                              height="30"
                                                                                              alt="sk"></a></div>
                <div id="enDiv"><a class="nav-link" id="eng" href="student.php?lang=en"> <img src="img/uk.png"
                                                                                              height="30"
                                                                                              alt="uk"></a></div>
            </li>
            <?php
            if ($_SESSION['kapitan'] == 1) {
                print ('<li class="navbar-item"><a class="nav-link" id="kapitan" href="kapitanNahlad.php?lang='.$language['websiteLang'].'">' . $language['Kapitan'] .'</a></li>');
            }
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
            <!--TODO pri logout vymazat vsetky info zo session!!!!-->
            <li class="navbar-item">
                <a class="nav-link" id="logout" href="../Login/php/logout.php?lang=<?php echo $language['websiteLang'] ?>"><?php echo $language['Logout'] ?></a>
            </li>
        </ul>
    </nav>
</header>
<div class="container">
    <div class="cont">
        <h2 class="text-center"><?php echo $nazov_predmetu; ?> </h2>
        <h4 class="text-center"><?php echo $language['PridBody'] ?>: <?php echo $body_tim ?></h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?php echo $language['Meno'] ?></th>
                <th><?php echo $language['Body'] ?></th>
                <th><?php echo $language['StavSuhlasu'] ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT IDziaka,jeKapitan,body,suhlas FROM clenovaTimov WHERE IDtimu =" . $tim . ";";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $sql = "SELECT meno FROM studenti where ID = " . $row['IDziaka'] . ";";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result2 = $stmt->get_result();
                    if (is_null($row['suhlas'])) $stav_suhlasu = $language['Nevyjadril'];
                    elseif ($row['suhlas'] == 0) $stav_suhlasu = $language['Nesuhlasi'];
                    elseif ($row['suhlas'] == 1) $stav_suhlasu = $language['Suhlasi'];
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            echo '<input type="hidden" id="clenId" name="clenId" value="' . $row["IDziaka"] . '"><input type="hidden" id="tim" name="tim" value="' . $tim . '"';
                            if ($row['jeKapitan'] == 1) print("<tr id='" . $row['IDziaka'] . "'><td>" . $row2['meno'] . " (C)</td><td>" . $row['body'] . "</td><td>" . $stav_suhlasu . "</td></tr>");
                            else print("<tr id='" . $row['IDziaka'] . "'><td>" . $row2['meno'] . "</td><td>" . $row['body'] . "</td><td>" . $stav_suhlasu . "</td></tr>");
                        }
                    }
                }
            }
            ?>
            </tbody>
        </table>
        <?php
        $sql = "SELECT suhlas from clenovaTimov where IDtimu = " . $tim . " and IDziaka = " . $_SESSION['uziv'] . ";";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (is_null($row['suhlas'])) {
            print('<form onsubmit="return  confirm(\'Chcete odsúhlasiť rozdelenie bodov? Táto akcia sa nedá vrátiť.\')" action="student.php?lang=<?php echo $_GET[\'lang\']?>" id="frm" method="post">
            <input type="submit"  class="btn btn-success" name="suhlas" value="' . $language['Suhlasi'] . '">
            <input type="submit"  class="btn btn-danger" name="suhlas" value="' . $language['Nesuhlasi'] . '">
            </form>');
        } else print ("<h4 class='text-center'>" . $language['Odsuhlasene'] . "</h4>");
        ?>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
    var auto_refresh = setInterval(
        function () {
            $('.container').load('student.php?lang=<?php echo $_GET['lang']?> .cont');
        }, 10000); // refresh every 10000 milliseconds
</script>
</body>
</html>
<?php
include "congif.php";
session_start();
if (isset($_SESSION['tim'])){
    $tim = $_SESSION['tim'];
//    unset($_POST['tim']);
    //TODO doriešiť vyhľadávanie pomocou ID prihláseného uživateľa
} else header("Location: vyberTimu.php");
if (isset($_POST['body']) && isset($_POST['clenId'])){
    $body = $_POST['body'];
    unset($_POST['body']);
    $clenID =  $_POST['clenId'];
    unset($_POST['clenId']);
    $sql = "UPDATE clenovaTimov SET body = ".$body." where IDtimu = ".$tim." AND IDziaka = ".$clenID.";";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}
?>
<!doctype html>
<html lang="sk">
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
    <title>Tím</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark color-black">
        <a class="navbar-brand" href="HelloWorld.php"> <img height="60" alt="logo" src="img/logo.png"> </a>

        <ul class="navbar-nav ml-auto">
            <li class="navbar-item">
                <div id="skDiv"><a class="nav-link" id="svk" href=""> <img src="img/sk.png" height="30"
                                                                                            alt="sk"></a></div>
                <div id="enDiv"><a class="nav-link" id="eng" href=""> <img src="img/uk.png" height="30"
                                                                                            alt="uk"></a></div>
            </li>
            <li class="navbar-item">
                <a class="nav-link" id="team" href="vyberTimu.php">Výber Tímu</a>
            </li>
            <li class="navbar-item">
                <a class="nav-link" id="team" href="student.php">Prehľad bodov</a>
            </li>
            <li class="navbar-item">
                <a class="nav-link" id="logout" href="logout.php">Logout</a>
            </li>
            <?php
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
        </ul>
    </nav>
</header>
<div class="container" style="margin-top: 20px;">
    <?php
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
        $sql = "SELECT IDziaka,jeKapitan,body FROM clenovaTimov WHERE IDtimu =".$tim.";";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $zvysne_body = $zvysne_body - $row['body'];
            }
        }
    ?>
    <h2 class="text-center"><?php echo $nazov_predmetu;?> </h2>
    <h4 class="text-center">Pridelené body: <?php echo $body_tim?></h4>
    <h4 class="text-center">Zvyšné body: <span id="zvysne_body"><?php echo $zvysne_body?></span></h4>
    <table class="table table-striped">
        <thead class="text-center">
        <tr>
            <th>Meno</th>
            <th>Body</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT IDziaka,jeKapitan,body FROM clenovaTimov WHERE IDtimu =".$tim.";";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sql = "SELECT meno FROM studenti where ID = " . $row['IDziaka'] . ";";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result2 = $stmt->get_result();
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        echo '<form onchange="checkZvysok()" action="HelloWorld.php" method="post"><input type="hidden" id="clenId" name="clenId" value="' . $row["IDziaka"] . '"><input type="hidden" id="tim" name="tim" value="' . $tim . '"';
                        if ($row['jeKapitan'] == 1) print("<tr id='" . $row['IDziaka'] . "'><td>" . $row2['meno'] . " (C)</td><td><input class='form-control col-md-6 offset-md-3' id='" . $row['IDziaka'] . "' name='body' type='number' min='0' max='" . $body_tim . "' value='" . $row['body'] . "' onblur='checkBody(this.id)'></td><td><input type='submit' class='btn btn-success conf' value='Potvrdiť'></td></tr>");
                        else print("<tr id='" . $row['IDziaka'] . "'><td>" . $row2['meno'] . "</td><td><input class='form-control col-md-6 offset-md-3' id='" . $row['IDziaka'] . "' name='body' type='number' min='0' max='" . $body_tim . "' value='" . $row['body'] . "' onblur='checkBody(this.id)'></td><td><input type='submit' class='btn btn-success conf' value='Potvrdiť'></td></tr>");
                        echo '</form>';
                    }
                }
            }
        }
        ?>
        </tbody>
    </table>
    <script>
        function checkBody(id) {
            let celkoveBody = document.getElementById("zvysne_body").innerHTML;
            let clenoveBody = document.getElementById(id).value;
            if(celkoveBody-clenoveBody <0) {
                document.getElementById(id).value = celkoveBody;
                alert("zle body");
            }
        }
    </script>
</div>
</body>
</html>
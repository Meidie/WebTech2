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
    <title>Vyber timu</title>
</head>
<body>
<?php
include "congif.php";
session_start();
//TODO zrušiť mazanie SESSION, toto bolo použité len na testovanie
$_SESSION = array();
?>
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
<div class="container">
    <form action="redirect.php" method="post">
        <div class="row text-center">
            <div class="col-md-6 offset-md-3">
                <select class="form-control" required name="tim">
                    <option value="" selected disabled>Vyberte možnosť</option>
                    <?php
                    //TODO treba ešte doplniť IDziaka podľa prihláseného uživateľa
                    $_SESSION['uziv'] = 86247;
                    $sql = "SELECT ID FROM timy WHERE ID = (SELECT IDtimu FROM clenovaTimov WHERE IDziaka = ".$_SESSION['uziv'].");";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $sql2 = "SELECT nazov FROM predmety where ID = (SELECT IDpredmetu from timy where ID = " . $row['ID'] . ")";
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();
                            if ($result2->num_rows > 0 && $row2 = $result2->fetch_assoc()) {
                                print ("<option value='" . $row['ID'] . "'>" . $row2['nazov'] . "</option>");
                            }
                        }
                    }
                    ?>
                </select>
                <input class='btn btn-success' type='submit' value='Submit'>
            </div>
        </div>
    </form>
</div>
</body>
</html>

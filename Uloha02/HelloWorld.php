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
    <title>Document</title>
</head>
<body>
<?php
include "congif.php";
$tim = $_POST['tim'];
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
            <li class="navbar-item">
                <a class="nav-link" id="team" href="vyberTimu.php">Výber Tímu</a>
            </li>
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
    ?>
    <h2 class="text-center"><?php echo $nazov_predmetu;?> </h2>
    <h4 class="text-center">Pridelené body: <?php echo $body_tim?></h4>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Meno</th>
            <th>Body</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //SELECT meno FROM studenti WHERE ID = (
        $sql = "SELECT IDziaka,jeKapitan FROM clenovaTimov WHERE IDtimu = 2;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sql = "SELECT meno FROM studenti where ID = " . $row[IDziaka] . ";";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result2 = $stmt->get_result();
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        if ($row['jeKapitan']==1) print("<tr id='" . $row2['meno'] . "'><td>" . $row2['meno'] . " (C)</td><td>lul</td></tr>");
                        else print("<tr id='" . $row2['meno'] . "'><td>" . $row2['meno'] . "</td><td>lul</td></tr>");
                    }
                }
            }
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
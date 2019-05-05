<?php
    session_start();


    if(isset($_SESSION['loggedIn'])){

        unset($_SESSION['loggedIn']);
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        unset($_SESSION['lastName']);
        unset($_SESSION['mail1']);
        unset($_SESSION['mail2']);
    }
    session_destroy();

    if(isset($_GET['lang']))
        header('Location: ../../index.php?lang='.$_GET['lang']);
    else
        header('Location: ../../index.php');

    exit();

?>

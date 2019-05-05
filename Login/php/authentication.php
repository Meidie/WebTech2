<?php
    session_start();

   /* // Create connection
    require('config.php');
    $conn = new mysqli($hostname, $username, $password, $dbname);
    $conn->set_charset("utf8");

    // Check connection
    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }
    echo "Connected successfully";*/

    if(isset($_POST['submitLogin']) && isset($_POST['username']) && isset($_POST['password'])){

        $ldapuid =  $_POST['username'];
        $ldappass = $_POST['password'];

        $dn  = 'ou=People, DC=stuba, DC=sk';
        $ldaprdn  = "uid=$ldapuid, $dn";

        $ldapconn = ldap_connect("ldap.stuba.sk")
        or die("Could not connect to LDAP server.");

        $set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

        if($ldapconn){

            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

            if($ldapbind){
                echo "LDAP bind successful...";
                $_SESSION['loggedIn'] = "access";

                $sr = ldap_search($ldapconn, $ldaprdn, "uid=".$ldapuid);
                $entry = ldap_first_entry($ldapconn, $sr);

               /* $usrId = ldap_get_values($ldapconn, $entry, "uisid")[0]; //id
                $usrName = ldap_get_values($ldapconn, $entry, "givenname")[0]; //meno
                $usrSurname = ldap_get_values($ldapconn, $entry, "sn")[0]; //priezvisko
                $usrMail = ldap_get_values($ldapconn, $entry, "mail")[2]; //mail
                $usrMail2 = ldap_get_values($ldapconn, $entry, "mail")[3]; //mail
                $usrC = ldap_get_values($ldapconn, $entry, "cn")[0]; // cele meno*/

                $_SESSION['id'] = ldap_get_values($ldapconn, $entry, "uisid")[0];
                $_SESSION['name'] = ldap_get_values($ldapconn, $entry, "givenname")[0];
                $_SESSION['lastName'] = ldap_get_values($ldapconn, $entry, "sn")[0];
                $_SESSION['mail1'] = ldap_get_values($ldapconn, $entry, "mail")[3];
                $_SESSION['mail2'] = ldap_get_values($ldapconn, $entry, "mail")[2];

                header('Location: ../../Uloha01/php/user_main.php?lang='.$_GET['lang']);
            }else{
                echo "LDAP bind failed...";
                $_SESSION['login_failed'] = "failed";

                if(isset($_GET['lang']))
                    header('Location: ../../index.php?lang='.$_GET['lang']);
            }
        }
    }

?>
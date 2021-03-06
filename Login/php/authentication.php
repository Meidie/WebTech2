<?php
    session_start();

    //prihlasenie
    if(isset($_POST['submitLogin']) && isset($_POST['username']) && isset($_POST['password'])){

        //ak bolo username admin skotrolujem ci sa heslo zhoduje s tym v databaze a ak ano prihlasim uzivatela ako admina
        if($_POST['username'] == 'admin'){

            // vytvorenie spojena
            require('config.php');
            $conn = new mysqli($hostname, $username, $password, $dbname);
            $conn->set_charset("utf8");

            //kontrola spojena
            if ($conn->connect_error) {

                die("Connection failed: " . $conn->connect_error);

            }else{//vyhladam heslo v databaze a porovnam hash
                $name = $_POST['username'];
                $sql = "SELECT password FROM Administrators WHERE name='$name'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    $row = $result->fetch_assoc();
                    $hashPassword = hash("sha512", $_POST['password']);

                    //ak sa hash rovna vytvorim session admin a presmerujem uzivatela na hlavnu stranku
                    if($row['password'] == $hashPassword){
                        $conn->close();
                        $_SESSION['admin'] = "true";
                        header('Location: ../../Uloha01/php/admin_main.php?lang='.$_GET['lang']);
                        exit();
                    }else {//ak sa hash nezhoduje presmerujem uzivatela spat na login stranku
                        $_SESSION['login_failed'] = "failed";

                        if (isset($_GET['lang'])) {
                            header('Location: ../../index.php?lang=' . $_GET['lang']);
                            exit();
                        }else{
                            header('Location: ../../index.php');
                            exit();
                        }
                    }
                }

                /*$sql = "INSERT INTO Administrators (id, name, password) VALUES (NULL,'admin','$hashPassword')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                }*/
            }

            $conn->close();

            //ak nebolo username admin kontrolujem prihlasenie cez ldap
        }else {

            $ldapuid = $_POST['username'];
            $ldappass = $_POST['password'];

            $dn = 'ou=People, DC=stuba, DC=sk';
            $ldaprdn = "uid=$ldapuid, $dn";

            $ldapconn = ldap_connect("ldap.stuba.sk")
            or die("Could not connect to LDAP server.");

            $set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

            if ($ldapconn) {

                $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

                if ($ldapbind) {
                    echo "LDAP bind successful...";
                    $_SESSION['loggedIn'] = "access";

                    $sr = ldap_search($ldapconn, $ldaprdn, "uid=" . $ldapuid);
                    $entry = ldap_first_entry($ldapconn, $sr);

                    $_SESSION['id'] = ldap_get_values($ldapconn, $entry, "uisid")[0];
                    $_SESSION['uziv'] = ldap_get_values($ldapconn, $entry, "uisid")[0];
                    $_SESSION['name'] = ldap_get_values($ldapconn, $entry, "givenname")[0];
                    $_SESSION['lastName'] = ldap_get_values($ldapconn, $entry, "sn")[0];
                    $_SESSION['mail1'] = ldap_get_values($ldapconn, $entry, "mail")[3];
                    $_SESSION['mail2'] = ldap_get_values($ldapconn, $entry, "mail")[2];

                    header('Location: ../../Uloha01/php/user_main.php?lang=' . $_GET['lang']);
                    exit();
                }//ak sa nebindne cez zadane heslo skusim heslo vyhldat v databaze
                else {

                     $sr =ldap_search($ldapconn, $ldaprdn, "uid=".$ldapuid);
                     $entry = ldap_first_entry($ldapconn, $sr);

                    $idCode = ldap_get_values($ldapconn,$entry,"uisid")[0];

                     require('config.php');
                     $conn = new mysqli($hostname, $username, $password, $dbname2);
                     $conn->set_charset("utf8");

                     $sql  = "SELECT * FROM `studenti` WHERE `ID` ='$idCode'";
                     $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

                        while($row = $result->fetch_assoc()) {
                            if($row['ID'] == $idCode && $row['heslo'] == $ldappass){

                                $_SESSION['loggedIn'] = "access";
                                $_SESSION['id'] = ldap_get_values($ldapconn, $entry, "uisid")[0];
                                $_SESSION['uziv'] = ldap_get_values($ldapconn, $entry, "uisid")[0];
                                $_SESSION['name'] = ldap_get_values($ldapconn, $entry, "givenname")[0];
                                $_SESSION['lastName'] = ldap_get_values($ldapconn, $entry, "sn")[0];
                                $_SESSION['mail1'] = ldap_get_values($ldapconn, $entry, "mail")[3];
                                $_SESSION['mail2'] = ldap_get_values($ldapconn, $entry, "mail")[2];

                                header('Location: ../../Uloha01/php/user_main.php?lang=' . $_GET['lang']);
                                exit();
                            }
                        }
                    }

                    echo "LDAP bind failed...";
                    $_SESSION['login_failed'] = "failed";

                    if (isset($_GET['lang'])) {
                        header('Location: ../../index.php?lang=' . $_GET['lang']);
                        exit();
                    }else{
                        header('Location: ../../index.php');
                        exit();
                    }
                }
            }
        }
    }

?>
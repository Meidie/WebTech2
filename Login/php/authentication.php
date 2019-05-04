<?php
    session_start();

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
            }else{
                echo "LDAP bind failed...";
                $_SESSION['login_failed'] = "failed";

                if(isset($_GET['lang']))
                    header('Location: ../../index.php?lang='.$_GET['lang']);
            }
        }
    }

?>
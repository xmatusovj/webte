<?php
    session_start();

    if(!isset($_SESSION['lang']) && (!isset($_GET['lang']) || $_GET['lang']=="sk")) {
        $_SESSION['lang']="sk";
    }
    else if(isset($_GET['lang']))$_SESSION['lang']=$_GET['lang'];
    if(!isset($_SESSION['lang'])) {
        include "lang_sk.php";
    }
    else {
        include "lang_".$_SESSION['lang'].".php";
    }

    header('Content-Type: text/html; charset=utf-8');
    include "config.php";

    $mysqli = new mysqli($hostname,$username,$password,$db);
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");

    if(isset($_SESSION['user'])) {
        header("Location: https://147.175.121.210:4493/webte_zadanie/index.php");
    }

    if(isset($_POST['signin'])) {
        if($_POST['loginType']=="admin") { /*-----------------------------------------------ADMIN LOGIN-----*/
            $query = "SELECT id, login, password
                      FROM admins
                      WHERE login='".$_POST['login']."'";

            $result = $mysqli->query($query);

            if(mysqli_num_rows($result)==0) {
                $error = "Chyba: Používateľ s týmto loginom neexistuje";
            }
            elseif(mysqli_num_rows($result)==1) {
                $row = $result->fetch_row();

                if(password_verify($_POST['password'],$row[2])) {
                    $_SESSION["user"]=$row[1];
                    header("Location: https://147.175.121.210:4493/webte_zadanie/index.php");
                }
                else $error = "Chyba: Nesprávne heslo";
            }
            else {
                $error = "Chyba: Neznáma chyba";
            }
        }
        else {                                  /*-----------------------------------------------STUDENT LOGIN-----*/
            $ldap_dn = "uid=".$_POST['login'].", ou=People, DC=stuba, DC=sk";
            $dn = "ou=People, DC=stuba, DC=sk";
            $ldapconn = ldap_connect("ldap.stuba.sk");

            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            if(ldap_bind($ldapconn,$ldap_dn,$_POST['password'])) {
                $search = ldap_search($ldapconn, $dn, "uid=".$_POST['login']);
                $entry = ldap_first_entry($ldapconn, $search);

                $_SESSION["user"]=ldap_get_values($ldapconn, $entry, "uid")[0];
				$_SESSION["useridu2"]=ldap_get_values($ldapconn, $entry, "uisid")[0];					//k prihlaseniu v ulohe 2
                header("Location: https://147.175.121.210:4493/webte_zadanie/index.php");
            }
            else $error = "Chyba: Nesprávne prihlasovacie údaje";
        }


    }
?>

<!DOCTYPE html>

<html lang="sk">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= TEXT_TITLE?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<ul class=horizontal>
    <li><a class=active href="login.php"><?= TEXT_LOGIN?></a></li>
    <a class="lang" href="login.php?lang=sk"><img class=langimg src="img/sk.png" title="SK"></a>
    <a class="lang" href="login.php?lang=en"><img class=langimg src="img/uk.png" title="EN"></a>
</ul>

<section>
    <form action="login.php" method="POST" autocomplete="false" enctype="multipart/form-data">
        <h2><?= TEXT_LOGIN?></h2><br>
        <input type="radio" name="loginType" value="student" checked="checked"><?= TEXT_STUDENT?>
        <input type="radio" name="loginType" value="admin" <?php if(isset($_POST['loginType']) && $_POST['loginType']=="admin") echo 'checked="checked"'; ?>><?= TEXT_ADMIN?><br><br>
        <input type="text" name="login" placeholder="Login" required><br>
        <input type="password" name="password" pattern=".{6,}" placeholder="<?= TEXT_PASSWORD?>" readonly onfocus="this.removeAttribute('readonly');" required><br><br>
        <input type="submit" value="<?= TEXT_BTN_LOGIN?>" name="signin"><br>
        <?php
        if(isset($error) && !empty($error)){
            echo "<span class='errorMsg'>$error</span>";
        }
        ?>
    </form>
</section>

</body>
</html>
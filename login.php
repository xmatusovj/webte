<?php
    session_start();
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
                    $_SESSION["user"]="adminlogin";
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
    <title>WEBTE Zadanie</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<ul class=horizontal>
    <li><a class=active href="login.php">Prihlásenie</a></li>
</ul>

<section>
    <form action="login.php" method="POST" autocomplete="false" enctype="multipart/form-data">
        <h2>Prihlásenie</h2><br>
        <input type="radio" name="loginType" value="student" checked="checked">Študent
        <input type="radio" name="loginType" value="admin" <?php if(isset($_POST['loginType']) && $_POST['loginType']=="admin") echo 'checked="checked"'; ?>>Admin<br><br>
        <input type="text" name="login" placeholder="Login" required><br>
        <input type="password" name="password" pattern=".{6,}" placeholder="Heslo" readonly onfocus="this.removeAttribute('readonly');" required><br><br>
        <input type="submit" value="Prihlásiť sa" name="signin"><br>
        <?php
        if(isset($error) && !empty($error)){
            echo "<span class='errorMsg'>$error</span>";
        }
        ?>
    </form>
</section>

</body>
</html>
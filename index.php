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

    if(isset($_GET["logout"]) && $_GET["logout"]==1) {
        session_unset();
        session_destroy();
        header("Location: https://147.175.121.210:4493/webte_zadanie/login.php");
    }

    if(!isset($_SESSION['user'])) {
        header("Location: https://147.175.121.210:4493/webte_zadanie/login.php");
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
    <li><a class=active href="index.php"><?= TEXT_HOME?></a></li>
    <li><a href="uloha1.php"><?= TEXT_TASK1?></a></li>
    <li><a href="uloha2.php"><?= TEXT_TASK2?></a></li>
    <li><a href="uloha3.php"><?= TEXT_TASK3?></a></li>
    <a class="logout" href="index.php?logout=1"><img src="img/turn-off.png" title="Log out"></a>
    <a class="lang" href="index.php?lang=sk"><img class=langimg src="img/sk.png" title="SK"></a>
    <a class="lang" href="index.php?lang=en"><img class=langimg src="img/uk.png" title="EN"></a>
</ul>

<section>
    <!-- Code here -->
    <h2><?= TEXT_TASKS?></h2><br>
    <table>
        <tr>
            <th><?= TEXT_NAME?></th>
            <th><?= TEXT_TASK?></th>
        </tr>
        <tr>
            <td>Jakub Matušov</td>
            <td><?= TEXT_TASK1 . " + " . TEXT_LOGIN?></td>
        </tr>
        <tr>
            <td>Michal Čirip + Tomáš Daniš</td>
            <td><?= TEXT_TASK2?></td>
        </tr>
        <tr>
            <td>Kristian Kalivoda + Jozef Maloch</td>
            <td><?= TEXT_TASK3?></td>
        </tr>
    </table><br>
    
    <a href=""><?= TEXT_DOCUMENTATION?></a>
</section>

</body>
</html>
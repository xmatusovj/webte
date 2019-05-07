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
    <title><?php echo TEXT_TITLE?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<ul class=horizontal>
    <li><a href="index.php"><?php echo TEXT_HOME?></a></li>
    <li><a class=active href="uloha1.php"><?php echo TEXT_TASK1?></a></li>
    <li><a href="uloha2.php"><?php echo TEXT_TASK2?></a></li>
    <li><a href="uloha3.php"><?php echo TEXT_TASK3?></a></li>
    <a class="logout" href="uloha1.php?logout=1"><img src="img/turn-off.png" title="Log out"></a>
    <a class="lang" href="uloha1.php?lang=sk"><img class=langimg src="img/sk.png" title="SK"></a>
    <a class="lang" href="uloha1.php?lang=en"><img class=langimg src="img/uk.png" title="EN"></a>
</ul>

<section>
    <!-- Code here -->
</section>

</body>
</html>
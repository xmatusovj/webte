<?php
    session_start();

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
    <title>WEBTE Zadanie</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<ul class=horizontal>
    <li><a href="index.php">Úvod</a></li>
    <li><a href="uloha1.php">Úloha 1</a></li>
    <li><a class=active href="uloha2.php">Úloha 2</a></li>
    <li><a href="uloha3.php">Úloha 3</a></li>
    <a class="logout" href="uloha2.php?logout=1"><img src="turn-off.png"></a>
</ul>

<section>
    <!-- Code here -->
</section>

</body>
</html>
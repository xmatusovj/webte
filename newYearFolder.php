<?php
$dir = "predmety/";
$newDir = $dir . substr($_POST['folderName'],0,-5);

if(file_exists($newDir)) {
    echo "<script type='text/javascript'>alert('Priečinok pre daný rok už existuje \\nFolder for given year already exists')</script>";
    header( "refresh:0;url=https://147.175.121.210:4493/webte_zadanie/uloha1.php" );
    exit();
}
else {
    $oldmask = umask(0);
    mkdir($newDir, 0777);
    umask($oldmask);
    echo "<script type='text/javascript'>alert('Priečinok bol vytvorený \\nFolder successfully created')</script>";
    header( "refresh:0;url=https://147.175.121.210:4493/webte_zadanie/uloha1.php" );
}
?>
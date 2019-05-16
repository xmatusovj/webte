<?php
unlink($_POST['chooseCourseDelete']);

echo "<script type='text/javascript'>alert('Súbor odstránený \\nFile deleted')</script>";
header( "refresh:0;url=https://147.175.121.210:4493/webte_zadanie/uloha1.php" );
?>
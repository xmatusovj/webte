<?php
session_start();

header('Content-Description: File Transfer');
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=data.csv');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($_SESSION["fileName"]));

ob_clean();
flush();
readfile($_SESSION["fileName"]);
?>
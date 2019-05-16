<?php

$method = $_SERVER['REQUEST_METHOD'];

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

$folderYear = array_shift($request);

$dir = "predmety/".$folderYear;
$files = array_slice(scandir($dir),2);

$msg = '';

foreach ($files as $currentFile) {
    $msg .= "<option value='predmety/".$folderYear."/".$currentFile."'>".strtoupper(substr($currentFile,0,-4))."</option>";
}

if($msg == '') echo "<option value='' disabled selected>No results</option>";
else echo $msg;
?>
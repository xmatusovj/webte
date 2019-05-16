<?php

$method = $_SERVER['REQUEST_METHOD'];

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

$user = array_shift($request);
$folderYear = array_shift($request);

$dir = "predmety/".$folderYear;
$files = array_slice(scandir($dir),2);

foreach ($files as $currentFile) {
    $openFile = fopen(($dir."/".$currentFile), 'r');
    $columns = fgetcsv($openFile, "",";");

    while ($row = fgetcsv($openFile)) {
        $row[0] = explode( ";", $row[0]);
        if($row[0][0] == $user) {
            echo "<h2>". strtoupper(substr($currentFile,0,-4)) ."</h2>";
            echo "<table><tr>";
            foreach ($columns as $column) {
                echo "<th>$column</th>";
            }
            echo "</tr><tr>";
            foreach ($row[0] as $tableData) {
                echo "<td>$tableData</td>";
            }
            echo "</tr></table><br>";
        }
    }
    fclose($openFile);
}

<?php

$method = $_SERVER['REQUEST_METHOD'];

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

$dir = array_shift($request);
$year = array_shift($request);
$name = array_shift($request);

$openFile = fopen($dir . "/" . $year . "/" . $name,'r');
$columns = fgetcsv($openFile, "",";");

echo "<br><table id='courseTable'><tr>";

foreach ($columns as $column) {
    echo "<th>$column</th>";
}

while ($row = fgetcsv($openFile)) {
    $row[0] = explode( ";", $row[0]);

    echo "</tr><tr>";
    foreach ($row[0] as $tableData) {
        if($tableData == '') echo "<td>-</td>";
        else echo "<td>$tableData</td>";
    }
    echo "</tr>";
}

echo "</table><br>";

fclose($openFile);

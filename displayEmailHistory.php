<?php
    // ===== DEBUG MODE =====
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

include_once('config.php');
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlGetEmailHistory = "SELECT * FROM email";
    $resultGetEmailHistory = $conn->query($sqlGetEmailHistory);
    echo "<table class='sortable'>";
    echo "<tr>";
    echo "<th>" . STUDENT_NAME . "</th>";
    echo "<th>" . EMAIL_SUBJECT . "</th>";
    echo "<th>" . DATE . "</th>";
    echo "<th>" . TEMPLATE_ID . "</th>";
    echo "</tr>";
    if ($resultGetEmailHistory->num_rows > 0) {
        while ($row = $resultGetEmailHistory->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['name'] ."</td>";
            echo "<td>" . $row['subject'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['sablona']. "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
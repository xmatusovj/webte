<?php
    use PHPMailer\PHPMailer\PHPMailer;

include_once('config.php');
    require 'vendor/autoload.php';


    $conn = new mysqli($servername, $username, $password, $db);
    mysqli_set_charset($conn, "utf8");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['mail']) && isset($_GET['name']) && isset($_GET['plain'])) {
        $sqlAddSchema = "INSERT INTO sablona(text, name, plain) VALUES('" . $_GET['mail'] . "', '" . $_GET['name'] ."', '" . rawurldecode($_GET['plain']) . "')";
        // echo "query " . $sqSELECT * FROM `History` WHERE 1lAddToHistory;
        if ($conn->query($sqlAddSchema) === true) {
            echo "Pridanie schemy bolo uspesne.";
        } else {
            echo "Error: " . $sqlAddSchema . "<br>" . $conn->error;
        }
    }

    $sqlGetSchema = "SELECT * FROM sablona";
    $resultGetSchema = $conn->query($sqlGetSchema);
    if ($resultGetSchema->num_rows > 0) {
        echo "<select id='schemaSelect' onchange='selectSchema()'>";
        while ($row = $resultGetSchema->fetch_assoc()) {
            if ($row['id'] === $_GET['selectedSchema']) {
                echo "<option value=" . $row['id'] . " selected='selected'>" . $row['name'] . "</option>";
            } else {
                echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
            }
        }
        echo "</select>";
        echo "<select id='schemaType' onchange='selectSchema()'>";
        if ($_GET['type'] === 'plain') {
            echo "<option value='html'>HTML</option><option value='plain' selected='selected'>plain</option>";
        } else {
            echo "<option value='html' selected='selected'>HTML</option><option value='plain'>plain</option>";
        }
        echo "</select>";
    } else {
        echo "Error: " . $sqlAddSchema . "<br>" . $conn->error;
    }

    if (isset($_GET['selectedSchema'])) {
        $sqlGetSchemaById = "SELECT * FROM sablona WHERE sablona.id='" . $_GET['selectedSchema'] . "'";
        $resultGetSchemaById = $conn->query($sqlGetSchemaById);
        if ($resultGetSchemaById->num_rows > 0) {
            while ($row = $resultGetSchemaById->fetch_assoc()) {
                if (isset($_GET['type']) && $_GET['type'] === 'html') {
                    echo "<div id='editor'> " . $row['text'] . "
                </div>";
                } else {
                    echo "<div><span id='plain' style='white-space: pre-line'>" . $row['plain'] . "
                </span></div>";
                }
            }
        }
    } else {
        echo "<div id='editor'>
            <p>Hello World!</p>
            <p>Some initial <strong>bold</strong> text</p>
            <p><br></p>
           </div>";
    }
<?php
use PHPMailer\PHPMailer\PHPMailer;

include_once('config.php');
require 'vendor/autoload.php';


$conn = new mysqli($servername, $username, $password, $dbname);
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
        if ($_GET['type'] === 'html') {
            echo "<option value='html' selected='selected'>HTML</option><option value='plain'>plain</option>";
        } else {
            echo "<option value='html'>HTML</option><option value='plain' selected='selected'>plain</option>";
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

    if (isset($_GET['send']) && isset($_GET['csv'])) {
        // parse the csv
        // $csv = $_GET['csv'];
        // echo $csv;
        // $headerNum = 0;
        // $data = [];
        // for ($i=0; $i < strlen($_GET['csv']); $i++) {
        //     if ($header === false) {
        //         if ($csv[$i] === ';') {
        //             // echo "AKRANSOOO ";
        //             $headerNum++;
        //         }
        //         if ($csv[$i6 === '\n']) {
        //             $header = true;
        //         }
        //     } else {
        //         if($csv[$i] === ';') {
        //             $data[]
        //         }
        //     }
        // }


        // $mail = new PHPMailer;
        // $mail->isSMTP();
        // $mail->CharSet = 'UTF-8';
        // // $mail->SMTPDebug = 2;
        // $mail->Host = 'mail.stuba.sk';
        // $mail->Port = 587;
        // $mail->SMTPAuth = true;
        // $mail->Username = $_GET['name'];
        // $mail->Password = $_GET['password'];
        // $mail->setFrom($_GET['name']);
        // $mail->addAddress('xmaloch@is.stuba.sk', 'Receiver Name');
        // $mail->Subject = 'PHPMailer SMTP message';
        // // $mail->Body = 'Go fk urself';
        // $mail->msgHTML($_GET['text']);
        // $mail->AltBody = 'This is a plain text message body';
        // $mail->addAttachment('test.txt');
        // if (!$mail->send()) {
        //     echo 'Mailer Error: ' . $mail->ErrorInfo;
        // } else {
        //     echo 'Message sent!';
        // }
    }

            // $mail = new PHPMailer;
        // $mail->isSMTP();
        // // $mail->SMTPDebug = 2;
        // $mail->Host = 'mail.stuba.sk';
        // $mail->Port = 587;
        // $mail->SMTPAuth = true;
        // $mail->Username = 'xmaloch@stuba.sk';
        // $mail->Password = 'Sac.kus.6.hit';
        // $mail->setFrom('xmaloch@is.stuba.sk', 'Jozef Maloch');
        // $mail->addReplyTo('reply-box@hostinger-tutorials.com', 'Your Name');
        // $mail->addAddress('xmaloch@is.stuba.sk', 'Receiver Name');
        // $mail->Subject = 'PHPMailer SMTP message';
        // // $mail->Body = 'Go fk urself';
        // $mail->msgHTML($_GET['mail']);
        // $mail->AltBody = 'This is a plain text message body';
        // $mail->addAttachment('test.txt');
        // if (!$mail->send()) {
        //     echo 'Mailer Error: ' . $mail->ErrorInfo;
        // } else {
        //     echo 'Message sent!';
        // }
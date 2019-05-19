<?php
    // ===== DEBUG MODE =====
    // ob_start();
    // ini_set('display_errors', 1);
    // error_reporting(E_ALL);
    // $debug = ob_get_clean()use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\PHPMailer;

include_once('config.php');
require 'vendor/autoload.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset: UTF-8");
    $results["result"]=array();
    $conn = new mysqli($servername, $username, $password, $db);
    mysqli_set_charset($conn, "utf8");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // $sqlAddSchema = "INSERT INTO sablona(text, name, plain) VALUES('" . $_GET['mail'] . "', '" . $_GET['name'] ."', '" . rawurldecode($_GET['plain']) . "')";
    // // echo "query " . $sqSELECT * FROM `History` WHERE 1lAddToHistory;
    // if ($conn->query($sqlAddSchema) === true) {
    //     echo "Pridanie schemy bolo uspesne.";
    // } else {
    //     echo "Error: " . $sqlAddSchema . "<br>" . $conn->error;
    // }
    $insideEnclosure = 0;
    $text = $_POST["text"];
    $textSize = strlen($_POST["text"]);
    $varName = '';
    $textPart = '';
    $message = array();
    $varNameArray = array();

    ob_start();
    echo $textSize;
    for ($i = 0; $i < $textSize; $i++) {
        if ($text[$i] === '{' && $text[$i + 1] === '{') {
            if ($insideEnclosure === 0) {
                $insideEnclosure = 1;
                $i= $i + 2;
            }
            var_dump($textPart);
            array_push($message, array("text" => $textPart));
            $textPart = '';
        }
        
        if ($text[$i] === '}' && $text[$i + 1] === '}') {
            if ($insideEnclosure === 1) {
                $insideEnclosure = 0;
                $i= $i + 2;
            }
            var_dump($varName);
            array_push($varNameArray, $varName);
            array_push($message, array("var" => $varName));
            $varName = '';
        }
        if ($insideEnclosure === 1) {
            $varName = $varName . $text[$i];
        } else {
            $textPart = $textPart . $text[$i];
        }
    }

    var_dump($varNameArray);
    var_dump($message);
    $result_varNameArray = ob_get_clean();

    
    $fileToRead = $_FILES["file"]["tmp_name"];
    
    
    $rowNumber = 1;
    $indexArray = array();
    $varNameArrayCount = count($varNameArray);
    $delimiter = ';';
    $messageFieldCount = count($message);
    $currentMessage = '';
    $messages = array();
    $csv_debug = '';
    $csv_debug = $csv_debug . "file: " . $fileToRead . "\n";
    
    if (($handle = fopen($fileToRead, "r")) !== false) {
        $csv_debug = $csv_debug . "file handle opened\n";
        $csv_debug = $csv_debug .  "counts: rowData: " . $fieldCount . " varNameArray: " . $varNameArrayCount . "\n";
        
        while (($rowData = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if ($rowNumber == 1) {
                $fieldCount = count($rowData);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                //$row++;
                for ($i=0 ;$i < $fieldCount; $i++) {
                    //echo $rowData[$i] . "\n";
                    
                    //for ($j=0;$j<$varNameArrayCount;$j++) {
                    //echo $varNameArray[$j] . "\n";
                        
                    //if (strcmp($rowData[$i], $varNameArray[$j])==0) {
                    //$csv_debug = $csv_debug . "found varName: " . $varNameArray[$j] . " in field: " . $i . " ( " . $rowData . " )\n";
                    //$indexArray[$varNameArray[$j]] = $i;
                    $indexArray[$rowData[$i]] = $i;
                    //}
                    //}
                }
                
                // output buffer for csv parsing
                ob_start();
                var_dump($indexArray);
                $res = ob_get_clean();
                $result_csvParsing = $result_csvParsing . $res;
            } else {
                //skladanie mailu
                for ($i=0;$i<$messageFieldCount;$i++) {
                    $type = key($message[$i]);
                    $value = $message[$i][$type];
                    if (strcmp($type, "text")==0) {
                        $currentMessage = $currentMessage . $value;
                    } elseif (strcmp($type, "var")==0) {
                        $currentMessage = $currentMessage . $rowData[$indexArray[$value]];
                    }
                }
                ob_start();
                echo "rowdata: ";
                var_dump($rowData);
                echo "\n IndexArray: ";
                var_dump($indexArray);
                echo"\n";
                echo "indexOfEmail: " . $indexArray["Email"] . "\n";
                echo "email: " . $rowData[$indexArray["Email"]] . "\n";
                echo "name: " . $_POST['name'] . "\n";
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->CharSet = 'UTF-8';
                // $mail->SMTPDebug = 2;
                $mail->Host = 'mail.stuba.sk';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->Username = $_POST['email'];
                $mail->Password = $_POST['password'];
                $mail->setFrom($_POST['email'], $_POST['name']);
                $mail->addAddress($rowData[$indexArray['Email']]);
                $mail->Subject = $_POST['emailTitle'];
                if ($_POST["typeSchema"] === "html") {
                    $mail->msgHTML($currentMessage);
                } else {
                    $mail->Body = $currentMessage;
                }
                // $mail->AltBody = 'This is a plain text message body';
                $mail->addAttachment($_FILES["optionalFileToSend"]["tmp_name"], $_FILES["optionalFileToSend"]["name"]);
                if (!$mail->send()) {
                    http_response_code(400);
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    http_response_code(200);
                    echo 'Message sent!';
                    $time = new DateTime();
                    $sqlAddEmail = "INSERT INTO email(date, name, subject, sablona) 
                                    VALUES('" .
                                    $time->format('d.m.Y')
                                     . "', '" .
                                     $rowData[$indexArray['meno']]
                                     . "', '"
                                     . $_POST['emailTitle'] . "', '" . $_POST['selectedSchema'] . "')";
                    // echo "query " . $sqSELECT * FROM `History` WHERE 1lAddToHistory;
                    echo $sqlAddEmail . "\n";
                    if ($conn->query($sqlAddEmail) === true) {
                        echo "Pridanie schemy bolo uspesne.";
                    } else {
                        echo "Error: " . $sqlAddEmail . "<br>" . $conn->error;
                    }
                }
                
                array_push($messages, $currentMessage);
                $currentMessage = '';
                $result_email = ob_get_clean();
            }
            $rowNumber = $rowNumber + 1;
        }
        fclose($handle);
    }
    
    $result_csvParsing = $result_csvParsing . $csv_debug;

    ob_start();
    var_dump($_POST);
    $result_POST = ob_get_clean();

    ob_start();
    var_dump($_FILES);
    $result_FILES = ob_get_clean();

    ob_start();
    var_dump($_SESSION);
    $result_SESSION = ob_get_clean();

    ob_start();
    var_dump($messages);
    $result_messages = ob_get_clean();

    array_push($results["result"], array(
            "debug_POST" => $result_POST,
            "debug_FILES" => $result_FILES,
            "debug_SESSION" => $result_SESSION,
            "debug_varNameArray" => $result_varNameArray,
            "debug_csvParsing" => $result_csvParsing,
            "debug_messages" => $result_messages,
            "debug_email" => $result_email,
            // "debug" => $debug
    ));



    echo json_encode($results);

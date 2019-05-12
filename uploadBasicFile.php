<?php
    session_start();

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset: UTF-8");

    $results["result"]=array();

    // saving uploaded file
    $target_dir = getcwd();
    $target_name = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . "/" . $target_name;

    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

    // saving path to saved file to session variable
    $fileToRead = "./" . $target_name;
    $_SESSION["fileName"] = $fileToRead;

    $delimiter = $_POST["delimiter"];

    // file reading (debug to check uploaded file)
    ob_start();
    /*
    $row = 1;
    if (($handle = fopen($fileToRead, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
            $num = count($data);
            echo "<p> $num fields in line $row: <br /></p>\n";
            $row++;
            for ($c=0; $c < $num; $c++) {
                echo $data[$c] . "<br />\n";
            }
        }
        fclose($handle);
    }
    */
    $result_file_read = ob_get_clean();

    // generating dump of POST
    ob_start();
    var_dump($_POST);
    $result_POST = ob_get_clean();

    // generating dump of FILES
    ob_start();
    var_dump($_FILES);
    $result_FILES = ob_get_clean();

    // generating dump of SESSION
    ob_start();
    var_dump($_SESSION);
    $result_SESSION = ob_get_clean();

    // creating structure with content of uploaded file and generating passwords
    $newCsvData = array();
    if (($handle = fopen($fileToRead, "r")) !== FALSE) {
        $counter = 0;
        while (($data = fgets($handle)) !== FALSE) {
            $data = substr($data,0,-2);
            if($counter==0){
                $newLine = $delimiter . "password";
            }else {
                $newLine = $delimiter . generateRandomString();
            }
            $data = $data . $newLine . "\n";
            $newCsvData[] = $data;
            $counter = $counter + 1;
        }
        fclose($handle);
    }

    // recreating file with passwords from generated structure
    $handle = fopen($fileToRead, 'w');

    foreach ($newCsvData as $line) {
        fwrite($handle, $line);
    }

    fclose($handle);

    // creating response with generated dumps
    array_push($results["result"], array(
        "name" => $target_name,
        "debug_POST" => $result_POST,
        "debug_FILES" => $result_FILES,
        "debug_SESSION" => $result_SESSION,
        "debug_file_read" => $result_file_read,
    ));

    http_response_code(200);

    echo json_encode($results);

    function generateRandomString() {
        $length = 15;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters = str_shuffle($characters );
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>
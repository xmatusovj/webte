<?php

include "config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$file = $_FILES["fileToUpload"];
$filename = $_FILES["fileToUpload"]["name"];
$filetmpname = $_FILES["fileToUpload"]["tmp_name"];

$rok = $_POST['rok'];
$predmet = $_POST['predmet'];
$oddelovac = $_POST['oddelovac'];

echo $rok .$predmet .$oddelovac;

echo "name: $filename <br>";
$uploadOk = 1;
$ext = pathinfo($filename, PATHINFO_EXTENSION);
echo "ext: $ext <br>";


// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats	/*ZMEN si tu typy suborov*/
if($ext != "csv") {
    echo "Nepodporovaný typ súboru, podporované typy: csv";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file is not OK.";
// if everything is ok, try to upload file
} else {
    echo "You file is OK.";
}


    echo "<br><br>$filename data:<br><br>";
   
    // The nested array to hold all the arrays
    $the_big_array = []; 

    // Open the file for reading
    ini_set('auto_detect_line_endings',TRUE);
    if (($h = fopen("{$filetmpname}", "r")) !== FALSE) 
    {
      // Each line in the file is converted into an individual array that we call $data
      // The items of the array are comma separated
      while (($data = fgetcsv($h, 1000, $oddelovac)) !== FALSE) 
      {
        // Each individual array is being pushed into the nested array
        $the_big_array[] = $data;
      }

      // Close the file
      fclose($h);
    }
    ini_set('auto_detect_line_endings',FALSE);

    // Display the code in a readable format
    // echo "<pre>";
    // var_dump($the_big_array);
    // echo "</pre> <br><br>";

    for ($x=1; $x < count($the_big_array); $x++) { 
        for ($i=0; $i < count($the_big_array[$x]); $i++) { 
            echo $the_big_array[$x][$i];
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        echo "<br>";
    } 




    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    for ($x=1; $x < count($the_big_array); $x++) { 
        $sql = "INSERT INTO `student`(`id`, `meno`, `email`, `heslo`, `tim`, `kapitan`, `body`, `suhlas`, `predmet`, `rok`) 
        VALUES (".$the_big_array[$x][0].",'".$the_big_array[$x][1]."','".$the_big_array[$x][2]."','".hash('sha256',$the_big_array[$x][3])."',".$the_big_array[$x][4].",0,0,0,'".$predmet."','".$rok."')";    
        $result = $conn->query($sql);


        $sql = "SELECT `tim`, `predmet`,`rok` FROM `bodytim` WHERE 1";
        $result = $conn->query($sql);

        $existuje = FALSE;
        while(list($tim2, $predmet2, $rok2) = mysqli_fetch_row($result))
        {
            if(($tim2 == $the_big_array[$x][4])&&($predmet2 == $predmet)&&($rok2 == $rok)){$existuje = TRUE;}
        }
        if(!$existuje)
        {
            $sql = "INSERT INTO `bodytim`(`tim`, `body`, `predmet`, `suhlasadmin`, `rok`) VALUES (".$the_big_array[$x][4].",0,'".$predmet."',0,'".$rok."')";
            $result = $conn->query($sql);
        }
    }

    header("Location: https://147.175.121.210:4437/webte_zadanie/uloha2.php")


?>
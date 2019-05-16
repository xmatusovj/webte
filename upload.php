<?php
$filePath = $_FILES["newFile"]["name"];
$extension = pathinfo($filePath, PATHINFO_EXTENSION);
$fileName = $_POST["courseName"] . "." . $extension;

$uploadPath = "predmety/" . $_POST["year"] . "/" . $fileName;

if(file_exists($uploadPath)) {
    echo "<script type='text/javascript'>alert('Súbor existuje, zvoľte iný názov \\nFile already exists, choose different name')</script>";
    header( "refresh:0;url=https://147.175.121.210:4493/webte_zadanie/uloha1.php" );
    exit();
}

if(move_uploaded_file($_FILES["newFile"]["tmp_name"], $uploadPath)){
    chmod($uploadPath,0777);
    echo "<script type='text/javascript'>alert('Súbor bol úspešne nahraný na server \\nFile successfully uploaded to server')</script>";
    header( "refresh:0;url=https://147.175.121.210:4493/webte_zadanie/uloha1.php" );
}
else {
    echo "<script type='text/javascript'>alert('Neočakávaná chyba \\nUnexpected error')</script>";
    header( "refresh:0;url=https://147.175.121.210:4493/webte_zadanie/uloha1.php" );
}
?>
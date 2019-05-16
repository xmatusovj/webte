<?php
    session_start();

    include "config.php";
    $mysqli = new mysqli($hostname,$username,$password,$db);
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");

    if(!isset($_SESSION['lang']) && (!isset($_GET['lang']) || $_GET['lang']=="sk")) {
        $_SESSION['lang']="sk";
    }
    else if(isset($_GET['lang']))$_SESSION['lang']=$_GET['lang'];
    if(!isset($_SESSION['lang'])) {
        include "lang_sk.php";
    }
    else {
        include "lang_".$_SESSION['lang'].".php";
    }

    if(isset($_GET["logout"]) && $_GET["logout"]==1) {
        session_unset();
        session_destroy();
        header("Location: https://147.175.121.210:4493/webte_zadanie/login.php");
    }

    if(!isset($_SESSION['user'])) {
        header("Location: https://147.175.121.210:4493/webte_zadanie/login.php");
    }
?>

<!DOCTYPE html>

<html lang="sk">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= TEXT_TITLE?></title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://unpkg.com/jspdf"></script>
    <script src="https://unpkg.com/jspdf-autotable"></script>
</head>

<body>
<ul class=horizontal>
    <li><a href="index.php"><?= TEXT_HOME?></a></li>
    <li><a class=active href="uloha1.php"><?= TEXT_TASK1?></a></li>
    <li><a href="uloha2.php"><?= TEXT_TASK2?></a></li>
    <li><a href="uloha3.php"><?= TEXT_TASK3?></a></li>
    <a class="logout" href="uloha1.php?logout=1"><img src="img/turn-off.png" title="Log out"></a>
    <a class="lang" href="uloha1.php?lang=sk"><img class=langimg src="img/sk.png" title="SK"></a>
    <a class="lang" href="uloha1.php?lang=en"><img class=langimg src="img/uk.png" title="EN"></a>
</ul>

<section>
    <?php
    if (isAdmin($_SESSION['user'],$mysqli)) {
        $dir = "predmety/";
        $files = array_slice(scandir($dir),2);

        echo "<h2>".UPLOAD_DATA."</h2><br>";
        echo "<form action='upload.php' method='POST' id='uploadFile' enctype='multipart/form-data'>";
        echo TEXT_CHOOSEYEAR . ": <select name='year' id='chooseYearUpload' form='uploadFile'><option value='' disabled selected>".TEXT_CHOOSEYEAR."</option>";
        foreach ($files as $folderYear) {
            echo "<option value='$folderYear'>" . $folderYear . "/" . ($folderYear+1) ."</option>";
        }
        echo "</select><br>";
        echo TEXT_COURSENAME . ": <input type='text' name='courseName'><br>";
        echo TEXT_SELECTFILE . ": <input type='file' name='newFile'><br>";
        echo TEXT_DELIMITER . ": <input type='text' name='delimiter'><br>";
        echo "<input type='submit' name='upload' value='".TEXT_UPLOADFILE."'><br>";
        echo "</form>";
    }
    else {
        $dir = "predmety/";
        $files = array_slice(scandir($dir),2);

        echo TEXT_CHOOSEYEAR . ": <select id='chooseYear'><option value='' disabled selected>".TEXT_CHOOSEYEAR."</option>";
        foreach ($files as $folderYear) {
            echo "<option value='$folderYear'>" . $folderYear . "/" . ($folderYear+1) ."</option>";
        }
        echo "</select>";
    }
    ?>
</section>

<section style="display: none" id="result">

</section>

<section id="sectionTables">
    <?php
    $dir = "predmety/";
    $files = array_slice(scandir($dir),2);

    echo "<h2>".TEXT_SHOWTABLES."</h2><br>";
    echo TEXT_CHOOSEYEAR . ": <select id='chooseYearTables'><option value='' disabled selected>".TEXT_CHOOSEYEAR."</option>";
    foreach ($files as $folderYear) {
        echo "<option value='$folderYear'>" . $folderYear . "/" . ($folderYear+1) ."</option>";
    }
    echo "</select><br>";
    echo TEXT_CHOOSECOURSE . ": <select id='chooseCourseTable'><option value='' disabled selected>".TEXT_CHOOSECOURSE."</option>";
    echo "</select><br>";
    echo "<div id='tables'></div>";
    ?>
    <button id="download" onclick="downloadTable()" disabled><?= TEXT_DOWNLOADTABLE ?></button>
</section>

<section id="sectionDelete">
    <?php
    $dir = "predmety/";
    $files = array_slice(scandir($dir),2);

    echo "<h2>".TEXT_DELETECOURSE."</h2><br>";
    echo "<form action='delete.php' method='POST' id='deleteFile' enctype='multipart/form-data'>";
    echo TEXT_CHOOSEYEAR . ": <select id='chooseYearDelete'><option value='' disabled selected>".TEXT_CHOOSEYEAR."</option>";
    foreach ($files as $folderYear) {
        echo "<option value='$folderYear'>" . $folderYear . "/" . ($folderYear+1) ."</option>";
    }
    echo "</select><br>";
    echo TEXT_CHOOSECOURSE . ": <select name='chooseCourseDelete' id='chooseCourseDelete'><option value='' disabled selected>".TEXT_CHOOSECOURSE."</option>";
    echo "</select><br>";
    echo "<input type='submit' id='deleteButton' name='folderName' value='".TEXT_DELETECOURSE."' disabled>";
    echo "</form>";
    ?>
</section>

<section id="sectionNewYear">
    <form action='newYearFolder.php' method='POST' enctype='multipart/form-data'>
    <?php
    echo "<h2>".TEXT_CREATEFOLDER."</h2><br>";
    echo TEXT_CHOOSEYEAR . ": <input type='text' pattern='[0-9]{4}[+/][0-9]{4}' name='folderName' placeholder='YYYY/YYYY'>";
    echo "<input type='submit' name='newFolderSubmit' value='".TEXT_SUBMIT."'>";
    ?>
    </form>
</section>

<script>
    function downloadTable() {
        var doc = new jsPDF();
        doc.autoTable({html: '#courseTable'});
        doc.save('table.pdf');
    }

    $(document).ready(function() {

        <?php
            if (isAdmin($_SESSION['user'],$mysqli)) {
                echo "$('#sectionTables').css('display', 'block');";
                echo "$('#sectionDelete').css('display', 'block');";
                echo "$('#sectionNewYear').css('display', 'block');";
            }
        ?>

        $("#chooseYear").change(function () {
            $.ajax({
                type: 'GET',
                url: 'https://147.175.121.210:4493/webte_zadanie/uloha1_handler.php/' + document.getElementById("invisible").innerText + '/' + document.getElementById("chooseYear").value,
                success: function (msg) {
                    $("#result").css("display", "block");
                    $("#result").html(msg);
                }
            });
        });

        $("#chooseYearTables").change(function () {
            $.ajax({
                type: 'GET',
                url: 'https://147.175.121.210:4493/webte_zadanie/uloha1_deletehandler.php/' + document.getElementById("chooseYearTables").value,
                success: function (msg) {
                    $("#chooseCourseTable").html(msg);
                }
            });
        });

        $("#chooseCourseTable").change(function () {
            $.ajax({
                type: 'GET',
                url: 'https://147.175.121.210:4493/webte_zadanie/uloha1_tableshandler.php/' + document.getElementById("chooseCourseTable").value,
                success: function (msg) {
                    $("#tables").html(msg);
                    $("#download").prop('disabled', false);
                }
            });
        });

        $("#chooseYearDelete").change(function () {
            $.ajax({
                type: 'GET',
                url: 'https://147.175.121.210:4493/webte_zadanie/uloha1_deletehandler.php/' + document.getElementById("chooseYearDelete").value,
                success: function (msg) {
                    $("#chooseCourseDelete").html(msg);
                    if(msg != "<option value='' disabled selected>No results</option>") $("#deleteButton").prop('disabled', false);
                    else $("#deleteButton").prop('disabled', true);
                }
            });
        });
    });
</script>

<span id="invisible"><?= $_SESSION['user']; ?></span>
</body>
</html>

<?php
function isAdmin($name,$mysqli) {

    $query = "SELECT id, login, password
                      FROM admins
                      WHERE login='".$name."'";
    $result = $mysqli->query($query);
    if(mysqli_num_rows($result)==1) {
        return true;
    }
    else return false;
}
?>
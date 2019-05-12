<?php
    session_start();
    
    include "config.php";
    $mysqli = new mysqli($hostname,$username,$password,$db);
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");

    if (!isset($_SESSION['lang']) && (!isset($_GET['lang']) || $_GET['lang']=="sk")) {
        $_SESSION['lang']="sk";
    } elseif (isset($_GET['lang'])) {
        $_SESSION['lang']=$_GET['lang'];
    }
    if (!isset($_SESSION['lang'])) {
        include "lang_sk.php";
    } else {
        include "lang_".$_SESSION['lang'].".php";
    }

    if (isset($_GET["logout"]) && $_GET["logout"]==1) {
        session_unset();
        session_destroy();
        // header("Location: https://147.175.121.210:4493/webte_zadanie/login.php");
    }

    if (!isset($_SESSION['user'])) {
        // header("Location: https://147.175.121.210:4493/webte_zadanie/login.php");
    }
    echo "<p style='hidden' id='lang'>" . $_SESSION["lang"] . "</p>";
    ?>

<!DOCTYPE html>

<html lang="sk">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="language" content="<?php echo $_SESSION['lang'] ?>">
    <title><?php= TEXT_TITLE?></title>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="fileDownloadHandler.js"></script>
</head>

<body onload="fileDownloadHandler()" onunload="destroy_session()">
    <ul class=horizontal>
        <li><a href="index.php"><?= TEXT_HOME?></a></li>
        <li><a href="uloha1.php"><?= TEXT_TASK1?></a></li>
        <li><a href="uloha2.php"><?= TEXT_TASK2?></a></li>
        <li><a class=active href="uloha3.php"><?= TEXT_TASK3?></a></li>
        <a class="logout" href="uloha3.php?logout=1"><img src="img/turn-off.png" title="Log out"></a>
        <a class="lang" href="uloha3.php?lang=sk"><img class=langimg src="img/sk.png" title="SK"></a>
        <a class="lang" href="uloha3.php?lang=en"><img class=langimg src="img/uk.png" title="EN"></a>
    </ul>

    <section>   
        <?php
            if (isAdmin($_SESSION['user'],$mysqli)) {

            }
            if (!isAdmin($_SESSION['user'],$mysqli)) {
                echo TEXT_ADMINONLY;
            }
        ?>
        <!-- Code here -->
        <?php echo "<h1>" . TEMPLATE . "</h1>" ?>
        <?php
   
        include_once('send_email.php');
        ?>
        <div>
            <?php echo "<h1>" . UPLOAD_DATA . "</h1>"?>
            <form id='formToSendFile' action='javascript:fileDownloadHandler()' method='post' enctype='multipart/form-data'>
                <?php echo SELECT_FILE ?>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="text" name="delimiter" id="delimiter" placeholder="delimiter">
                <input type="submit" value="Upload" name="submit">
            </form>
            <div id="processedFileDownload"></div>
        </div>
        <div>
            <?php echo "<h1>" . ADD_NEW_TEMPLATE . "</h1>"?>
            <input id="title" placeholder=<?php echo TEMPLATE_TITLE ?>>
            <button onclick={saveSchema()}><?php echo SAVE_TEMPLATE ?></button>
        </div>
        <div class="sendEmailContainer">
            <?php echo "<h1>" . SEND_EMAILS . "</h1>" ?>
            <p id="errorContainer"></p>
            <input id="name" placeholder="<?php echo SENDER_NAME?>">
            <input id="email" placeholder="<?php echo SENDER_EMAIL?>">
            <input id="password" placeholder="<?php echo SENDER_PASSWORD?>">
            <input id="emailTitle" placeholder="<?php echo EMAIL_SUBJECT?>">
            <div>
                <label><?php echo FILE_WITH_DATA ?></label><input id="file" type="file" placeholder="file">
            </div>
            <div>
                <label><?php echo ATTACHMENT?></label><input id="optionalFileToSend" type="file" placeholder="optionalFileToSend">
            </div>
        </div>
        <button onclick={sendEmail()}><?php echo SEND_EMAILS?></button>


        <?php include_once('displayEmailHistory.php')?>
    </section>

    <!-- Include the Quill library -->
    <script src="uloha3.js"></script>
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

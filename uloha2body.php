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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
	 $("#POST1").click(function(){
	    $.ajax({
	       type: 'POST',
	       url: 'https://147.175.121.210:4437/webte_zadanie/uloha2change.php/'+ document.getElementById("quantity").value ,         
	       success: function(msg){
	          $("#sprava").html(msg);    }});
	  });
	});
	</script>

</head>

<body>
<ul class=horizontal>
    <li><a href="index.php"><?= TEXT_HOME?></a></li>
    <li><a href="uloha1.php"><?= TEXT_TASK1?></a></li>
    <li><a class=active href="uloha2.php"><?= TEXT_TASK2?></a></li>
    <li><a href="uloha3.php"><?= TEXT_TASK3?></a></li>
    <a class="logout" href="uloha2.php?logout=1"><img src="img/turn-off.png" title="Log out"></a>
    <a class="lang" href="uloha2.php?lang=sk"><img class=langimg src="img/sk.png" title="SK"></a>
    <a class="lang" href="uloha2.php?lang=en"><img class=langimg src="img/uk.png" title="EN"></a>
</ul>

<section>

<?php

	include "config.php";

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$predmet = $_POST['predmet'];
	$rok = $_POST['rok'];    

	$conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

	$sql = "SELECT COUNT(meno) FROM `student` WHERE predmet='".$predmet."' AND rok='".$rok."'";
	$result = $conn->query($sql);
	list($studenti) = mysqli_fetch_row($result);

	$sql = "SELECT COUNT(meno) FROM `student` WHERE predmet='".$predmet."' AND rok='".$rok."' AND suhlas='1'";
	$result = $conn->query($sql);
	list($suhlas) = mysqli_fetch_row($result);

	$sql = "SELECT COUNT(meno) FROM `student` WHERE predmet='".$predmet."' AND rok='".$rok."' AND suhlas='-1'";
	$result = $conn->query($sql);
	list($nesuhlas) = mysqli_fetch_row($result);

	$sql = "SELECT COUNT(predmet) FROM `bodytim` WHERE predmet='".$predmet."' AND rok='".$rok."'";
	$result = $conn->query($sql);
	list($timy) = mysqli_fetch_row($result);

	$sql = "SELECT COUNT(predmet) FROM `bodytim` WHERE predmet='".$predmet."' AND rok='".$rok."' AND suhlasadmin='1'";
	$result = $conn->query($sql);
	list($timysuhlas) = mysqli_fetch_row($result);

	echo U2_PREDMET.': '.$predmet .'<br>'.U2_ROK.': '. $rok . '<br>
	<fieldset>
	<legend>'.U2_STATS.'</legend>
		'.U2_POCET_STUDENTOV.': '.$studenti.'<br>
		'.U2_SUHLAS.': '.$suhlas.'<br>
		'.U2_NESUHLAS.': '.$nesuhlas.'<br>
		'.U2_NEHLASOVAL.': '.($studenti - $suhlas -$nesuhlas).'<br>
		'.U2_POCET_TIMOV.': '.$timy.'<br>
		'.U2_SUHLAST.': '.$timysuhlas.'<br>
		'.U2_NESUHLAST.': '.($timy - $timysuhlas).'<br>
	</fieldset>
	';

	



	$sql = "SELECT `tim` FROM `bodytim` WHERE predmet='".$predmet."' AND rok='".$rok."'";
	$result = $conn->query($sql);
	echo '<form action="#" method="post" enctype="multipart/form-data">
	'.U2_TEAM.': <select name="tim">';
	while(list($tim) = mysqli_fetch_row($result)){
			echo '<option value="'.$tim.'">'.$tim.'</option>';
  	}	
  	echo '</select>
    <input type="hidden" name="predmet" value="'.$predmet.'">
    <input type="hidden" name="rok" value="'.$rok.'">
  	<input type="submit" name="submit" value="'.TEXT_SUBMIT.'">
  	</form>';

  	echo '<fieldset>';


  	if( isset($_POST['tim']) ) 
	{ 
		$tim = $_POST['tim']; 

		$sql = "SELECT `body`FROM `bodytim` WHERE predmet='".$predmet."' AND rok='".$rok."' AND tim='".$tim."'";
		$result = $conn->query($sql);
		list($body) = mysqli_fetch_row($result);
		echo '<br>Group: '.$tim . '<br>
		Points: <input type="number" name="quantity" min="0" max="150" value="'.$body.'">
		<button id="POST1">Change</button>
		<table>
			<thead><tr><th>Email</th><th>Full name</th><th>Points</th><th>Agree</th></tr></thead>
			<tbody>';
			$sql = "SELECT `meno`, `email`,`body`, `suhlas` FROM `student` WHERE tim=".$tim." AND rok='".$rok."' AND predmet='".$predmet."'";
			$result = $conn->query($sql);
			while(list( $email, $meno, $body, $suhlas) = mysqli_fetch_row($result)){
			echo '<tr>
					<td>'.$meno.'</td><td>'.$email.'</td><td>'.$body.'</td><td>'.$suhlas.'</td>
			</tr>';
  			}	
			echo'
			</tbody>
		</table>
		<button id="SUHLAS" name="SUHLAS">I agree</button>
		<button id="NESUHLAS" name="NESUHLAS">I disagree</button>
		</fieldset>
		';
	}
  	

?>	

</section>

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
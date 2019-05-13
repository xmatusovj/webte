<?php
	session_start();

	$idStudenta =  $_POST["idStudenta"];
	$hesloStudenta =  $_POST["hesloStudenta"];

/*
echo "<hr>idStudenta: ";
echo $idStudenta;
echo "<hr>hesloStudenta: ";
echo $hesloStudenta;
echo "<hr>";
*/


	require_once('config.php');

	$hesloU2;

	try {    
		$db0123 = new PDO("mysql:host=$servername;dbname=$dbu2", $username, $password);
		$db0123->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query0123 = "SELECT heslo FROM student WHERE id = '".$idStudenta."' ";
		$stmt0123 = $db0123->query($query0123); 

	
		$row0123 = $stmt0123->fetch(PDO::FETCH_ASSOC);
		$hesloU2 = $row0123['heslo'];				

	}
	catch(PDOException $e)
	{
		//echo "<br>VYSKYTLA SA CHYBA <br>";
	}

	$password = hash('sha256',$hesloStudenta);//password_hash($hesloStudenta, PASSWORD_DEFAULT);
/*	echo $password;
	echo "<br>";
	echo $hesloU2;
*/
	if( $hesloU2 == $password ){
		//echo "spravne heslo";
		$_SESSION['netrafilprihlasenyStudentDoUlohy2'] = "OK";
		$_SESSION['prihlasenyStudentDoUlohy2'] = "JE";
	}
	else{
		$_SESSION['netrafilprihlasenyStudentDoUlohy2'] = "ZZZ";
		//echo "zle heslo";
	}


header("Location:uloha2.php");
?>
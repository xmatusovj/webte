<?php

	$idStudenta =  $_POST["idStudenta"];
	$suhlasAky =  $_POST["suhlasAky"];
	$predmetPrihlaseneho = $_POST["predmetPrihlaseneho"];

/*
echo "<hr>idStudenta: ";
echo $idStudenta;
echo "<hr>suhlasAky: ";
echo $suhlasAky;
echo "<hr>predmetPrihlaseneho: ";
echo $predmetPrihlaseneho;
echo "<hr>";
*/


	require_once('config.php');

	$conn = new mysqli($servername, $username, $password, $dbu2);
	// Check connection
	if ($conn->connect_error) {
		//die("Connection failed: " . $conn->connect_error);
	} 

	$sql123 = " UPDATE student SET suhlas = '".$suhlasAky."' WHERE id = '".$idStudenta."'  AND predmet = '".$predmetPrihlaseneho."' ";

	

	//if ($conn->query($sql123) === TRUE) { echo "ano";}	else{ echo "nie";}
	if ($conn->query($sql123) === TRUE) { echo "";}	else{ echo "";}


	$conn->close();


header("Location:uloha2.php");
?>
<?php

	$idStudenta =  $_POST["idStudenta"];
	$noveBodyStudenta =  $_POST["noveBodyStudenta"];
	$predmetPrihlaseneho = $_POST["predmetPrihlaseneho"];

/*
echo "<hr>idStudenta: ";
echo $idStudenta;
echo "<hr>noveBodyStudenta: ";
echo $noveBodyStudenta;
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

	$sql123 = " UPDATE student SET body = '".$noveBodyStudenta."' WHERE id = '".$idStudenta."'  AND predmet = '".$predmetPrihlaseneho."' ";

	

	//if ($conn->query($sql123) === TRUE) { echo "ano";}	else{ echo "nie";}
	if ($conn->query($sql123) === TRUE) { echo "";}	else{ echo "";}


	$conn->close();


header("Location:myuloha2.php");
?>
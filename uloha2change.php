<?php 	
	$method = $_SERVER['REQUEST_METHOD'];
	
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	$input = json_decode(file_get_contents('php://input'),true);   
	 
	$stat = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
	// $aaa = array_shift($request);		
	// $aaa2 = array_shift($request);		
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	

//echo "<br>".$_SERVER['PATH_INFO']."<br>";
// echo "method: $method"."<br>";
// echo "get: ".$_GET['dateGetName']."<br>";
// echo "request: $request"."<br>";
// echo "stat: $stat"."<br>";
// echo "aaa: $aaa"."<br>";
// echo "aaa2: $aaa2"."<br>";

echo "SOM TU TU TU";


$conn = new mysqli($servername, $username, $password, $dbu2);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

	$sql = "UPDATE `bodytim` SET `body`=6 WHERE 1 tim='5' AND predmet='webte' AND rok='2017/2018'";
	$result = $conn->query($sql);

?>
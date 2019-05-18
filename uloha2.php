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
    <!-- Code here -->
    <?php
    if (isAdmin($_SESSION['user'],$mysqli)) {
    //dorobit jazyk
    	echo '<link rel="stylesheet" href="uloha2styly.css">';
		include "config.php";

		echo '
		<fieldset>
		<legend>Pridaj subor</legend>
		<form action="uloha2vloz.php" method="post" enctype="multipart/form-data">
			Rok:
			<select name="rok">
				<option value="2016/2017">2016/2017</option>
				<option value="2017/2018">2017/2018</option>
				<option value="2018/2019">2018/2019</option>
		  	</select><br>
		  	Nazov predmetu:
		  	<input type="text" name="predmet" value="predmet"><br>
		    Vlozit subor:
		    <input type="file" name="fileToUpload" id="fileToUpload"><br>
			Oddelovac:
			<select name="oddelovac">
				<option value=",">,</option>
				<option value=";">;</option>
		  	</select><br>
		    <input type="submit" name="submit">
		</form>
		</fieldset>
		';

		$conn = new mysqli($servername, $username, $password, $dbname);
	    // Check connection
	    if ($conn->connect_error) {
	        die("Connection failed: " . $conn->connect_error);
	    } 

	    

		echo '
		<fieldset>
		<legend>Rozdelenie bodov</legend>
		<form action="uloha2body.php" method="post" enctype="multipart/form-data">
			Rok:
			<select name="rok">';
			$sql = "SELECT DISTINCT `rok`FROM `student` WHERE 1";    
       		$result = $conn->query($sql);
       		while(list($rok) = mysqli_fetch_row($result)){
				echo '<option value="'.$rok.'">'.$rok.'</option>';
		  	}
		  	echo'</select><br>
		  	Nazov predmetu:<select name="predmet">';
		  	$sql = "SELECT DISTINCT `predmet`FROM `student` WHERE 1";    
        	$result = $conn->query($sql);
		  	while(list($predmet) = mysqli_fetch_row($result)){
				echo '<option value="'.$predmet.'">'.$predmet.'</option>';
		  	}		  	
		  	echo'
		  	</select><br>
		    <input type="submit" name="submit" value="Zobraz">
		</form>
		</fieldset>
		';

    }

    if (!isAdmin($_SESSION['user'],$mysqli)) {

		//MY kod zaciatok -------------------------------------------------------------------------------------------------------------------------------------

		echo '<link rel="stylesheet" href="uloha2styly.css">';
			//require_once('config.php');
			include "config.php";

			//MY new kod zac

				/**/
				/*
				echo "<hr><hr>";
				echo "_SESSION['user']: ";
				echo $_SESSION['user'];
				echo "<hr><hr>";
				echo "<hr><hr>";
				echo "_SESSION['useridu2']: ";
				echo $_SESSION['useridu2'];
				echo "<hr><hr>";
				/**/

				$prihlaseny  = $_SESSION['user'];

				$idPrihlaseneho = 1;
				$idPrihlaseneho =  $_SESSION['useridu2'];

				/*
				echo "<hr>ID:";
				echo $idPrihlaseneho;
				echo "<hr>";
				*/

				//$prihlaseny = "neznamy";

				try {    
					$db01234444 = new PDO("mysql:host=$servername;dbname=$dbu2", $username, $password);
					$db01234444->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$query01234444 = "SELECT meno FROM student WHERE id = '".$idPrihlaseneho."' ";
					$stmt01234444 = $db01234444->query($query01234444); 

				
					$row01234444 = $stmt01234444->fetch(PDO::FETCH_ASSOC);
					$prihlaseny = $row01234444['meno'];				

				}
				catch(PDOException $e)
				{
					//echo "<br>VYSKYTLA SA CHYBA <br>";
				}

				//$prihlaseny  = $_SESSION['user'];
			 

				//$prihlaseny  = "meno1";
				 
				echo U2_PRIHLASENY;
				echo ": " . $prihlaseny . " (AIS login: " . $_SESSION['user'] . ") (AIS ID: " . $_SESSION['useridu2'] . ")<hr>";

			//MY new kod kon

			 $hesloU2;
			 $idStudentaZac;

			 try {    
				$db0123 = new PDO("mysql:host=$servername;dbname=$dbu2", $username, $password);
				$db0123->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$query0123 = "SELECT * FROM student WHERE meno = '".$prihlaseny."' ";
				$stmt0123 = $db0123->query($query0123); 

			
				$row0123 = $stmt0123->fetch(PDO::FETCH_ASSOC);
				$hesloU2 = $row0123['heslo'];	
				$idStudentaZac = $row0123['id'];				

			}
			catch(PDOException $e)
			{
				//echo "<br>VYSKYTLA SA CHYBA <br>";
			}
			//echo $idStudentaZac;

			if($hesloU2){	//ked je heslo zadane, tak sa s nim treba prihlasit
				 if(!isset($_SESSION['prihlasenyStudentDoUlohy2'])) {
				 	echo"<td>";
				 	echo'
						<form action="uloha2prihlasenie.php" method="post">
						<!-- <form action="uloha2prihlasenie.php" method="post" target="_blank"> --->
							<input class="inputSchov" type="text" name="idStudenta"  value= "'. $idStudentaZac .'">
							<input type="password" name="hesloStudenta" value="AAAA">
							<input type="submit" value="' . U2_PRIHLASIT_SA . '">							
						</form>
					</td>';
					//$_SESSION['netrafilprihlasenyStudentDoUlohy2'] = "AAA";
					//echo $_SESSION['netrafilprihlasenyStudentDoUlohy2'];

					if(isset($_SESSION['netrafilprihlasenyStudentDoUlohy2'])) {
						if($_SESSION['netrafilprihlasenyStudentDoUlohy2'] == "ZZZ"){
							echo "<br>";
							echo U2_ZLE_HESLO;
							echo "<br>";
						}
					}
					else{
					}
				 }
				 else{
				 	echo U2_PRIHLASENY_AJ_CEZ_HESLO;
				 }
				 echo"<hr>";
			}
			else{	//ked nie je heslo zadane netreba sa nim prihlasit		
				$_SESSION['prihlasenyStudentDoUlohy2'] = "JE";		
			}


			if(isset($_SESSION['prihlasenyStudentDoUlohy2'])) {

				try {    
					$db0 = new PDO("mysql:host=$servername;dbname=$dbu2", $username, $password);
					$db0->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$query0 = "SELECT predmet FROM student WHERE meno = '".$prihlaseny."' ";
					$stmt0 = $db0->query($query0); 

					echo'
						<form action="#" method="post">
									'.U2_VYBER_PREDMET.': <select name="predmetPrihlasenehoStudenta" style="width: 200px">';

					while($row0 = $stmt0->fetch(PDO::FETCH_ASSOC)){
						echo '<option value="' . $row0['predmet'] . '">' . $row0['predmet'] . '</option>';
					}

					echo'			
							</select>		 
							<br>
							<br>
							<input type="submit" name="vybranyPredmet" value="'.U2_VYBRAT_PREDMET.'">
							<br>
						</form>
					';
				}
				catch(PDOException $e)
				{
					//echo "<br>VYSKYTLA SA CHYBA <br>";
				}

				echo "<hr>";


				//if(isset($_POST['vybranyPredmet'])){
				if(isset($_POST['predmetPrihlasenehoStudenta'])){
					$predmetPrihlaseneho = $_POST['predmetPrihlasenehoStudenta'];
					echo U2_VYBRANY_PREDMET_JE;
				 	echo ": " . $predmetPrihlaseneho . "<hr>";
					 
					 //zistenie timu z dtb

					 $cilsloTimu = 0;
					 $pocetBodovTimu = 0;

					 $prihlasenyAkoKapitanTimu = 0;		// 1 = kapitan, -1 = nekapitan, 0 = nezistene



					try {    
						$db = new PDO("mysql:host=$servername;dbname=$dbu2", $username, $password);
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						//echo 'Connected to database';	

						$query1 = "SELECT * FROM student WHERE meno = '".$prihlaseny."' AND predmet = '".$predmetPrihlaseneho."' ";
						$stmt1 = $db->query($query1); 
						$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
						$cilsloTimu = $row1['tim'];
						$idStudentaHelp = $row1['id'];
						

						$query2 = "SELECT body FROM bodytim WHERE tim = '".$cilsloTimu."'  AND predmet = '".$predmetPrihlaseneho."' ";
						$stmt2 = $db->query($query2); 
						$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
						$pocetBodovTimu = $row2['body'];


						if ($row1['kapitan'] == 1) {		//ak je kapitan timu
							$prihlasenyAkoKapitanTimu = 1;	
						}
						elseif ($row1['kapitan'] == -1) {	//ak nie je		
							$prihlasenyAkoKapitanTimu = -1;	
						}
						else{								//pozri ci uz je kapitan, ak nie je dana osoba sa nim stane
							$query3 = "SELECT * FROM student WHERE tim = '".$cilsloTimu."'  AND predmet = '".$predmetPrihlaseneho."' ";
							$stmt3 = $db->query($query3); 
							//$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
							while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
								//echo "<br>row:";
								//echo $row3['id'];
								//echo " - ";
								//echo $row3['tim'];
								//echo " - ";
								//echo $row3['kapitan'];

								if($row3['kapitan'] == 1){	//ak uz je niekto kapitanom, tak tento  bude nekapitan
									$prihlasenyAkoKapitanTimu = -1;
								}		
							}
							//echo "<hr>01prihlasenyAkoKapitanTimu: ";
							//echo $prihlasenyAkoKapitanTimu;

							if($prihlasenyAkoKapitanTimu == -1){	//ak ma byt nekapitan
							}
							else{	//inac ma byt kapitan
								$prihlasenyAkoKapitanTimu = 1;
							}

							//echo "<hr>02prihlasenyAkoKapitanTimu: ";
							//echo $prihlasenyAkoKapitanTimu;
							//echo "<hr>";

							//teraz sa to ci je dana osoba kapitan alebo nekapitan vlozi do dtb
							// Create connection
							$conn = new mysqli($servername, $username, $password, $dbu2);
							// Check connection
							if ($conn->connect_error) {
								//die("Connection failed: " . $conn->connect_error);
							} 

							$sql123 = " UPDATE student SET kapitan = '".$prihlasenyAkoKapitanTimu."' WHERE meno = '".$prihlaseny."'  AND predmet = '".$predmetPrihlaseneho."' ";

							if ($conn->query($sql123) === TRUE) { echo "";}	else{ echo "";}


							$conn->close();


						}

					
						echo U2_TIM_CISLO;
						echo $cilsloTimu;

						echo U2_TIM_ZISKAL;
						echo $pocetBodovTimu;
						echo U2_TIM_BODOV;


				//zaciatok vypisu tab


						echo '<div id="divtabrozdeleniebodov">	
								<table id="table_id" class="display">
									<thead>
										<tr>
											<th>' . U2_MENO . '</th>
											<th>' . U2_SUHLAS_BODY . '</th>	
											<th>' . U2_BODY . '</th>';
									
									if ($prihlasenyAkoKapitanTimu == 1) {
										echo '
											<th>' . U2_MENENIE_BODOV . '</th>
										';
									}
									
									echo'</tr>
									</thead>				
									<tbody>';

						$bodyRozdeleneUz = 0;
						$volneBody = 0;

						$query34 = "SELECT body FROM student WHERE tim = '".$cilsloTimu."'  AND predmet = '".$predmetPrihlaseneho."' ";
						$stmt34 = $db->query($query34); 
						while($row34 = $stmt34->fetch(PDO::FETCH_ASSOC)){	
							$bodyRozdeleneUz = $bodyRozdeleneUz + $row34['body'];
						}

						$volneBody = $pocetBodovTimu - $bodyRozdeleneUz;

						echo U2_TIM_ROZDELENE_BODY;
						echo $bodyRozdeleneUz;
						echo U2_TIM_BODOV2;
						echo $volneBody;
						echo U2_TIM_BODOV;


						echo "<br><br>";
						if ($prihlasenyAkoKapitanTimu == 1) {		//ak je kapitan timu	
							echo U2_TIM_SI_KAPITAN;
						}
						elseif ($prihlasenyAkoKapitanTimu == -1) {	//ak nie je kapitan timu
							echo U2_TIM_NIE_SI_KAPITAN;
						}
						echo "<br><br>";			


						


						$query4 = "SELECT * FROM student WHERE tim = '".$cilsloTimu."'  AND predmet = '".$predmetPrihlaseneho."' ";
						$stmt4 = $db->query($query4); 
						while($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)){
							echo '<tr>';
								echo '<td>' . $row4['meno'] . '</td>';

								//echo '<td>' . $row4['suhlas'] . '</td>';
								if ( $row4['suhlas'] == -1) {
									echo '<td>' . U2_NESUHLAS . '</td>';
								}
								elseif ( $row4['suhlas'] == 1) {
									echo '<td>' . U2_SUHLAS . '</td>';
								}
								else{
									echo '<td>' . U2_NEHLASOVAL . '</td>';
								}

								if ($prihlasenyAkoKapitanTimu == 1) {		//ak je kapitan timu
									echo '<td>' . $row4['body'] . '</td>';	
									//$idpole123 = 'body' + $row4['id'];
									//echo $idpole123; 
									//echo '<td><input type="number" name="aaa" min="0" max="30"></td>';		

									$volneBodyAktualnyStudent = $volneBody + $row4['body'];

									$boloUzOdsuhlaseneNiekym = 0;		//ak ano bude 1

									$query6 = "SELECT suhlas FROM student WHERE tim = '".$cilsloTimu."'  AND predmet = '".$predmetPrihlaseneho."' ";
									$stmt6 = $db->query($query6); 
									while($row6 = $stmt6->fetch(PDO::FETCH_ASSOC)){
										if($row6['suhlas'] != 0){
											$boloUzOdsuhlaseneNiekym = 1;
										}
									}

									if($boloUzOdsuhlaseneNiekym == 0){

										echo'<td>
											<form action="uloha2help1.php" method="post">
											<!-- <form action="uloha2help1.php" method="post" target="_blank"> --->
												<input class="inputSchov" type="text" name="idStudenta"  value= "'. $row4['id'] .'">
												<input class="inputSchov" type="text" name="predmetPrihlaseneho"  value= "'. $predmetPrihlaseneho .'">
												<input type="number" name="noveBodyStudenta" min="0" max="' . $volneBodyAktualnyStudent . '" value="' . $row4['body'] . '">
												<input type="submit" value="' . U2_ZMENIT_BODY . '">							
											</form>
										</td>';

									}
							

								}
								elseif ($prihlasenyAkoKapitanTimu == -1) {	//ak nie je kapitan timu
									echo '<td>' . $row4['body'] . '</td>';	

								}
								else{	//nemalo by nastat
								}
								
								
							echo '</tr>';						
						}


						if ($prihlasenyAkoKapitanTimu == 1) {	//ak nie je kapitan timu

							echo '<tr>';
								echo '<td>' . "" . '</td>';	
								echo '<td>' . "" . '</td>';	
								echo '<td>' . "" . '</td>';	
								
						}

						

						echo '</tbody>
							</table>
						  </div>';


						$query5 = "SELECT suhlas FROM student WHERE tim = '".$cilsloTimu."'  AND predmet = '".$predmetPrihlaseneho."'  AND id = '".$idStudentaHelp."' ";
						$stmt5 = $db->query($query5); 
						$row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
						
						if( ($row5['suhlas'] == 0) && ($pocetBodovTimu == $bodyRozdeleneUz) ){	//suhlasit sa da, iba ak este dany student nesuhlasil a uz su rozdelene vsetky body
							echo'  
							<form action="uloha2help2.php" method="post" > 
								<input class="inputSchov" type="text" name="idStudenta"  value= "'. $idStudentaHelp .'">
								<input class="inputSchov" type="text" name="predmetPrihlaseneho"  value= "'. $predmetPrihlaseneho .'">
								<input class="inputSchov" type="number" name="suhlasAky" value="1">
								<input type="submit" value="' . U2_SUHLAS2 . '">							
							</form>
							';

							echo'  
							<form action="uloha2help2.php" method="post" > 
								<input class="inputSchov" type="text" name="idStudenta"  value= "'. $idStudentaHelp .'">
								<input class="inputSchov" type="text" name="predmetPrihlaseneho"  value= "'. $predmetPrihlaseneho .'">
								<input class="inputSchov" type="number" name="suhlasAky" value="-1">
								<input type="submit" value="' . U2_NESUHLAS2 . '">							
							</form>
							';
						}

				//koniec vypisu tab


					}
					catch(PDOException $e)
					{
						//echo "<br>VYSKYTLA SA CHYBA <br>";
					}

				}

			}

			//MY kod koniec -------------------------------------------------------------------------------------------------------------------------------------



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
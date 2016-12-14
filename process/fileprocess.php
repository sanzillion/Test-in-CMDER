<?php 

session_start();
include "process/functions.php";
$db = connect();

if(isset($_POST['sub'])){
	// try{
		$uploaddir = 'uploads/';
		$uploadfile = $uploaddir . basename($_FILES['csv']['name']);
		echo $uploadfile;
		if(move_uploaded_file($_FILES['csv']['tmp_name'],$uploadfile)){
			echo "good!";
		}
		else{
			echo "not good!";
		}
								//SOLVE THIS LOAD DATA INFILE (WITHOUT LOCAL FOR SECURITY)
		$name = $_FILES['csv']['name'];
		$query = $db->prepare("LOAD DATA LOCAL INFILE '$uploadfile' INTO TABLE `test` FIELDS 
		TERMINATED BY ',' LINES TERMINATED BY '\n' (`name` , `yrs`)");
	//	$query->execute();
		if($query->execute()){
			echo 'successfully uploaded';
			$query->closeCursor();
		}
		else{
			echo 'failed!';
			$query->closeCursor();
		}
	// }
	// catch(Exception $e){
	// 	echo $e;
	// }
	
	
}

if(isset($_POST['submit'])){
// 	if(is_uploaded_file($_FILES['userfile']['tmp_name']) && 
// 		is_uploaded_file($_FILES['yrs']['tmp_name'])){
// 		if($_FILES['userfile']['type'] != "text/plain" && 
// 			$_FILES['yrs']['type'] != "text/plain"){
// 			echo "Invalid Filetype";
// 		}
// 		elseif($_FILES['userfile']['size'] > 5000 &&
// 			$_FILES['yrs']['size'] > 5000){
// 			echo "File too large";
// 		}
// 		elseif($_FILES['userfile']['size'] < 50 &&
// 			$_FILES['yrs']['size'] < 50){
// 			echo "File too small";
// 		}
// 		elseif($_FILES['userfile']['error'] > 0 &&
// 			$_FILES['yrs']['error'] > 0){
// 			echo "Invalid File/ No file";
// 		}
// 		else{
			
// 			$name = $_FILES['userfile']['name'].'<br>';
// 			echo "Name: ".'<br>';
// 			echo $_FILES['userfile']['type'].'<br>';
// 			echo $_FILES['userfile']['size'].'<br>';
// 			echo $_FILES['userfile']['tmp_name'].'<br>';
// 			echo $_FILES['userfile']['error'].'<br>';
// 			echo "Yrs: ".'<br>';
// 			echo $_FILES['yrs']['type'].'<br>';
// 			echo $_FILES['yrs']['size'].'<br>';
// 			echo $_FILES['yrs']['tmp_name'].'<br>';
// 			echo $_FILES['yrs']['error'].'<br>';

// 			// $uploaddir = '../sad/files/';
// 			// $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
// 			// echo $uploadfile;
// 			// if(move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadfile)){
// 			// 	echo "good!";
// 			// }
// 			// else{
// 			// 	echo "not good!";
// 			// }

// 			$string = file_get_contents($_FILES['userfile']['tmp_name'], "r");
// 			$string2 = file_get_contents($_FILES['yrs']['tmp_name'], "r");
// 			$names = explode("\n", $string);
// 			$yrs = explode("\n", $string2);

// 			$arraycount = count($names);
// 			$arraycount2 = count($yrs);
// 			if($arraycount == $arraycount2){

// 				$arraycount -=1;

// 				for($i = 0; $i < $arraycount; $i++){
// 				// echo $names[$i].'<br>';
// 		    	$query = $db->prepare("INSERT INTO test SET 
// 								name = ?, yrs = ?");
// 				$query->bindParam(1,$names[$i]);
// 				$query->bindParam(2,$yrs[$i]);
// 				$query->execute();

// 				}
// 			}
			

 ?>
<?php
session_start();
include "../process/functions.php";
if(!isset($_SESSION['admin'])){
	header('Location: ../pages/login.php?error2');
}
$admin = $_SESSION['admin'];
$db = connect();

if(isset($_POST['sub'])){ //Register Student
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$name = $fname." ".$lname;
	$yr = $_POST['yr'];

		if(findstudents($name)){
			header('Location: student.php?error=1');
		}
		else{
		$query = $db->prepare("INSERT INTO student SET 
			                 		name = ?,
			                 		year = ?");

		$query->bindParam(1,$name);
		$query->bindParam(2,$yr);

		$query->execute();
		}
	}

if(isset($_GET['action']) && $_GET['action']=='delete'){
	//delete from student record also delete the student from sanction record
	$g = getstudentsbyid($_GET['id']);
	$name = $g->name;
	deletefromsanc($name);
	deleteonestudent($_GET['id']);
	header('Location:student.php');
}
elseif(isset($_GET['action']) && $_GET['action']=='deleteall'){
	//if click deleteALL then delete also all from sanction records
	deleteall();
	deleteallsanction();
}

$array = getstudents(); //select everyone

if(isset($_POST['search'])){ //search by name
	if(findname($_POST['search'])){
		$array = getstudent2($_POST['search']);
	}
	else{
		header('Location:#popup3');
	}
}
if(isset($_POST['searchyr'])){ //search by year
	$yr = $_POST['searchyr'];
	$array = getbyyr($yr);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link href = "../css/main.css" rel = "stylesheet">
</head>
<body background="../img/bc.png">
	<div class="banner">
		<div class="logo"><img src="../img/s.png"></div>
	</div>
	<div class="container">
		<div class="innerbanner">
		<ul>
			<li><a class="students" href="admin.php">Admin</a></li>
			<li class="admin">Students</li>
			<li><a class="meetings" href="meeting.php">Meetings</a></li>
			<li><a class="sanctions" href="sanction.php">Sanctions</a></li>
			<div class="diff"><li><a href=""><img src="../img/set.png"></a>
				<ul class="dropdown" text-align="right">
					<li><a href="">Help</a></li>
					<li><a href="../process/logout.php">Logout</a></li>
				</ul>
			</li></div>
		</ul>

			
		</div>
		<div class="contentbox">

		<div class="innerbox1">
		<form class="regform" method="POST" action="#">
		<p>Register Student</p>
		<?php
			if(isset($_GET['error'])){
			$id2 = "errors";
			echo '<div class='.$id2.'>Name already exists!</div>';
			}	
		?>
		<input type="text" name="fname" placeholder="firstname" required>
		<input type="text" name="lname" placeholder="lastname" required>
		<select name="yr" required>
			<option></option>
			<option>1st</option>
			<option>2nd</option>
			<option>3rd</option>
			<option>4th</option>
		</select>
		<input type="submit" name="sub">
		</form>
			<p>Search by Name:</p>
			<form class="searched" method="POST" action="student.php" >
					<input type="text" name="search" placeholder="Name here">
			</form>
			<p>Search by Year:</p>
			<form class="searchyr" method="POST" action="student.php">
			<select name="searchyr" onchange="this.form.submit()">
				<option disabled>Search here</option>
				<option>1st</option>
				<option>2nd</option>
				<option>3rd</option>
				<option>4th</option>
			</select>
			</form>
			<br><br>
			<a href="student.php?action=deleteall" onclick="return confirm('Sanction Records Will be deleted too!')">Delete All</a>
		</div>
			<div class="innerbox7">
			<div class="innerbox2">
				<table class="table1" border="2">
					<tr>
						<th>Name</th>
						<th>Year</th>
						<th>Option</th>
					</tr>
					<?php foreach ($array as $g):?>
					<tr>
						<td><?php echo  $g->name; ?></td>
						<td><?php echo  $g->year; ?></td>
						<td><a 	href="../process/pass.php?id=<?php echo $g->s_id;?>">
						<img src="../img/edit.png">&nbsp</a>
						<a href="student.php?id=<?php echo $g->s_id;?>
						&action=delete" onclick="return confirm('Are you sure?')">
						<img src="../img/delete.png"></a>
						</td>
					</tr>
					<?php endforeach;?>
				</table>
			</div>
			</div>	
		</div>
	</div>

	<div id="popup" class="overlay">
		<?php
		$s_id = $_SESSION['id'];
		$account = getstudentsbyid($s_id);
		?>
	<div class="popup">
		<?php
			// if($_SESSION['error']=='1'){
			// $id2 = "error1";
			// echo '<div class='.$id2.'>Wrong Password</div>';
			// }
			// elseif($_SESSION['error']=='3'){
			// $id2 = "error1";
			// echo '<div class='.$id2.'>Retype it correctly</div>';
			// }
			// elseif($_SESSION['error']=='2'){
			// $id2 = "error1";
			// echo '<div class='.$id2.'>Set a new password</div>';
			// }		
		?>
		<h2>Student Information</h2>
		<a class="close" href="#">&times;</a>
		<div class="content2">
			<form action="../process/updatestudent.php" method="POST">
			<h3>Student no.<?php echo $account->s_id; ?> </h3>
			<input required="Required Field" type="hidden" name="id"
				value="<?php echo $account->s_id;?>"></td>
			<table class="poptable">
			<tr>
				<td><label>Name:</label></td>
				<td><input type="text" name="name" required
				value="<?php echo $account->name?>"</td>
			</tr>
			<tr>
				<td><label>Year:</label></td>
				<td>
				<select name="yr" reuired>
					<option><?php echo $account->year?></option>
					<option>1st</option>
					<option>2nd</option>
					<option>3rd</option>
					<option>4th</option>
				</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="update" value="Save"></td>
			</tr>
						
			</table>
			</form>
		</div>
	</div>
	</div>

	<div id="popup2" class="overlay">
	<div class="popup">
		<a class="close" href="#">&times;</a>
		<div class="content3">
			<h2>Successfully Updated!</h2>
		</div>
	</div>
	</div>

	<div id="popup3" class="overlay">
	<div class="popup">
		<a class="close" href="#">&times;</a>
		<div class="content3">
			<h2>No results Found!</h2>
		</div>
	</div>
	</div>

</body>
</html>
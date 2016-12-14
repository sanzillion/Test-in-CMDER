<?php
session_start();
include "../process/functions.php";
if(!isset($_SESSION['admin'])){
	header('Location: ../pages/login.php?error2');
}
$admin = $_SESSION['admin'];
$db = connect();

if(isset($_GET['action']) && $_GET['action']=='delete'){
	
	$account = getmeetbyid($_GET['id']);
	$desc = $account->description;

	$query = $db->prepare("ALTER TABLE `sanction` DROP `$desc`");
	if($query->execute()){
		deletemeetbyid($_GET['id']);
		Header('Location: meeting.php');
	}
	else{
		Header('Location: meeting.php#popup4');
	}
}

if(isset($_GET['action']) && $_GET['action']=='deleteall'){
	$getmeet = getmeet();

	$arraycount = count($getmeet);
	for ($i = 0; $i < $arraycount; $i++){
	$meet[] = implode(',', $getmeet[$i]);
	}
	for ($x = 0; $x < $arraycount; $x++){
		$query = $db->prepare("ALTER TABLE `sanction` DROP `$meet[x]`");
		$query->execute();
	}
	deleteallmeetings();
	header('Location: meeting.php');
}



$sth = $db->prepare("SELECT DISTINCT description From meeting");
	$sth->execute();
	$results = $sth->rowCount();

$arraycount = $results;
if($arraycount > 7){
	$dis = "disabled";
}
else{
	$dis = "none";
}

$array = getmeet();
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
			<li><a class="meetings" href="student.php">Students</a></li>
			<li class="admin">Meetings</li>
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
		<form class="regform" method="POST" action="../process/registerprocess.php">
		<p>Add Event</p>
		<input type="text" name="desc" placeholder="Description" required maxlength="11" <?php echo $dis;?>
		pattern="[a-zA-Z]{.11}" title="Format: aA">
		<input type="date" name="dato"  required="required" maxlength="11" placeholder="yyyy-dd-mm" <?php echo $dis;?>>
		<input type="submit" name="sub" <?php echo $dis;?>>
		</form>

		<a href="meeting.php?action=deleteall" onclick="return confirm('Are you sure?')">Delete all</a>
			
		</div>
			<div class="innerbox6">
				<table class="table1" border="2">
					<tr>
						<th>ID</th>
						<th>Desc</th>
						<th>Date</th>
						<th>Option</th>
					</tr>
					<?php foreach ($array as $g):?>
					<tr>
						<td><?php echo  $g->m_id; ?></td>
						<td><?php echo  $g->description; ?></td>
						<td><?php echo  $g->m_date; ?></td>
						<td><a href="../process/pass1.php?id=<?php echo $g->m_id;?>">
						<img src="../img/edit.png">&nbsp</a> 
						<a href="meeting.php?id=<?php echo $g->m_id;?>
						&action=delete" onclick="return confirm('Are you sure?')">
						<img src="../img/delete.png"></a>
						</td>
					</tr>
					<?php endforeach;?>
				</table>
			</div>	
		</div>
	</div>

	<div id="popup" class="overlay">
		<?php //EDIT EVENT
		$m_id = $_SESSION['id']; 
		$acount = getmeetbyid($m_id);
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
		<h2>Event Information</h2>
		<a class="close" href="#">&times;</a>
		<div class="content2">
			<form action="../process/updatestudent.php" method="POST">
			<h3>Event no.<?php echo $account->m_id; ?> </h3>
			<input required="Required Field" type="hidden" name="id"
				value="<?php echo $account->m_id;?>"></td>
			<table class="poptable">
			<tr>
				<td><label>Description:</label></td>
				<td><input type="text" name="des" required
				value="<?php echo $account->description?>"</td>
			</tr>
			<tr>
				<td><label>Date:</label></td>
				<td><input type="date" name="dat" required
				value="<?php echo $account->m_date?>"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="updato" value="Save"></td>
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

	<div id="popup4" class="overlay">
	<div class="popup">
		<a class="close" href="#">&times;</a>
		<div class="content3">
			<h2>Try again later: DB error!</h2>
		</div>
	</div>
	</div>

	<div id="popup5" class="overlay">
	<div class="popup">
		<a class="close" href="#">&times;</a>
		<div class="content3">
			<h2>Add meeting first!</h2>
		</div>
	</div>
	</div>

</body>
</html>
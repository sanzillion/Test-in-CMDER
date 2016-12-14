<?php
session_start();
include "../process/functions.php";
if(!isset($_SESSION['admin'])){
	header('Location: ../pages/login.php?error2');
}

$admin = $_SESSION['admin'];
$db = connect();
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
			<li class="admin">Admin</li>
			<li><a class="students" href="student.php">Students</a></li>
			<li><a class="meetings" href="meeting.php">Meetings</a></li>
			<li><a class="sanctions" href="sanction.php">Sanctions</a></li>
			<div class="diff"><li><a href=""><img src="../img/set.png"></a>
				<ul class="dropdown" text-align="right">
					<li><a href="#popup4">Help</a></li>
					<li><a href="../process/logout.php">Logout</a></li>
				</ul>
			</li></div>
		</ul>
			
		</div>
		<div class="contentbox">
			<div class="innerbox">
				<p>Welcome <b><?php echo $admin?></b></p>
				<!-- <p>Update admin password below:</p> -->
				<a href="../process/passingvalue.php">Edit Password</a>
				<!-- <p>See login records below:</p> --><br><br>
				<a href="#popup2">Login Records</a>
			</div>	

			<div class="innerbox8">
				<form class="uptxt" enctype="multipart/form-data" action="../process/filprocess.php" 
				method="POST">
				    <p>Txt Files Upload</p>
				    <input name="userfile" type="file" placeholder="Names" required>
				    <input type="file" name="Year" placeholder="Names" required> 
				    <input type="submit" value="Send File" name="submit" >
				</form>

				<form class="upcsv" enctype="multipart/form-data" action="../process/filprocess.php" 
				method="POST">
				    <p>CSV File Upload</p>
				    <input name="csv" type="file" placeholder="" value="Names" required>
				    <input type="submit" value="Send File" name="sub" >
				</form>
			</div>
		</div>
	</div>

	<div id="popup" class="overlay">
		<?php
		//echo $_SESSION['admin'];
		$admin = $_SESSION['admin'];
		$account = getadmin($admin);
		?>
	<div class="popup">
		<?php
			if($_SESSION['error']=='1'){
			$id2 = "error1";
			echo '<div class='.$id2.'>Wrong Password</div>';
			}
			elseif($_SESSION['error']=='3'){
			$id2 = "error1";
			echo '<div class='.$id2.'>Retype it correctly</div>';
			}
			elseif($_SESSION['error']=='2'){
			$id2 = "error1";
			echo '<div class='.$id2.'>Set a new password</div>';
			}		
		?>
		<h2>Change Password</h2>
		<a class="close" href="#">&times;</a>
		<div class="content2">
			<form action="../process/adminpass.php" method="POST">
			<h3>Admin no.<?php echo $account->id; ?> </h3>
			<input required="Required Field" type="hidden" name="id"
				value="<?php echo $account->id;?>"></td>
			<table class="poptable">
			<tr>
				<td><label>Old password:</label></td>
				<td><input type="password" name="old" required></td>
			</tr>
			<tr>
				<td><label>New Password:</label></td>
				<td><input type="password" name="new" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
				title="Must contain at least one number and one uppercase and lowercase letter and at least 8 or more characters"></td>
			</tr>
			<tr>
				<td><label>Confirm Password:</label></td>
				<td><input type="password" name="con" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
				title="Must contain at least one number and one uppercase and lowercase letter and at least 8 or more characters"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="change" value="Save"></td>
			</tr>
						
			</table>
			</form>
		</div>
	</div>
	</div>

	<div id="popup2" class="overlay">
	<div class="popup">
		<h2>Login Records</h2>
		<a class="close" href="#">&times;</a>
		<div class="content">
			<div class="span">
				<table class="recordtable" border="3">
				<tr>
					<th>ID</th>
					<th>User</th>
					<th>Date</th>
					<th>Time</th>
					<th>Day</th>
				</tr>
				<?php foreach (getrecord() as $g):?>
				<tr>
					<td><?php echo  $g->r_id; ?></td>
					<td><?php echo  $g->name; ?></td>
					<td><?php echo  $g->dates; ?></td>
					<td><?php echo  $g->time; ?></td>
					<td><?php echo  $g->day; ?></td>
				</tr>
				<?php endforeach;?>
				</table>
			</div>
		</div>
	</div>
	</div>

	<div id="popup3" class="overlay">
	<div class="popup">
		<a class="close" href="#">&times;</a>
		<div class="content3">
			<h2>You have successfully <br> change the password!</h2>
		</div>
	</div>
	</div>

	<div id="popup4" class="overlay">
	<div class="popup">
		<h4 class="pfunctions" align="center">Page Functions:</h4>
		<a class="close" href="#">&times;</a>
		<div class="content4">
			<h4><h5>Edit Password</h5> - this password is for the admins, whosoever login
			can have his/her password change.<br>
			<h5>Login Records</h5> - these records are the datetime records of admin
			log-ins for auditing.<br>
			<h5>TXT uploads</h5> - this feature serves as a quick registration function
			through .txt files with students names and yr, it has a limit in file size and 
			it only accepts specific file type. <a href="">See here</a> for a copy of .txt format
			that the system can read. For more inquiries, pls contact System Support<br>
			<h5>CSV uploads</h5> - this feature is also for quick registration, it is faster and more
			efficient than .txt uploads. CSV stands for comma-separated-values. This format is
			available on save-as function of an excel file. An excel file with 2 columns and multiple
			rows will be extracted into the .csv file, which like a txt file, but fields are separated
			by commas and rows and terminated by nextLine which will be read by LOAD DATA LOCAL INFILE 
			query and registers the content into database. <a href="">See here</a> for a copy of .csv 
			format. Contact system support for bugs and errors </h4>
		</div>
	</div>
	</div>

</body>
</html>
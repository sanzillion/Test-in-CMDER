<?php
session_start();
include "../process/functions.php";
if(!isset($_SESSION['admin'])){
	header('Location: ../pages/login.php?error2');
}
$admin = $_SESSION['admin'];
$db = connect();


if(isset($_GET['action']) && $_GET['action']=='delete'){
	$db = connect();
	$sth = $db->prepare("DELETE FROM sanction Where sanc_id = :id");
	$sth->bindValue('id',$_GET['id']);
	$sth->execute();
	header('Location: sanction.php');
}
elseif(isset($_GET['action']) && $_GET['action']=='delete'){
	deleteallsanction();
	header('Location: sanction.php');
}

$getmeet = getmeet();
$getsanc = getsanction();

if(isset($_POST['search'])){
	$name = $_POST['search'];
	$getsanc = getsanctionbyname($name);
}
elseif(isset($_POST['year'])){
	$yr = $_POST['year'];
	$getsanc = sancbyyear($yr);
}

$getdesc = getdescription();
$arraycount = count($getdesc);
$_SESSION['count']=$arraycount;

for ($i = 0; $i <$arraycount; $i++){
	$desc[] = implode(',', $getdesc[$i]);
}

	$stmt2 = $db->prepare("SELECT distinct name from student");
	$stmt2->execute();
	$data = $stmt2->fetchAll(PDO::FETCH_ASSOC);

	$option = "";
	foreach ($data as $row) {
        $id = $row['name'];
        $option.='<option value="'.$id.'">'.$id.'</option>';
    }
    
if($arraycount < 1 || $arraycount == 0){
	header('Location: meeting.php#popup5');
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
			<li><a class="meetings" href="student.php">Students</a></li>
			<li><a class="sanctions" href="meeting.php">Meetings</a></li>
			<li class="admin">Sanctions</li>
			<div class="diff"><li><a href=""><img src="../img/set.png"></a>
				<ul class="dropdown" text-align="right">
					<li><a href="">Help</a></li>
					<li><a href="../process/logout.php">Logout</a></li>
				</ul>
			</li></div>
		</ul>

		</div>
		<div class="contentbox">

		<div class="innerbox3">
		<form class="regforms" method="POST" action="../process/sanctionprocess.php">
		<p>Add Sanction</p>
		<?php
			if(isset($_GET['error'])){
			$id2 = "errors";
			echo '<div class='.$id2.'>Already exists!</div>';
			}	
		?>
		<select name="name" class="options_sched" required="required">
					<option disabled selected hidden value="">Name</option>
    				<?php echo $option?>
		</select><br>
		<?php if($arraycount >= 1)
		{echo '<select name="'.$desc[0].'" required>'; 
		 echo '<option disabled selected hidden value="">'.$desc[0].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo '<option>CLEARED</option><option>PRESENT</option></select>';}?>
		<?php if($arraycount >= 2)
		{echo '<select name="'.$desc[1].'" required>'; 
		 echo '<option disabled selected hidden value="">'.$desc[1].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo '<option>CLEARED</option><option>PRESENT</option></select><br>';}?>
		<?php if($arraycount >= 3)
		{echo '<select name="'.$desc[2].'" required>'; 
		 echo '<option disabled selected hidden value="">'.$desc[2].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo '<option>CLEARED</option><option>PRESENT</option></select>';}?>
		<?php if($arraycount >= 4)
		{echo '<select name="'.$desc[3].'" required>'; 
		 echo '<option disabled selected hidden value="">'.$desc[3].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select><br>';}?>
		<?php if($arraycount >= 5)
		{echo '<select name="'.$desc[4].'" required>'; 
		 echo '<option disabled selected hidden value="">'.$desc[4].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select>';}?>
		<?php if($arraycount >= 6)
		{echo '<select name="'.$desc[5].'" required>'; 
		 echo '<option disabled selected hidden value="">'.$desc[5].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select><br>';}?>
		<?php if($arraycount >= 7)
		{echo '<select name="'.$desc[6].'" required>'; 
		 echo '<option disabled selected hidden value="">'.$desc[6].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select>';}?>
		 <?php if($arraycount >= 8)
		{echo '<select name="'.$desc[7].'" required>'; 
		 echo '<option disabled selected hidden value="">'.$desc[7].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select><br>';}?>
		<input type="submit" name="addsanc" value="Submit">
		</form>
		</div>

		<div class="innerbox5">
		<form class="search" method="POST" action="sanction.php">
			<label>Search by name</label>
			<br><input type="text" name="search" placeholder="search">
		</form>
		<br>
		<form class="searches" method="POST" action="sanction.php">
			<label>Search by year</label>
			<br><select name="year" onchange="this.form.submit()">
				<option disabled>Here</option>
				<option>1st</option>
				<option>2nd</option>
				<option>3rd</option>
				<option>4th</option>
			</select>
		</form>
		<br> <a href="sanction.php?action=deleteall">Delete All</a>
		</div>

			<div class="innerbox4">
				<table class="table1" border="1">
		<tr>
			<th>Student</th>
			<?php foreach ($getmeet as $g):?>
			<th><?php echo $g->description; ?></th>
			<?php endforeach;?>
			<th>Option</th>
		</tr>
		<?php foreach ($getsanc as $k):?>
		<tr>
			<td><?php echo $k->s_name ?></td>
			<?php try{ ?>
			<?php if($arraycount >= 1){echo '<td>'.$k->$desc[0].'</td>';} ?>
			<?php if($arraycount >= 2){echo '<td>'.$k->$desc[1].'</td>';} ?>
			<?php if($arraycount >= 3){echo '<td>'.$k->$desc[2].'</td>';} ?>
			<?php if($arraycount >= 4){echo '<td>'.$k->$desc[3].'</td>';} ?>
			<?php if($arraycount >= 5){echo '<td>'.$k->$desc[4].'</td>';} ?>
			<?php if($arraycount >= 6){echo '<td>'.$k->$desc[5].'</td>';} ?>
			<?php if($arraycount >= 7){echo '<td>'.$k->$desc[6].'</td>';} ?>
			<?php if($arraycount >= 8){echo '<td>'.$k->$desc[7].'</td>';} ?>
			<?php }catch(exception $e){echo "DB error";}?>
			<td><a href="../process/pass2.php?id=<?php echo $k->sanc_id;?>">
			<img src="../img/edit.png">&nbsp</a>
			<a href="sanction.php?id=<?php echo $k->sanc_id;?>
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
		<?php
		
		$id = $_SESSION['id'];

		$stmt = $db->prepare("SELECT * from sanction where sanc_id = :id");
		$stmt->bindValue('id',$id);
		$stmt->execute();
		$account = $stmt->fetch(PDO::FETCH_OBJ);
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
		<h2>Sanction Information</h2>
		<a class="close" href="#">&times;</a>
		<div class="content2">
			<h3>Sanction of <?php echo $account->s_name; ?> </h3>
		<table>
		<form method="POST" action="../process/sanctionprocess.php">
		<input required="Required Field" type="hidden" name="id"
				value="<?php echo $account->sanc_id;?>"></td>
		<?php if($arraycount >= 1)
		{echo '<tr><td><label>'.$desc[0].'</label></td><td><select name="'.$desc[0].'" required>'; 
		 echo '<option>'.$account->$desc[0].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo '<option>CLEARED</option><option>PRESENT</option></select></td></tr>';}?>
		<?php if($arraycount >= 2)
		{echo '<tr><td><label>'.$desc[1].'</label></td><td><select name="'.$desc[1].'" required>'; 
		 echo '<option>'.$account->$desc[1].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo '<option>CLEARED</option><option>PRESENT</option></select></td></tr>';}?>
		<?php if($arraycount >= 3)
		{echo '<tr><td>'.$desc[2].'</label></td><td><select name="'.$desc[2].'" required>'; 
		 echo '<option>'.$account->$desc[2].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo '<option>CLEARED</option><option>PRESENT</option></select></td></tr>';}?>
		<?php if($arraycount >= 4)
		{echo '<tr><td><label>'.$desc[3].'</label></td><td><select name="'.$desc[3].'" required>'; 
		 echo '<option>'.$account->$desc[3].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select></td></tr>';}?>
		<?php if($arraycount >= 5)
		{echo '<tr><td><label>'.$desc[4].'</label></td><td><select name="'.$desc[4].'" required>'; 
		 echo '<option>'.$account->$desc[4].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select></td></tr>';}?>
		<?php if($arraycount >= 6)
		{echo '<tr><td><label>'.$desc[5].'</label></td><td><select name="'.$desc[5].'" required>'; 
		 echo '<option>'.$account->$desc[5].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select></td></tr>';}?>
		<?php if($arraycount >= 7)
		{echo '<tr><td><label>'.$desc[6].'</label></td><td><select name="'.$desc[6].'" required>'; 
		 echo '<option>'.$account->$desc[6].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select></td></tr>';}?>
		 <?php if($arraycount >= 8)
		{echo '<tr><td><label>'.$desc[7].'</label></td><td><select name="'.$desc[7].'" required>'; 
		 echo '<option>'.$account->$desc[7].'</option>';
		 echo '<option>50</option><option>100</option><option>PAID</option>';
		 echo'<option>CLEARED</option><option>PRESENT</option></select></td></tr>';}?>
		<tr><td colspan="2"><input type="submit" name="updatesanc"></td></tr>
		</form>
		</table>
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
			<h2>Successfully Added!</h2>
		</div>
	</div>
	</div>

</body>
</html>
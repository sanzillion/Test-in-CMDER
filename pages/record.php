<?php
session_start();

include "../process/functions.php";
$db = connect();
$getmeet = getmeet();
$getsanc = getsanction();

if(isset($_POST['search'])){
	$name = $_POST['search'];
	$getsanc = getsanctionbyname($name);
}
elseif(isset($_POST['searchyr'])){
	$yr = $_POST['searchyr'];
	$getsanc = sancbyyear($yr);
}

$getdesc = getdescription();
$arraycount = count($getdesc);
$_SESSION['count']=$arraycount;

for ($i = 0; $i <$arraycount; $i++){
	$desc[] = implode(',', $getdesc[$i]);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>SAD</title>
	<link href = "../css/record.css" rel = "stylesheet">
</head>
<body background="../img/bc.png">
<div class="fixbox">
<a href="../index.php"><img class="img1" src="../img/back.png"></a> </div>
	<div class="containers">
		<div class="logoban">
			<h1 align="center">Sanction Records</h1>
		</div>
		<div class="recordbox">
		<div class="botbox">
		<form class="search" method="POST" action="record.php" >
					<input type="text" name="search" placeholder="Search by Name/ All">
		</form>
		<form class="searchyr" method="POST" action="record.php">
		<select name="searchyr" onchange="this.form.submit()">
			<option disabled selected hidden value="">Search by year</option>
			<option>1st</option>
			<option>2nd</option>
			<option>3rd</option>
			<option>4th</option>
		</select>
		</form>
		</div>
			<div class="overflowbox">
			<table class="table1" border="1">
		<tr>
			<th>Student</th>
			<?php foreach ($getmeet as $g):?>
			<th><?php echo $g->description; ?></th>
			<?php endforeach;?>
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
		</tr>
		<?php endforeach;?>
		</table>
		</div>
		
		</div>

	</div>
</body>
</html>
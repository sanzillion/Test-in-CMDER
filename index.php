<?php
session_start();
session_destroy();

?>

<!DOCTYPE html>
<html>
<head>
	<title>SAD</title>
	<link href = "css/front.css" rel = "stylesheet">
</head>
<body background="img/bc.png">
	<div class="container">
		<div class="logo">
			<img src="img/eyetea2.png">
		</div>
	<img class="banner" src="img/banner.png">
		<div class="box">
			<table class="indextable">
				<tr>
					<td width="25%" class="img1">
					<a href="">
					<p>Bulletin</p><img  src="img/bulletin.png"></a></td>

					<td width="25%" class="img2">
					<a href="pages/record.php">
					<p>Record</p><img src="img/record.png"></a></td>

					<td width="25%" class="img3">
					<a href="pages/login.php">
					<p>Admin</p><img src="img/admin.png"></a></td>

					<td width="25%" class="img4">
					<a href="">
					<p>Suuport</p><img src="img/suppor.png"></a></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
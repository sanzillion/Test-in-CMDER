<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href = "../css/login.css" rel = "stylesheet">
</head>
<body background="../img/bc.png">
<div class="fixbox">
<a href="../index.php"><img class="img1" src="../img/back.png"></a> </div>
<div class = "container">
	<div class="box">
	<img class="img2" src="../img/logo.png">
	<div class="error">
			<?php
			if(isset($_GET['error1'])){
			echo '<p>Invalid Username or Password!<p/>';
			}
			?>
		</div>
		<div class="error2">
		<?php
			if(isset($_GET['error2'])){
			echo '<p>You need to login first!<p/>';
			}
			?>
	</div>
		<form method="POST" action="../process/loginprocess.php">
			<input type="text" name="user" placeholder="username" required>
			<input type="password" name="pass" placeholder="password" required>
			<input type="submit" name="submit" value="Login">
		</form>
	</div>
</div>

</body>
</html>


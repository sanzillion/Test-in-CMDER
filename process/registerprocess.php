<?php
session_start();
include "../process/functions.php";
$db = connect();

if(isset($_POST['sub'])){
	$desc = $_POST['desc'];
	$date = $_POST['dato'];

	$query = $db->prepare("INSERT INTO meeting SET 
		                 		description = :descs,
		                 		m_date = :datet");

	$execute_query = [':descs' => $desc, 
						':datet' => $date];

	$query->execute($execute_query);

	$sth = $db->prepare("ALTER TABLE  `sanction` ADD  `$desc` VARCHAR(11) NOT NULL");
	$sth->execute();

	header('Location: ../pages/meeting.php');
	}
?>
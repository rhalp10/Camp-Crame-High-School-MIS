<?php
$uid=$_SESSION['uid'];
?>
		<a href="index_registrar.php">HOME</a>|
		<a href="admission_registrar.php">ADMISSION <?php require_once('myFunctions.php'); displayTotalPrereg($uid);?> </a>|
		<a href="announcement.php">ANNOUNCEMENT</a>|
		<a href="record_management.php">RECORDS</a>|
		<a href="tools.php">TOOLS</a>|
		<a href="account_settings_emp.php">SETTINGS</a>|
		<a href="logout.php">LOGOUT</a>
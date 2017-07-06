<?php
	session_start();
	require_once('dbconfig.php');
	
	$userid = $_SESSION['userid'];
	$username=$_POST['uname'];
	$pass=$_POST['np1'];
	
	$query="UPDATE usermaster SET ";
	$query=$query."username='$username', ";
	$query=$query."password=PASSWORD('$pass') ";
	$query=$query."WHERE userid=$userid";
	
	mysql_query($query);
?>

<html><script languange="javascript">
		alert("Account Information has been successfully updated. You will be logged out for the changes to take effect.");
		window.opener.location="logout.php"
		window.close();
	</script>
</html>
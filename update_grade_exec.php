<?php
	session_start();
	require_once('dbconfig.php');
	
	$userid = $_SESSION['userid'];
	$level = $_SESSION['levelid'];
	
	$gradetxnid = $_POST['gradetxnid'];
	//$subjectname=$_POST['subjectname'];
	$fg=$_POST['fg'];
	
	//update gradetxn
	$query="UPDATE ";
	$query=$query."gradetxn SET ";
	$query=$query."finalgrade='$fg', ";
	$query=$query."editdate=NOW() ";
	$query=$query."WHERE gradetxnid=$gradetxnid";
	mysql_query($query);
?>

<html><script languange="javascript">
		alert("Grade Information has been successfully updated.");
		window.opener.location.reload();
		window.close();
	</script>
</html>
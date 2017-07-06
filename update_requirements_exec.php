<?php
	include('dbconfig.php');
	$docid=$_GET['docid'];
	$regid=$_POST['regid'];
	$name=$_POST['docname'];
	$reqtype=$_POST['reqtype'];
		$query="UPDATE requirementmaster SET regid=$regid, description='$name',reqtype=$reqtype,editdate=now() WHERE docid=$docid";
		mysql_query($query);


?>		<script type="text/javascript">
			alert('Document has been updated!');
			window.location="requirements_management.php";
		</script>
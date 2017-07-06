<?php
	include('dbconfig.php');
	if(($_GET['subjectid']=="") ||($_GET['units']==""))
	{
?>
		<script type="text/javascript">
		window.location="subject_management.php";
		</script>	
<?php
	}
	else
	{
		$subjectid=$_GET['subjectid'];
		$units=$_GET['units'];
		$query="UPDATE subjectmaster SET units='$units' WHERE subjectid=$subjectid";
		mysql_query($query);
?>
				<script type="text/javascript">
				alert('Subject has been updated!');
				window.location="subject_management.php";
				</script>	
<?php			

	}
?>
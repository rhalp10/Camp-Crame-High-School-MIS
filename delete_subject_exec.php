<?php
	include('dbconfig.php');
	
	if (empty($_GET['gradeid']) || empty($_GET['subjectid']) || $_GET['gradeid']=="" || $_GET['subjectid']=="")
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
		$gradeid=$_GET['gradeid'];
		$query="DELETE FROM subjectmaster WHERE gradeid=$gradeid AND subjectid=$subjectid";
		mysql_query($query);
?>
		<script type="text/javascript">
			alert('Subject has been successfully removed to the system.');
			window.location="subject_management.php";
		</script>
<?php
	}
?>
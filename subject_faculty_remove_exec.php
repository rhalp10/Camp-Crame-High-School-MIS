<?php
	include('dbconfig.php');
	
	if (empty($_GET['fsid']) || empty($_GET['eid']) || $_GET['fsid']=="" || $_GET['eid']=="")
	{
		if(!empty($_GET['eid']) ||  $_GET['eid']!="")
		{
?>
		<script type="text/javascript">
			window.location="subject_faculty.php?eid=<?php echo $_GET['eid']; ?> ";
		</script>
<?php
		}
		else
		{
?>
		<script type="text/javascript">
			window.location="subject_faculty.php";
		</script>
<?php		
		}
	}
	else
	{
		$fsid=$_GET['fsid'];
		$query="DELETE FROM facultysubjectmaster WHERE fsid=$fsid";
		mysql_query($query);
?>
		<script type="text/javascript">
			alert('Subject has been successfully removed.');
			window.location="subject_faculty.php?eid=<?php echo $_GET['eid']; ?> ";
		</script>
<?php
	}
?>
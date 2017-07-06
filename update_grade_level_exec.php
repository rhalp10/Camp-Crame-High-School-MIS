<?php
	include('dbconfig.php');
	
	if( (empty($_GET['id'])) || (empty($_GET['new'])))
	{
?>
	<script type="text/javascript">
		window.location="grade_level_management.php";
	</script>
<?php	
	}
	else if (($_GET['id']=="") ||($_GET['new']==""))
	{
?>
	<script type="text/javascript">
		window.location="grade_level_management.php";
	</script>
<?php			
	}
	else
	{
		$gradeid=$_GET['id'];
		$newdesc=$_GET['new'];
		
		$query="SELECT * FROM gradelevelmaster WHERE description='$newdesc'";
		$res=mysql_query($query);
		$tot=mysql_num_rows($res);
		if ($tot>0)
		{
?>
			<script type="text/javascript">
				alert('Grade Level already exists.');
				window.location="grade_level_management.php";
			</script>
<?php
		}
		else
		{
			$query="UPDATE gradelevelmaster SET description='$newdesc' WHERE gradeid=$gradeid";
			mysql_query($query);
?>
	<script type="text/javascript">
		alert('Grade level has been successfully updated.');
		window.location="grade_level_management.php";
	</script>
<?php
		}
	}
?>
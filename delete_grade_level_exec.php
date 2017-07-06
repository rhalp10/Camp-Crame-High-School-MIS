<?php
	include('dbconfig.php');
	
	if (empty($_GET['id']))
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
		$query="SELECT * FROM studentmaster WHERE gradeid=$gradeid";
		$result=mysql_query($query);
		$totalStudents=mysql_num_rows($result);
		
		if($totalStudents==0)
		{
			$query="DELETE FROM gradelevelmaster WHERE gradeid=$gradeid";
			mysql_query($query);
?>
		<script type="text/javascript">
			alert("Grade Level has been removed to the system.");
			window.location="grade_level_management.php";
		</script>

<?php
		}
		else
		{
?>
		<script type="text/javascript">
			alert("Cannot delete grade level. Some students are still enrolled using this grade level.");
			window.location="grade_level_management.php";
		</script>
<?php
		}
	}
?>
<?php
	include('dbconfig.php');
	$description=$_POST['description'];
	$query="SELECT * FROM gradelevelmaster WHERE description='$description'";
	$result=mysql_query($query);
	$total=mysql_num_rows($result);
	if ($total>0)
	{
?>
		<script type="text/javascript">
		alert("Grade Level already exists.");
		window.location="grade_level_management.php";
		</script>
<?php
	}
	else
	{
		$query="INSERT INTO gradelevelmaster(description) VALUES ('$description')";
		mysql_query($query);
?>
	<script type="text/javascript">
	alert("Grade Level has been successfully added to the system.");
	window.location="grade_level_management.php";
	</script>
<?php		
	}
?>


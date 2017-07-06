<?php
	include ('dbconfig.php');
	$gradeid=$_POST['gradeid'];
	$subjectname=$_POST['subjectname'];
	$units=$_POST['units'];
	
	$query="SELECT * FROM subjectmaster WHERE gradeid=$gradeid AND subjectname='$subjectname'";
	$result=mysql_query($query);
	$tot=mysql_num_rows($result);
	if($tot==0)
	{
		$query="INSERT INTO subjectmaster(subjectname,units,gradeid) VALUES ('$subjectname','$units',$gradeid)";
		mysql_query($query);
?>
		<script type="text/javascript">
			alert('Subject has been successfully saved.');
			window.location="subject_management.php";
		</script>	
		
<?php
	}
	else
	{
?>
		<script type="text/javascript">
			alert('Subject name already exists.');
			window.location="subject_management.php";
		</script>	
<?php
	}
?>











<?php
	include('dbconfig.php');
	$eid=$_POST['empid'];
	$subjectid=$_POST['subjectid'];
	$gradeid=$_POST['gradeid'];
	$secid = $_POST['secid'];
	
	$query="SELECT * FROM facultysubjectmaster WHERE subjectid=$subjectid AND gradeid=$gradeid AND sectionid=$secid";
	$result=mysql_query($query);
	$total=mysql_num_rows($result);
	
	if ($total>0)
	{
?>
		<script type="text/javascript">
		alert("Subject already exists.");
		window.location="subject_faculty.php?eid=<?php echo $eid; ?>";
		</script>
<?php
	}
	else
	{
		$query="INSERT INTO facultysubjectmaster(employeeid, subjectid, gradeid, sectionid) VALUES ('$eid',$subjectid,$gradeid,$secid)";
		mysql_query($query);
?>
	<script type="text/javascript">
	alert("Subject has been successfully added to the system.");
	window.location="subject_faculty.php?eid=<?php echo $eid; ?>";
	</script>
<?php		
	}
?>


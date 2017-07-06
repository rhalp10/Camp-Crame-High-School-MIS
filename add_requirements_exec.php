<?php
	include('dbconfig.php');
	$regid=$_POST['regid'];
	$name=$_POST['docname'];
	$reqtype=$_POST['reqtype'];
	$query="SELECT * FROM requirementmaster WHERE regid=$regid AND description='$name'";
	$result=mysql_query($query);
	$total=mysql_num_rows($result);
	if($total>0)
	{
?>
	<script type="text/javascript">
		alert('Document already exists!');
		window.location="requirements_management.php";
	</script>
<?php
	}
	else
	{
		$query="INSERT INTO requirementmaster (regid,description,reqtype) VALUES ($regid,'$name',$reqtype)";
		mysql_query($query);
?>
		<script type="text/javascript">
			alert('Document has been saved!');
			window.location="requirements_management.php";
		</script>
<?php
	}
?>
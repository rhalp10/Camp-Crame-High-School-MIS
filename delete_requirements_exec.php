<?php
	include('dbconfig.php');
	$docid=$_GET['docid'];
	$query="DELETE FROM requirementmaster WHERE docid=$docid";
	mysql_query($query);
?>
	<script type="text/javascript">
	alert('Document has been successully deleted to the system!');
	window.location="requirements_management.php";
	</script>

<?php
	include('dbconfig.php');
	
	if( (empty($_GET['syid'])))
	{
?>
	<script type="text/javascript">
		window.location="school_year_management.php";
	</script>
<?php	
	}
	else if (($_GET['syid']==""))
	{
?>
	<script type="text/javascript">
		window.location="school_year_management.php";
	</script>
<?php			
	}
	else 
	{
		$syid=$_GET['syid'];
		
		$query="UPDATE schoolyearmaster SET status=0,editdate=NOW()";
		mysql_query($query);
		
		$query="UPDATE schoolyearmaster SET status=1,editdate=NOW() WHERE syid=$syid";
		mysql_query($query);		
		

?>
			<script type="text/javascript">
				alert('School Year has been updated.');
				window.location="school_year_management.php";
			</script>
<?php
	}
?>
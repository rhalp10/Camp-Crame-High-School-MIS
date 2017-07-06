<?php
	include('dbconfig.php');
	
	if( (empty($_GET['syid'])) || (empty($_GET['new'])))
	{
?>
	<script type="text/javascript">
		window.location="school_year_management.php";
	</script>
<?php	
	}
	else if (($_GET['syid']=="") ||($_GET['new']==""))
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
		$newdesc=$_GET['new'];
		
		$query="SELECT * FROM schoolyearmaster WHERE syname='$newdesc'";
		$res=mysql_query($query);
		$tot=mysql_num_rows($res);
		if ($tot>0)
		{
?>
			<script type="text/javascript">
				alert('School Year already exists.');
				window.location="school_year_management.php";
			</script>
<?php
		}
		else
		{
			$query="UPDATE schoolyearmaster SET syname='$newdesc', editdate=NOW() WHERE syid=$syid";
			mysql_query($query);
?>
	<script type="text/javascript">
		alert('School Year has been successfully updated.');
		window.location="school_year_management.php";
	</script>
<?php
		}
	}
?>
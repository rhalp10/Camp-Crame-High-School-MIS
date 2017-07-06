<?php
	include('dbconfig.php');
	if(empty($_GET['gradeid']) || $_GET['gradeid'] =="" || empty($_GET['sectionid']) || $_GET['sectionid']=="" || empty($_GET['sectionname']) || $_GET['sectionname']=="" || empty($_GET['capacity']) || $_GET['capacity']=="")
	{
?>
		<script type="text/javascript">
		window.location="section_management.php";
		</script>	
<?php
	}
	else
	{
		$gradeid=$_GET['gradeid'];
		$sectionid=$_GET['sectionid'];
		$sectionname=$_GET['sectionname'];
		$capacity=$_GET['capacity'];
		$query="SELECT actualcount,section FROM sectionmaster WHERE gradeid=$gradeid AND sectionid=$sectionid";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$totalStudent=$row['actualcount'];
			$oldSectionname=$row['section'];
		}
						
		if ($totalStudent>$capacity)
		{
?>
		<script type="text/javascript">
		alert('Maximum capacity cannot handle '+<?php echo $totalStudent; ?>+' student(s) enrolled.');
		window.location="section_management.php";
		</script>	
<?php			
		}	
		else
		{
			$query="SELECT * FROM sectionmaster WHERE section='$sectionname' AND gradeid=$gradeid";
			$result=mysql_query($query);
			$totalRows=mysql_num_rows($result);
			if($totalRows==1 && $sectionname!=$oldSectionname)
			{
?>
				<script type="text/javascript">
				alert('Section name already exists.');
				window.location="section_management.php";
				</script>	
<?php							
			}
			else if($totalRows==1 && $sectionname==$oldSectionname)
			{
				$query="UPDATE sectionmaster SET section='$sectionname',maxcount=$capacity,editdate=now() WHERE gradeid=$gradeid AND sectionid=$sectionid";
				mysql_query($query);
?>
				<script type="text/javascript">
				alert('Section has been updated!');
				window.location="section_management.php";
				</script>	
<?php
			}
			else if ($totalRows==0)
			{
				$query="UPDATE sectionmaster SET section='$sectionname',maxcount=$capacity,editdate=now() WHERE gradeid=$gradeid AND sectionid=$sectionid";
				mysql_query($query);
?>
				<script type="text/javascript">
				alert('Section has been updated!');
				window.location="section_management.php";
				</script>	
<?php			
			}
		}
	}
?>
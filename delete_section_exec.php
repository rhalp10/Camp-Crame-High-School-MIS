<?php
	include('dbconfig.php');
	if(empty($_GET['gradeid']) || $_GET['gradeid'] =="" || empty($_GET['sectionid']) || $_GET['gradeid']=="")
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
		$query="SELECT * FROM studentmaster WHERE gradeid=$gradeid AND sectionid=$sectionid";
		$result=mysql_query($query);
		$totalStudent = mysql_num_rows($result);
		if($totalStudent>0)
		{
?>
			<script type="text/javascript">
			alert("Unable to remove section! Some students are still enrolled in this section.");
			window.location="section_management.php";
			</script>
<?php
		}
		else
		{
			$query="DELETE FROM sectionmaster WHERE gradeid=$gradeid AND sectionid=$sectionid";
			mysql_query($query);
?>
			<script type="text/javascript">
			alert("Section has been removed!");
			window.location="section_management.php";
			</script>
<?php
		}
	}
?>
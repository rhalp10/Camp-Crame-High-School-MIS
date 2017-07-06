<?php
	session_start();
	$gradeid = $_GET['opt'];
	$sectionid = $_POST['secid'];
	$uid = $_SESSION['uid'];

	include('dbconfig.php');
	
	
	$query="SELECT employeeid FROM facultymaster WHERE userid=$uid";
	$result=mysql_query($query);
	while($row=mysql_fetch_array($result))
	{
		$eid = $row['employeeid'];
	}

	$query="SELECT sectionid, section FROM sectionmaster WHERE sectionid IN (SELECT sectionid FROM facultysubjectmaster WHERE employeeid='$eid' AND gradeid=$gradeid group by employeeid, gradeid)";
	$res=mysql_query($query);
	$t=mysql_num_rows($res);

	
	if($t==0)
	{
	?>
		<option value="0">No section found.</option>
	<?php
	}
	
	else
	{
	while ($row=mysql_fetch_array($res))
	{
	?>
		<option value="<?php echo($row['sectionid']); ?>"><?php echo($row['section']); ?></option>
	<?php
	}
	}
?>

 


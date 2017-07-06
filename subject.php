<?php
	$opt = $_GET['opt'];
 
	include('dbconfig.php');
	$q="SELECT subjectid, subjectname from subjectmaster where gradeid=$opt";
	$res=mysql_query($q);
	$t=mysql_num_rows($res);

	
	if($t==0)
	{
	?>
		<option value="0">No subject found.</option>
	<?php
	}
	
	else
	{
	while ($row=mysql_fetch_array($res))
	{
	?>
		<option value="<?php echo($row['subjectid']); ?>"><?php echo($row['subjectname']); ?></option>
	<?php
	}
	}
?>

 


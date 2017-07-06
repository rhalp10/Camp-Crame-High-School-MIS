<?php


	$gradeid = $_GET['opt'];

	include('dbconfig.php');
	$query="SELECT * FROM sectionmaster WHERE gradeid IN($gradeid)";

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

 


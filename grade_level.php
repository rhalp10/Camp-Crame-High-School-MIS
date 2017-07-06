<?php


	$opt = $_GET['opt'];

	include('dbconfig.php');

	if($opt==1)
	{
		$query="SELECT * FROM gradelevelmaster WHERE gradeid IN(1)";
	}
	elseif ($opt==5)
	{
		$query="SELECT * FROM gradelevelmaster WHERE description not like '%SUMMER'";
	}
	else
	{
		$query="SELECT * FROM gradelevelmaster WHERE gradeid NOT IN(1)";
	}
	
	$res=mysql_query($query);
	$t=mysql_num_rows($res);

	
	if($t==0)
	{
	?>
		<option value="0">No grade level found.</option>
	<?php
	}
	
	else
	{
	while ($row=mysql_fetch_array($res))
	{
	?>
		<option value="<?php echo($row['gradeid']); ?>"><?php echo($row['description']); ?></option>
	<?php
	}
	}
?>

 


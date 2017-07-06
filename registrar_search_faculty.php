<?php



session_start();

if($_POST['term']=='')
{
	header('location:view_faculty.php');
}

else
{
	$term=$_POST['term'];
	$criteria=$_POST['criteria'];
	if($criteria=="employeeid")
	{
		$criteria="em.".$criteria;
	}
	else
	{
		$criteria="um.".$criteria;
	}
?>

<meta HTTP-EQUIV="REFRESH" content="0; url=view_faculty.php?term=<?php echo $term ?>&&criteria=<?php echo($criteria); ?>">
<?php
}
?>

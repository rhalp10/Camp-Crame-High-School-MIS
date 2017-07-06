<?php



session_start();

if($_POST['term']=='')
{
	header('location:editall_grade.php');
}

else
{
	$term=$_POST['term'];
	$lrn=$_POST['lrn'];
	$criteria=$_POST['criteria'];
	if($criteria=="subjectname")
	{
		$criteria="sbm.".$criteria;
	}
	else
	{
		$criteria="gpm.".$criteria;
	}
?>

<meta HTTP-EQUIV="REFRESH" content="0; url=editall_grade.php?term=<?php echo $term ?>&&criteria=<?php echo($criteria); ?>&&lrn=<?php echo $lrn; ?>">
<?php
}
?>

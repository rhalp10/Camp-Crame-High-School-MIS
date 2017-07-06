<?php



	session_start();

	$sortby=$_POST['sortfieldname'];
	$orderby=$_POST['sortorder'];
	if($sortby=="employeeid")
	{
		$sortby="em.".$sortby;
	}
	else
	{
		$sortby="um.".$sortby;
	}
	
?>

<meta HTTP-EQUIV="REFRESH" content="0; url=view_faculty_masterlist.php?sortby=<?php echo($sortby); ?>&&orderby=<?php echo($orderby); ?>">

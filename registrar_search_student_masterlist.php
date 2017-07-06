<?php



	session_start();

	$searchby=$_POST['fieldname'];
	$keyword=$_POST['keyword'];
	$sortby=$_POST['sortfieldname'];
	$orderby=$_POST['sortorder'];
	
	if($searchby=="gradelevel")
	{
		if($keyword=="")
		{
			header('location:view_student_masterlist.php');
		}
		else
		{
			$keyword=$keyword;
		}
	}
?>

<meta HTTP-EQUIV="REFRESH" content="0; url=view_student_masterlist.php?keyword=<?php echo $keyword ?>&&searchby=<?php echo($searchby); ?>&&sortby=<?php echo($sortby); ?>&&orderby=<?php echo($orderby); ?>">

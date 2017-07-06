<?php
	session_start();

	$searchby=$_POST['criteria'];
	$keyword=$_POST['keyword'];
	
	if($searchby=="gradeid")
	{
		if($keyword=="")
		{
			header('location:view_student_grade.php');
		}
		else
		{
			$keyword=$keyword;
		}
	}
?>

<meta HTTP-EQUIV="REFRESH" content="0; url=view_student_grade.php?keyword=<?php echo $keyword ?>&&criteria=<?php echo($searchby); ?>">

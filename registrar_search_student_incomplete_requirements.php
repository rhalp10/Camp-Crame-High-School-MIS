<?php

	session_start();

	$lrn=$_POST['lrn'];
	if($lrn=="")
	{
		header('location:view_student_incomplete_requirements.php');		
	}
	else
	{
?>

<meta HTTP-EQUIV="REFRESH" content="0; url=view_student_incomplete_requirements.php?lrn=<?php echo $lrn ?>">
<?php
	}
?>
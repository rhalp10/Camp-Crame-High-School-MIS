<?php
$uid=$_SESSION['uid'];
?>
		<a href="index_student.php">HOME</a>|
		<a href="admission_student.php">ADMISSION <?php require_once('myFunctions.php'); displayReqStat($uid,"studentmaster");?></a>|
		<a href="view_all_announcement.php">ANNOUNCEMENTS</a>|
		<?php
			$query="SELECT * FROM studentmaster WHERE userid=$uid";
			$result=mysql_query($query);
			$total=mysql_num_rows($result);
			if($total>0)
			{
		?>
		<a href="student_portal.php">STUDENT PORTAL</a>|
		<?php
			}
		?>
		<a href="account_settings.php">SETTINGS</a>|
		<a href="logout.php">LOGOUT</a>
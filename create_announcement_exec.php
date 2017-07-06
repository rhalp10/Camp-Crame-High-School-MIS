<?php
	session_start();
	include('dbconfig.php');
	if(isset($_POST['button']))
	{
		$userid=$_SESSION['uid'];
		$title=$_POST['title'];
		$what=$_POST['what'];
		$where=$_POST['where'];
		$when=$_POST['when'];
		$who=$_POST['who'];
		$expirydate=$_POST['expirydate'];
		$query="INSERT INTO announcementmaster(title,what,venue,eventdate,who,isactive,expirydate,addby) VALUES('$title','$what','$where','$when','$who',1,'$expirydate',$userid)";
		mysql_query($query);
?>
		<script type="text/javascript">
			alert('Announcement has been succesfully posted!');
			window.location="create_announcement.php";
		</script>
<?php
	}
	else
	{
?>
		<script type="text/javascript">
			window.location="create_announcement.php";
		</script>
<?php
	}
?>
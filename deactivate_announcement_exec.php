<?php
	include('dbconfig.php');
	session_start();
	$uid=$_SESSION['uid'];
	if(empty($_GET['id']) || ($_GET['id']=="" )|| empty($_GET['val']) || ($_GET['val']==""))
	{
?>
		<script type="text/javascript">
		window.location="deactivate_announcement.php";
		</script>	
<?php
	}
	else
	{
		$id=$_GET['id'];
		$val=$_GET['val'];
		if($val==2)
		{
			$val=0;
		}
		$query="UPDATE announcementmaster SET isactive='$val', editdate=now(),editby=$uid WHERE announcementid=$id";
		mysql_query($query);
?>
		<script type="text/javascript">
		alert('Announcement deactivation successful!');
		window.location="deactivate_announcement.php";
		</script>	
<?php
	}
	
?>
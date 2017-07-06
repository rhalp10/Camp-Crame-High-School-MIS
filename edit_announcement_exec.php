<?php
	session_start();
	include('dbconfig.php');
	if(isset($_POST['button']))
	{
		$uid=$_SESSION['uid'];
		$id=$_POST['id'];
		$title=$_POST['title'];
		$what=$_POST['what'];
		$where=$_POST['where'];
		$when=$_POST['when'];
		$who=$_POST['who'];
		$expiry=$_POST['expirydate'];		
		$query="UPDATE announcementmaster SET title='$title',what='$what',venue='$where',eventdate='$when',who='$who',expirydate='$expiry',editdate=now(),editby=$uid WHERE announcementid=$id";
		mysql_query($query);
?>
		<script type="text/javascript">
			alert('Announcement has been successfully updated!');
			window.location="edit_announcement_topic.php?id="+<?php echo $id; ?>;
		</script>
<?php
	}
	else 
	{
?>
		<script type="text/javascript">
			window.location="edit_announcement.php";
		</script>
<?php	
	}

?>
<?php
	session_start();
	$lrn=$_POST['lrn'];
	
	if($lrn=="")
	{
?>
	<script type="text/javascript">
	alert("LRN is missing!");
	window.location="student_account.php";
	</script>
<?php
	}
	else
	{
		$lrn=mysql_real_escape_string($lrn);
		include('dbconfig.php');
			
		$q="SELECT userid FROM studentmaster where lrn='$lrn'";
		$res=mysql_query($q);
		if(mysql_num_rows($res)==0)
		{
?>
	<script type="text/javascript">
	alert("LRN: <?php echo($lrn); ?> not found!");
	window.location="student_account.php";
	</script>
<?php
		}
		else
		{
			while($r=mysql_fetch_array($res))
			{
				$userid=$r['userid'];
			}
			$query="UPDATE usermaster SET username='$lrn',password=PASSWORD('$lrn') WHERE userid=$userid";
			mysql_query($query);
?>
	<script type="text/javascript">
	alert("LRN: <?php echo($lrn) ?> has been successfully updated!");
	window.location="student_account.php";
	</script>
<?php
		}
	}
?>
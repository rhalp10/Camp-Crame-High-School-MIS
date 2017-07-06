<?php
	session_start();
	$empno=$_POST['empno'];
	
	if($empno=="")
	{
?>
	<script type="text/javascript">
	alert("Employee Number is missing!");
	window.location="faculty_account.php";
	</script>
<?php
	}
	else
	{
		$empno=mysql_real_escape_string($empno);
		include('dbconfig.php');
			
		$q="SELECT userid FROM facultymaster where employeeid='$empno'";
		$res=mysql_query($q);
		if(mysql_num_rows($res)==0)
		{
?>
	<script type="text/javascript">
	alert("Employee No.: <?php echo($empno); ?> not found!");
	window.location="faculty_account.php";
	</script>
<?php
		}
		else
		{
			while($r=mysql_fetch_array($res))
			{
				$userid=$r['userid'];
			}
			$query="UPDATE usermaster SET username='$empno',password=PASSWORD('$empno') WHERE userid=$userid";
			mysql_query($query);
?>
	<script type="text/javascript">
	alert("Employee No.: <?php echo($empno) ?> has been successfully updated!");
	window.location="faculty_account.php";
	</script>
<?php
		}
	}
?>
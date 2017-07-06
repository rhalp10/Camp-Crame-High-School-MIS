<?php
	session_start();
	require_once('dbconfig.php');
	
	$useridToUpdate = $_POST['id'];
	$level = $_SESSION['levelid'];
	$userid = $_SESSION['userid'];

	if(isset($_POST['submit']))
	{
		if (!empty($_POST['reqs']))
		{
			$count=0;
			$i=1;
			foreach ($_POST['reqs'] as $selected)
			{
				$count=$count+1;
			}
			
			$t[]="";
			foreach ($_POST['reqs'] as $selected)
			{
				if ($i<$count)
				{
					$symb=",";
				}
				else
				{
					$symb="";
				}
				$selected=$selected.$symb;
				$t[]=$selected;
				$i=$i+1;
			}
			
			$cond="";
			for($a=1; $a<=$count; $a++)
			{
				$cond=$cond.$t[$a];
			}
			$cond="(".$cond.")";
			
			//With Requirements
			$query ="UPDATE requirementstxn SET status=1,datereceived=date(now()),receivedby=$userid WHERE userid=$useridToUpdate AND docid IN ".$cond;
			mysql_query($query);
			//echo $query."<br/>";
			//Without Requirements
			$query="UPDATE requirementstxn SET status=0,datereceived=null,receivedby='' WHERE userid=$useridToUpdate AND docid NOT IN ".$cond;
			mysql_query($query);
			//echo($query);
		}
		else
		{
			//Not chedked any
			$query="UPDATE requirementstxn SET status=0,datereceived=null,receivedby='' WHERE userid=$useridToUpdate";
			mysql_query($query);
		}
		

		//Check if studentmaster or preregmaster
		$query="SELECT * FROM studentmaster WHERE userid =$useridToUpdate";
		$result=mysql_query($query);
		$total=mysql_num_rows($result);
		if($total>0)
		{
			while($row=mysql_fetch_array($result))
			{
				$grade=$row['gradeid'];
			}
		}
		else
		{
			$query="SELECT * FROM preregmaster WHERE userid =$useridToUpdate";
			$result=mysql_query($query);	
			while($row=mysql_fetch_array($result))
			{
				$grade=$row['gradeid'];
			}			
		}
		
		//Count the total number of submitted requirements.
		$query="SELECT COUNT(rm.reqtype) as totalStat FROM requirementstxn AS rt, requirementmaster AS rm WHERE rt.docid = rm.docid AND rm.reqtype=1 AND rt.status=1 AND rt.userid =$useridToUpdate AND rt.regid=$grade";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$totalSubmitted = $row['totalStat'];
		}
		
		//Count the total number of requirements.
		$query="SELECT COUNT(rm.reqtype) as totalReqs FROM requirementstxn AS rt, requirementmaster AS rm WHERE rt.docid = rm.docid AND rm.reqtype=1 AND rt.userid =$useridToUpdate AND rt.regid=$grade";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$totalRequired = $row['totalReqs'];
		}
		

	}
?>

<?php
	if($totalSubmitted==$totalRequired)
	{
		//Enrolled na.
?>
	<script type="text/javascript">
	alert("Requirements has been completed!");
	window.location="enrollment_proper.php?id=<?php echo($useridToUpdate); ?>"
	</script>
<?php
	}
	else
	{
		//Incomplete Requirements.
?>
	<script type="text/javascript">
	alert("Requirements has been successfully updated!");
	window.location="enrollment_update_prereg.php?id=<?php echo($useridToUpdate); ?>"
	</script>
<?php
	}
?>


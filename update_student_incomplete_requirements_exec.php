<?php
	session_start();
	require_once('dbconfig.php');
	
	$lrn = $_POST['id'];
	$level = $_SESSION['levelid'];
	$userid = $_SESSION['userid'];

	$q="SELECT userid FROM studentmaster WHERE lrn='$lrn'";
	$res=mysql_query($q);
	while($r=mysql_fetch_array($res))
	{
		$useridToUpdate=$r['userid'];
	}

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
			$query ="UPDATE requirementstxn SET status=1,datereceived=date(now()),receivedby=$userid WHERE userid=$useridToUpdate AND status=0 AND docid IN ".$cond;
			mysql_query($query);
			
			//Without Requirements
			$query="UPDATE requirementstxn SET status=0,datereceived=null,receivedby='' WHERE userid=$useridToUpdate AND status=0 AND docid  NOT IN ".$cond;
			mysql_query($query);
		}
		else
		{
			//Not checked any.
			$query="UPDATE requirementstxn SET status=0,datereceived=null,receivedby='' WHERE userid=$useridToUpdate AND status=0";
			mysql_query($query);
		}

		//Count the total number of submitted requirements.
		$query="SELECT COUNT(rm.reqtype) as totalStat FROM requirementstxn AS rt, requirementmaster AS rm WHERE rt.docid = rm.docid AND rm.reqtype=0 AND rt.status=1 AND rt.userid =$useridToUpdate";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$totalSubmitted = $row['totalStat'];
		}
		
		//Count the total number of requirements.
		$query="SELECT COUNT(rm.reqtype) as totalReqs FROM requirementstxn AS rt, requirementmaster AS rm WHERE rt.docid = rm.docid AND rm.reqtype=0 AND rt.userid =$useridToUpdate";
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
	window.location="view_student_incomplete_requirements.php"
	</script>
<?php
	}
	else
	{
		//Incomplete Requirements.
?>
	<script type="text/javascript">
	alert("Requirements has been successfully updated!");
	window.location="update_student_incomplete_requirements.php?id=<?php echo($lrn); ?>"
	</script>
<?php
	}
?>


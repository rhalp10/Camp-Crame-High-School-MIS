<?php
	include('dbconfig.php');
	session_start();
	$gradeid=$_POST['gradeid'];
	$lrn=$_POST['lrn'];
	
	$q="SELECT sectionid FROM studentmaster WHERE lrn='$lrn'";
	$res=mysql_query($q);
	while($rrs=mysql_fetch_array($res))
	{
		$oldsectionid=$rrs['sectionid'];
	}
	
	$query="UPDATE sectionmaster SET actualcount=actualcount-1, editdate=NOW() WHERE sectionid=$oldsectionid";
	mysql_query($query);
	
	$query="UPDATE studentmaster SET gradeid=$gradeid, sectionid=0, editdate=now() WHERE lrn='$lrn'";
	mysql_query($query);
	
	$q="SELECT registrationid,sectionid FROM studentmaster WHERE lrn='$lrn'";
	$result=mysql_query($q);
	while($row=mysql_fetch_array($result))
	{
		$rr=$row['registrationid'];
	}
	
	
	$query="SELECT sm.userid, rm.* FROM studentmaster as sm, requirementmaster as rm WHERE  sm.registrationid=rm.regid AND sm.lrn='$lrn'";
	$result=mysql_query($query);
	while ($row=mysql_fetch_array($result))
	{
		$uid=$row['userid'];
		$docid=$row['docid'];
		$status=0;
		$query="INSERT INTO requirementstxn (userid,docid,status,regid) VALUES ($uid,$docid,$status,$gradeid)";
		mysql_query($query);
	}
?>
			<script type="text/javascript">
			alert("Student account has been successfully updated.");
			window.location="summer_enrollment.php"
			</script>
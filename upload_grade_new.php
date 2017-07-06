<?php
	session_start();
	include('dbconfig.php');
	$eid=$_SESSION['uid'];
	$subjectid=$_POST['subjectid'];
	$periodid=$_POST['periodid'];	
	$gradeid=$_POST['gradeid'];	
	$fgArr = array();
	$fgArr=$_POST['fg'];
	$lrnArr = array();
	$lrnArr=$_POST['lrn'];
	$count=count($lrnArr);
	$query="SELECT syid FROM schoolyearmaster WHERE status=1";
	$result=mysql_query($query);
	while($row=mysql_fetch_array($result))
	{
		$syid=$row['syid'];
	}
	for ($i=0; $i<=$count-1; $i++)
	{
		$query="DELETE FROM gradetxn WHERE lrn='$lrnArr[$i]' AND subjectid=$subjectid AND syid=$syid AND gradeid=$gradeid AND gradingperiod=$periodid AND uploadedby=$eid";
		mysql_query($query);
		
		$sql ="INSERT INTO gradetxn(lrn,subjectid,gradeid,syid,gradingperiod,finalgrade,uploadedby) VALUES ('$lrnArr[$i]',$subjectid,$gradeid,$syid,$periodid,'$fgArr[$i]',$eid)";
		mysql_query($sql);
	}
?>
	<script type="text/javascript">
		alert('Grades has been successfully uploaded.');
		window.location="upload_grade.php";
	</script>		
<?php		
	
?>
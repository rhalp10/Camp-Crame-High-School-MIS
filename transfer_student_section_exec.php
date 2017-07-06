<?php
	$lrn=$_POST['lrn'];
	$newSectionid=$_POST['sectionid'];
	
	include('dbconfig.php');
	
	//Get old section id.
	$q="SELECT sectionid, gradeid FROM studentmaster WHERE lrn='$lrn'";
	$res=mysql_query($q);
	while($r=mysql_fetch_array($res))
	{
		$oldSectionid=$r['sectionid'];
		$gradeid=$r['gradeid'];
	}

	//Update studentmaster sectionid.
	$query="UPDATE studentmaster SET sectionid=$newSectionid, editdate=(SELECT now()) WHERE lrn='$lrn'";
	mysql_query($query);
	//echo $query."<br>";
	
	//Update section master. 
	//Subtract 1 to old sectionid.
	$query="UPDATE sectionmaster SET editdate=(SELECT now()), actualcount=actualcount-1 WHERE gradeid=$gradeid AND sectionid=$oldSectionid";
	mysql_query($query);
	//echo $query."<br>";
	
	//Update sectionmaster.
	//Add 1 to new section id.
	$query="UPDATE sectionmaster SET editdate=(SELECT now()), actualcount=actualcount+1 WHERE gradeid=$gradeid AND sectionid=$newSectionid";
	mysql_query($query);
	//echo $query;
?>
	<script type="text/javascript">
	alert("Student has been successfully transfered!");
	window.location="transfer_student_section.php?id=<?php echo($lrn); ?>"
	</script>


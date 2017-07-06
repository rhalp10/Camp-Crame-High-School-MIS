<?php
	include('dbconfig.php');
	
	
	
	$query="SELECT userid, gradeid FROM studentmaster";

	$result=mysql_query($query);
	while($row=mysql_fetch_array($result))
	{
		$gradeidOld="";
		$new="";
		$gradeidOld = $row['gradeid'];
		if($gradeidOld=='1')
		{	
			$new='2';
		}
		else if($gradeidOld=='2')
		{
			$new='3';
		}
		else if($gradeidOld=='3')
		{
			$new='4';
		}
		else if($gradeidOld=='4')
		{
			$new='5';
		}
		else if($gradeidOld=='5')
		{
			$new='6';
		}
		else if($gradeidOld=='7')
		{
			$new='2';
		}
		else if($gradeidOld=='8')
		{
			$new='3';
		}
		else if($gradeidOld=='9')
		{
			$new='4';
		}
		else if($gradeidOld=='10')
		{
			$new='5';
		}
		else
		{
			exit();
		}
		
		$userid="";
		$userid=$row['userid'];
		$qq="SELECT levelid FROM usermaster WHERE userid=$userid";
		$rr=mysql_query($qq);
		while($roro=mysql_fetch_array($rr))
		{
			$levelid1=$roro['levelid'];
		}
		$newgrade=$new;
		
			//Update Studentmaster
			
		$query="UPDATE studentmaster SET gradeid=$new, sectionid=0, editdate=now() WHERE userid=$userid";
		mysql_query($query);		
			
		$q="SELECT * FROM requirementmaster WHERE regid=$levelid1";
		$res=mysql_query($q);
		while($r=mysql_fetch_array($res))
		{
			$docid=$r['docid'];
			$qq="INSERT INTO requirementstxn (regid,userid,docid,status) VALUES ($newgrade,$userid,$docid,0)";
			mysql_query($qq);
		}
		

	}
	

	
	//Update section
	
	$query="UPDATE sectionmaster SET actualcount=0, editdate=now()";
	mysql_query($query);	


?>
			<script type="text/javascript">
			alert("Accounts has been successfully updated.");
			window.location="tools.php"
			</script>
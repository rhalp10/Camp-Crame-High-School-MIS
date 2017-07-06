<?php
session_start();
require_once('myFunctions.php'); 
$lrn=$_POST['lrn'];
$day=date("j").date("S");
$m=date("F");

require_once('config.php');
$query="SELECT um.fname, um.mname, um.lname FROM usermaster as um,  studentmaster  as sm where um.userid=sm.userid AND sm.lrn='$lrn'";
$result=mysql_query($query);
$total=mysql_num_rows($result);
if($total==0)
{
}
else
{
	while($row=mysql_fetch_array($result))
	{
		$studentname = $row['fname']." ".$row['mname']." ".$row['lname'];
	}
	
	$q="SELECT syname FROM schoolyearmaster WHERE status=1";
	$res=mysql_query($q);
	while($R=mysql_fetch_array($res))
	{
		$sy=$R['syname'];
	}
	
	createGoodMoral($studentname,$day,$m,$sy);

}


?>
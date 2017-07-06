<?php
session_start();
?>
<?php
	if(isset($_SESSION['username']))
	{
		$user=$_SESSION['username'];
		$pass=$_SESSION['password'];
		$level=$_SESSION['levelid'];
	}
	else
	{
?>
	<script type="text/javascript">
		//window.location="index.php";
		<?php header("location:index.php"); ?>
		alert("Please login first to access this page.");
	</script>
<?php
	exit();
	}

	//faculty
	if ($level==3)
	{
		include("dbconfig.php");
		$result=mysql_query("SELECT * FROM usermaster WHERE username ='".$user."' AND password=PASSWORD('".$pass."')");
		while($row=mysql_fetch_array($result))
		{
			if($row['isactive']==1)
			{
				$uid=$row['userid'];
				$_SESSION['uid']=$uid;
				$fname=$row['fname'];
				$mname=$row['mname'];
				$lname=$row['lname'];
				$pic="uploads/".$row['pic'];
				$fullname=$fname." ".$lname;
				$_SESSION['uploadid']=$uid;
			}
			else
			{
?>
			<script type="text/javascript">
				//window.location="index.php";
				<?php header("location:index.php"); ?>
				alert("Sorry but your account is no longer active Please contact your administrator immediately.");
			</script>
<?php
			session_destroy();
			}
		}
	}
	//guest
	elseif ($level==1)
	{
?>
	<script type="text/javascript">
		//window.location="index_student.php";
		<?php header("location:index_guest.php"); ?>
	</script>
<?php
	}
	//registrar
	elseif ($level==4)
	{
?>
	<script type="text/javascript">
		//window.location="index_faculty.php";
		<?php header("location:index_registrar.php"); ?>
	</script>
<?php
	}
	//student
	elseif ($level==2)
	{
?>
	<script type="text/javascript">
		//window.location="index_registrar.php";
		<?php header("location:index_student.php"); ?>
	</script>
<?php
	}
	else
	{
?>
	<script type="text/javascript">
		//window.location="index.php";
		<?php header("location:index.php"); ?>
		alert("Please login first to access this page.");
	</script>
<?php
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>CAMP CRAME HIGH SCHOOL</title>
	<link href="css/view_grade.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		function mhover(obj,txt){
			obj.src =txt;
		}
		function mout(obj,txt){
			obj.src =txt;
		}
	</script>

</head>

<body id="aaa">
<?php 
	if((!isset($_POST['gradeid']))||($_POST['subjectid']==0)||($_POST['secid']==0)||($_POST['periodid']==0))
	{
?>
		<script type="text/javascript">
			window.location="upload_grade.php";
		</script>		
<?php
	}
	else
	{
	include('dbconfig.php');
	$gradeid=$_POST['gradeid'];
	$subjectid=$_POST['subjectid'];
	$periodid=$_POST['periodid'];
	$secid=$_POST['secid'];
	
	$query="SELECT section FROM sectionmaster WHERE sectionid=$secid";
	$result=mysql_query($query);
	while($row=mysql_fetch_array($result))
	{
		$sectionname=$row['section'];
	}
	
	$q="SELECT description FROM gradelevelmaster WHERE gradeid=$gradeid";
	$res=mysql_query($q);
	while($row=mysql_fetch_array($res))
	{
		$gl=$row['description'];
	}

	$q="SELECT subjectname FROM subjectmaster WHERE subjectid=$subjectid";
	$res=mysql_query($q);
	while($row=mysql_fetch_array($res))
	{
		$sn=$row['subjectname'];
	}
	

	$q="SELECT * FROM gradingperiodmaster WHERE periodid=$periodid";
	$res=mysql_query($q);
	while($r=mysql_fetch_array($res))
	{
		$gp=$r['description'];
	}
	
	$q="SELECT * FROM schoolyearmaster WHERE status=1";
	$res=mysql_query($q);
	while($r=mysql_fetch_array($res))
	{
		$syid=$r['syid'];
	}
?>
			
	<div class="registerBody" style="left:-250px;" > 
		<br/>
			<table class="curvedEdges" width="500" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
				<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Upload Details</font></strong></div></td>
				<tr>
					<td width="100">Section Name:</td><td><?php echo $sectionname; ?></td>
				</tr>
				<tr>
					<td width="100">Subject Name:</td><td><?php echo $sn; ?></td>
				</tr>
				<tr>
					<td>Grade Level:</td><td><?php echo $gl; ?></td>
				</tr>
				<tr>
					<td>Grading Period:</td><td><?php echo $gp." Grading Period"; ?></td>
				</tr>
			</table>
		<br/>
		<form action="upload_grade_new.php" method="POST">
		<?php require_once('myFunctions.php'); displayStudentInputGrade($gradeid,$secid,$subjectid,$periodid,$syid); ?>
		<input type="hidden" name="gradeid" value="<?php echo $gradeid; ?>">
		<input type="hidden" name="subjectid" value="<?php echo $subjectid; ?>">
		<input type="hidden" name="periodid" value="<?php echo $periodid; ?>">
		<input type="hidden" name="syid" value="<?php echo $syid; ?>">
		</form>
<?php
}
?>
	</div>
</body>
</html>

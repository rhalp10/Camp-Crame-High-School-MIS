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
	if((!isset($_POST['gradeid']))||($_POST['subjectid']==0)||($_POST['periodid']==0)||($_POST['syid']==0))
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
	$syid=$_POST['syid'];
	$gradeid=$_POST['gradeid'];
	$subjectid=$_POST['subjectid'];
	$periodid=$_POST['periodid'];
	
	$query="SELECT syname FROM schoolyearmaster WHERE syid=$syid";
	$result=mysql_query($query);
	while($row=mysql_fetch_array($result))
	{
		$syname=$row['syname'];
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
	
	$filename=$_FILES["uploaded_file"]["tmp_name"];
	$f=date("mdYh").time();
	$foldername="cchsmis";
	if (!is_dir("C:/".$foldername))
	{
		mkdir("C:/".$foldername);
	}
	$targetPath="C:/".$foldername."/".$_FILES["uploaded_file"]["name"];	
	
	//COPY($filename,$_FILES["uploaded_file"]["name"].".csv");
	copy($filename,$targetPath);
	if($_FILES["uploaded_file"]["size"] > 0)
	{
?>
			
	<div class="registerBody" style="left:-250px;" > 
		<br/>
			<table class="curvedEdges" width="500" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
				<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Upload Details</font></strong></div></td>
				<tr>
					<td width="100">School Year:</td><td><?php echo $syname; ?></td>
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
		<form action="upload_grade_exec.php" method="post">
		<input type="hidden" name="gradeid" value="<?php echo $gradeid; ?>">
		<input type="hidden" name="subjectid" value="<?php echo $subjectid; ?>">
		<input type="hidden" name="periodid" value="<?php echo $periodid; ?>">
		<input type="hidden" name="syid" value="<?php echo $syid; ?>">
		<input type="hidden" name="filename" value="<?php echo $targetPath;?>">
		<table class="curvedEdges" width="980" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
			<td colspan=14 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF"><?php echo $_FILES["uploaded_file"]["name"]." "; ?> Contents:</font></strong></div></td>
				<tr>
					<th>LRN</th>
					<th>Assignment</th>
					<th>% Rate</th>
					<th>Attendance</th>
					<th>% Rate</th>
					<th>Project</th>
					<th>% Rate</th>
					<th>Quiz</th>
					<th>% Rate</th>
					<th>Exam</th>
					<th>% Rate</th>
					<th>Extra Curricular</th>
					<th>% Rate</th>
				</tr>
<?php
				$file = fopen($filename, "r");
				$heading=true;
				while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
				{
					if($heading)
					{
						$heading=false;
						continue;
					}
?>
						<tr>
							<td align="center"><?php echo($emapData[0]); ?></td>
							<td align="center"><?php echo($emapData[1]); ?></td>
							<td align="center"><?php echo($emapData[2]); ?></td>
							<td align="center"><?php echo($emapData[3]); ?></td>
							<td align="center"><?php echo($emapData[4]); ?></td>
							<td align="center"><?php echo($emapData[5]); ?></td>
							<td align="center"><?php echo($emapData[6]); ?></td>
							<td align="center"><?php echo($emapData[7]); ?></td>
							<td align="center"><?php echo($emapData[8]); ?></td>
							<td align="center"><?php echo($emapData[9]); ?></td>
							<td align="center"><?php echo($emapData[10]); ?></td>
							<td align="center"><?php echo($emapData[11]); ?></td>
							<td align="center"><?php echo($emapData[12]); ?></td>
						</tr>
<?php			
				}

			fclose($file);
	?>
		<tr><td align="right" colspan=14><input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Upload" onclick="return confirm('Are you sure you want to upload the grades?'); ">&nbsp;&nbsp;&nbsp;<a href="upload_grade.php"><input style="width: 60px; height: 30px;" type="button" name="cancel" value="Cancel"></a></td></tr>
		</table>
		</form>
	<?php
	}
	else
	{
?>
		<script type="text/javascript">
			alert('Invalid CSV File! Please try again.');
			window.location="upload_grade.php";
		</script>		
<?php
	}
	}
?>
	</div>
</body>
</html>

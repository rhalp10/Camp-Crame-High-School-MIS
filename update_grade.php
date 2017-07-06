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

	//Faculty //Registrar
	if (($level==3) || ($level==4))
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
	//Guest
	elseif ($level==1)
	{
?>
	<script type="text/javascript">
		//window.location="index_faculty.php";
		<?php header("location:index_guest.php"); ?>
	</script>
<?php
	}
	//Student
	elseif ($level==4)
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
	<link href="css/css.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		function mhover(obj,txt){
			obj.src =txt;
		}
		function mout(obj,txt){
			obj.src =txt;
		}
	</script>

		<script language='javascript'>
			function checkForm(f)
				{
					if	(f.elements['project'].value == "" )
					{
						alert("Project value is missing!");
						f.elements['project'].focus();
						return false;
					}
					
					else if (f.elements['quiz'].value == "" )
					{
						alert("Quiz value is missing!");
						f.elements['quiz'].focus();
						return false;
					}
					else if	(f.elements['assignment'].value == "" )
					{
						alert("Assignment value is missing!");
						f.elements['assignment'].focus();
						return false;
					}
					else if	(f.elements['attendance'].value == "" )
					{
						alert("Attendance value is missing!");
						f.elements['attendance'].focus();
						return false;
					}
					else if	(f.elements['projectpercent'].value == "" )
					{
						alert("Project Percent value is missing!");
						f.elements['projectpercent'].focus();
						return false;
					}
					else if	(f.elements['assignmentpercent'].value == "" )
					{
						alert("Assignment Percent value is missing!");
						f.elements['assignmentpercent'].focus();
						return false;
					}
					else if	(f.elements['attendancepercent'].value == "" )
					{
						alert("Attendance Percent value is missing!");
						f.elements['attendancepercent'].focus();
						return false;
					}
					else if	(f.elements['quizpercent'].value == "" )
					{
						alert("Quiz Percent");
						f.elements['quizpercent'].focus();
						return false;
					}
					else if	(f.elements['exam'].value == "" )
					{
						alert("Exam value is missing!");
						f.elements['exam'].focus();
						return false;
					}
					else if	(f.elements['exampercent'].value == "" )
					{
						alert("Exam Percent value is missing!");
						f.elements['exampercent'].focus();
						return false;
					}
					else if	(f.elements['extracurricular'].value == "" )
					{
						alert("Extra Curricular value is missing!");
						f.elements['extracurricularr'].focus();
						return false;
					}
					else if	(f.elements['extracurricularpercent'].value == "" )
					{
						alert("Extra Curricular Percent value is missing!");
						f.elements['extracurricularpercent'].focus();
						return false;
					}
					else
					{
						f.submit();
						return false;
					}
				}
		</script>
</head>

<body>

<?php 
require_once('dbconfig.php');

$tblname="";

if($level==1) //Guest
{
	$tblname="preregmaster";
}
else if($level==2) //Student
{
	$tblname="studentmaster";
}
else
{
	$tblname="facultymaster";
}
$gradetxnid=$_GET['gradetxnid'];
$query="SELECT * FROM `gradetxn` as gtn 
				left outer join subjectmaster as sm
				on gtn.subjectid = sm.subjectid where gtn.gradetxnid =$gradetxnid";
$result=mysql_query($query);
while($row=mysql_fetch_array($result))
{
	$subjectname=$row['subjectname'];
	$fg=$row['finalgrade'];
}
?>
					<div class="windowBody" style="left:-250px;" > 
						<br>						
						<h1>Update Personal Information</h1>
						<br>
						<form enctype="multipart/form-data" action="update_grade_exec.php" method="POST" onSubmit="return checkForm(this); return false;">
							<table class="curvedEdges" align="center" width="480" border="0">
								<tr>
									<td bgcolor="maroon" colspan="2"><font color="#FFFFFF">Please fill-up all necessary information below:</font></td>
								</tr>
								<tr>
									<td>Subject :</td>
									<td width="386">
										<?php echo($subjectname); ?>
									</td>
								</tr>
								 <tr>
									<td width="179">Final Grade :</td>
									<td width="386"><input autofocus  name="fg" type="text" placeholder="Project" size="35" value="<?php echo($fg); ?> "/></td>
								</tr>	
							  <tr>
									<td colspan="2">
									  <div align="center">
										  <input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Update">
										  <input type = "hidden" name = "gradetxnid" value = "<?php echo $gradetxnid;?>" >
									  </div>
									</label></td>
								</tr>
				</table>
						</form>

</body>
</html>

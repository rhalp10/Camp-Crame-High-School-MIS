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
	if ($level==4)
	{
		include("dbconfig.php");
		$result=mysql_query("SELECT * FROM usermaster WHERE username ='".$user."' AND password='".$pass."'");
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
	//guest
	elseif ($level==1)
	{
?>
	<script type="text/javascript">
		//window.location="index_student.php";
		<?php header("location:index_student.php"); ?>
	</script>
<?php
	}
	//registrar
	elseif ($level==3)
	{
?>
	<script type="text/javascript">
		//window.location="index_faculty.php";
		<?php header("location:index_faculty.php"); ?>
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
	<br/>
	<form action="search_criteria_grade.php" method="POST" onSubmit="return checkForm(this); return false;" >
	<input type="hidden" name="lrn" value="<?php echo $_GET['lrn']; ?>">
							<table class="curvedEdges" width="410" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
								<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Criteria</font></strong></div></td>
								<tr>
									<td>Search By:</td>
									<td>
										<select autofocus name="criteria">
											<option value="subjectname">Subject</option>
											<option value="description">Grading Period</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Keyword:</td>
									<td><input type="text" name="term" placeholder="Enter keyword here..." size="40px"></td>
								</tr>
								<tr>
									<td colspan=2 align="right"><input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Find">&nbsp;&nbsp;&nbsp;<?php $lrn=$_GET['lrn']; ?><a href="editall_grade.php?lrn=<?php echo $lrn; ?>"><input style="width: 60px; height: 30px;" type="button" name="showall" value="Show All"></a>&nbsp;&nbsp;&nbsp;<input style="width: 60px; height: 30px;" type="reset" name="reset" id="reset" value="Clear"></td>
								</tr>
							</table>
							<br>
						</form>	
	<?php require_once('myFunctions.php'); displayStudentViewAllGrade($_SESSION['uid'],$_GET['lrn']) ?>
	<br>
	<a href="edit_grade.php" class="myLinks"><< Go Back</a>
	</div>
</body>
</html>

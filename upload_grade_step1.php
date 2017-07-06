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
	//Registrar
	elseif ($level==4)
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
	<link href="css/css.css" rel="stylesheet" type="text/css">
	<!-- THIS ESSENTIAL IN PLAYING FLASH -->
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/javascript">
		function mhover(obj,txt){
			obj.src =txt;
		}
		function mout(obj,txt){
			obj.src =txt;
		}
	</script>
	<script language='javascript'>
	function checkControl(f)
	{
		if (f.elements['controlnum'].value == "" )
		{
			alert("Control Number is missing!");
			f.elements['controlnum'].focus();
			return false;
		}
		else
		{
			f.submit();
			return false;
		}
	}
	</script>	
 <script type="text/javascript">
   function update(str)
   {
      var xmlhttp;
 
      if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }	
 
      xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          document.getElementById("data").innerHTML = xmlhttp.responseText;
        }
      }
 
      xmlhttp.open("GET","section_grade_level.php?opt="+str, true);
      xmlhttp.send();
  }
</script>	
 <script type="text/javascript">
   function update1(str)
   {
      var xmlhttp;
 
      if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }	
 
      xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
          document.getElementById("data").innerHTML = xmlhttp.responseText;
        }
      }
 
      xmlhttp.open("GET","subject_grade_level.php?opt="+str;, true);
      xmlhttp.send();
  }
</script>	
	<style>
		.firstcharacter { float: left; color: #903; font-size: 50px; line-height: 35px; padding-top: 4px; padding-right: 8px; padding-left: 3px; font-family: Georgia; }
	</style>
</head>

<body>

<!-- CONTAINER OF DIV'S -->
<div class="container">
	
	<!-- HEADER -->
	<div class="header">
	</div>
	
	<!-- NAVIGATOR -->
	<div class="navigator" align="center">
		<?php include 'includes/mainNav_faculty.php'; ?>
	</div>
	
	<!-- MARQUEE INFO -->
	<div class="marqueeInfo">
		<?php include 'includes/Navmarquee.txt'; ?>
	</div>
	
	<!-- TEXT CONTAINER -->
	<div class="bodycontainer">
		<!-- Another div here for info-->
		
				<?php
					display_form();
				
					function display_form()
					{
						global $errors;
				?>
				<!-- CONTENTS -->
	  			<div class="Contents">
					<div style="position:relative; left:20px;"> 
						<br>			
						<h1>Upload Grade</h1>
						<br>
						<form enctype="multipart/form-data" action="grade_input.php" method="POST">
							<table class="curvedEdges" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
								<input type="hidden" name="gradeid" value="<?php echo $_POST['gradeid']; ?>">
								<input type="hidden" name="secid" value="<?php echo $_POST['secid']; ?>">
								<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Select Subject and CSV File</font></strong></div></td>
									<tr>
									<td>School Year:</td><td><?php require_once('myFunctions.php'); displayCurrentSY(); ?></td>
								</tr>	
								<tr>
									<td>Grade Level:</td><td><?php require_once('myFunctions.php'); echo "Grade ";  displayCurrentGL($_POST['gradeid']); ?></td>
								</tr>	
								<tr>
									<td>Section:</td><td><?php require_once('myFunctions.php'); displayCurrentSec($_POST['gradeid'],$_POST['secid']); ?></td>
								</tr>									
								<tr>
									<td>Subject:</td><td><select autofocus name="subjectid"><?php require_once('myFunctions.php'); displaySubjectsFaculty($_SESSION['uid'],$_POST['gradeid'],$_POST['secid']); ?></select></td>
								</tr>								
								<tr>
									<td>Grading Period:</td><td><select name="periodid"><?php require_once('myFunctions.php'); displayGradingPeriod(); ?></select></td>
								</tr>
								<tr>
									<td colspan=2 align="right"><a href="upload_grade.php"><input style="width: 60px; height: 30px;" type="button" name="button" id="button" value="Back"></a>&nbsp;&nbsp;&nbsp;<input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Go">&nbsp;&nbsp;&nbsp;<input style="width: 60px; height: 30px;" type="reset" name="reset" id="reset" value="Clear"></td>
								</tr>
							</table>
						</form>
					<br>
					
					<a href="grading_system.php" class="myLinks"><< Go Back</a>
					</div>
					</div>
				<?php
					}
				?>
		
		<div class="RightBox" align="center">
				
		<?php 
			echo "<img src='".$pic."' width='162' height='178' border='2'>";  
		?>
		<br>
			<div class="inName">
				<strong><?php echo($fullname); ?></strong>
			</div>
			<br>
		  	<div  style="position:relative; left:1px;">
				<table class="sideBox" height=243 width=165 border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
				<td colspan=2 height=25 bgcolor="#333333"><div align="center"><strong><font color="#FFFFFF"><img src="images/calendar.ico"/>&nbsp;&nbsp;Today</font></strong></div></td>
				<tr>
				<th colspan=2 align="center"><?php echo (date("F d, Y - l")); ?></th>
				</tr>
				<td colspan=2 height=25 bgcolor="#333333"><div align="center"><strong><font color="#FFFFFF"><img src="images/clock.ico"/>&nbsp;&nbsp;Last Login</font></strong></div></td>
				<tr>
					<th colspan=2 align="center"><?php require_once('myFunctions.php'); displayLastLoginDate($_SESSION['uid']);  ?></th>
				</tr>				
				</table>
		  	</div>
  	  </div>
	</div>
	
	
	<!-- FOOTER NAV-->
	<div class="footerNav" align="center" >
		<?php include 'includes/footernav_faculty.php'; ?>
	</div>
	
	<!-- FOOTER -->
	<div class="footer" align="center" >
		Copyright © Camp Crame High School All Rights Reserved 2014.
	</div>
	
</div>

</body>
</html>

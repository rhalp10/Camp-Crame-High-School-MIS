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

	//registrar
	if ($level==4)
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
	//Faculty
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
	<link href="css/css.css" rel="stylesheet" type="text/css">
	 <script src="js/jquery.js" type="text/javascript"></script>
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
	function checkForm(f)
	{
		if (f.elements['term'].value == "" )
		{
			alert("Please enter the keyword to find.");
			f.elements['term'].focus();
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
	 
		  xmlhttp.open("GET","section.php?opt="+str, true);
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
		<?php include 'includes/mainNav_registrar.php'; ?>
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
					<div style="position:relative; left:25px;">
						<br>			
						<h1>Subject Masterlist</h1>
						<br>
						<form action="add_faculty_subject.php" method="POST" onSubmit="return checkForm(this); return false;" >
							<input type="hidden" name="empid" value="<?php echo $_GET['eid']; ?>">
							<table class="curvedEdges" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
								<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Add Subject</font></strong></div></td>
								<tr>
									<td>Grade:</td>
									<td><select autofocus onchange="update(this.value)" name="gradeid"><?php require_once("myFunctions.php"); displayGradeLevels(); ?></select></td>
								</tr>
								<tr>
									<td>Section:</td>
									<td><select name="secid" id="data"><?php require_once("myFunctions.php"); displaySectionInitial(); ?></select></td>
								</tr>	
								<tr>
									<td>Subject:</td><td><select name="subjectid"><?php require_once('myFunctions.php'); displaySubjectUpload(); ?></select></td>
								</tr>								
								<tr>
									<td colspan=2 align="right"><input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Add">&nbsp;&nbsp;&nbsp;<input style="width: 60px; height: 30px;" type="reset" name="reset" id="reset" value="Clear"></td>
								</tr>
							</table>
							<br>
						</form>							
						<?php $eid=$_GET['eid']; require_once('myFunctions.php'); displayFacultySubjectsMasterList($eid);?>
						<br>
						<a href="view_faculty_masterlist.php" class="myLinks"><< Go Back</a>
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
				<?php echo($fullname); ?>
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
		<?php include 'includes/footernav_registrar.php'; ?>
	</div>
	
	<!-- FOOTER -->
	<div class="footer" align="center" >
		Copyright © Camp Crame High School All Rights Reserved 2014.
	</div>
	
</div>

</body>
</html>

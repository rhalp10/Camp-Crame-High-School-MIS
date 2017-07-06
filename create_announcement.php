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
	if ($level==4 || $level==3)
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
	<script language='javascript'>
	function checkForm(f)
	{
		if (f.elements['title'].value == "" )
		{
			alert("Announcement Title is missing!");
			f.elements['title'].focus();
			return false;
		}
		else if	(f.elements['what'].value == "" )
		{
			alert("What field is missing!");
			f.elements['what'].focus();
			return false;
		}
		else if	(f.elements['where'].value == "" )
		{
			alert("Where field is missing!");
			f.elements['where'].focus();
			return false;
		}
		else if	(f.elements['when'].value == "" )
		{
			alert("When field is missing!");
			f.elements['when'].focus();
			return false;
		}
		else if	(f.elements['who'].value == "" )
		{
			alert("Who field is missing!");
			f.elements['who'].focus();
			return false;
		}
		else if	(f.elements['expirydate'].value == "" )
		{
			alert("Date of Deactivation is missing!");
			f.elements['expirydate'].focus();
			return false;
		}
 		else
		{
			f.submit();
			return false;
		}
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
		<?php if($level==4){include 'includes/mainNav_registrar.php';} else {include 'includes/mainNav_faculty.php';} ?>
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
						<h1>Create Announcement</h1>
						<br>
						<form method="post" action="create_announcement_exec.php" onSubmit="return checkForm(this); return false;">
						<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
							<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Announcement Details</font></strong></div></td>			
							<tr>
								<td>Title:</td><td><input autofocus type="text" name="title" size="65" placeholder="Announcement Title"></td>
							</tr>
							<tr>
								<td>What:</td><td><input type="text" name="what" size="65" placeholder="What is the Announcement all about?"></td>
							</tr>
							<tr>
								<td>Where:</td><td><input type="text" name="where" size="65" placeholder="Where it will be held?"></td>
							</tr>
							<tr>
								<td>When:</td><td><input type="date" name="when"></td>
							</tr>
							<tr>
								<td>Who:</td><td><input type="text" name="who" size="65" placeholder="Who are the participants?"></td>
							</tr>
							<tr>
								<td>Deactivation Date:</td><td><input type="date" name="expirydate"></td>
							</tr>
							<tr>
								<td colspan=2 align="right"><input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Save">&nbsp;&nbsp;&nbsp;<input type="reset" value="Clear" style="width: 60px; height: 30px;"></td>
							</tr>
						</table>
						</form>
						<br/>
					<a class="myLinks" href="announcement.php"><< Go Back</a>
					</div>
					<br>
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
		<?php if($level==4){include 'includes/footernav_registrar.php';} else {include 'includes/footernav_faculty.php';} ?>
	</div>
	
	<!-- FOOTER -->
	<div class="footer" align="center" >
		Copyright © Camp Crame High School All Rights Reserved 2014.
	</div>
	
</div>

</body>
</html>

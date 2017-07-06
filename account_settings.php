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

	//Guest //Student
	if (($level==1) || ($level==2) || ($level==5))
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
	else if($level==3)
	{
?>
	<script type="text/javascript">
		//window.location="index.php";
		<?php header("location:index_faculty.php"); ?>
		alert("Please login first to access this page.");
	</script>
<?php	
	}
	else if($level==4)
	{
?>
	<script type="text/javascript">
		//window.location="index.php";
		<?php header("location:index_registrar.php"); ?>
		alert("Please login first to access this page.");
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
		<?php 
		if($level==1 || $level==5)
		{		
			include 'includes/mainNav_Guest.txt'; 
		}
		else if($level==2)
		{
			include 'includes/mainNav_student.php'; 
		}
		?>
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
						<h1>My Portfolio</h1>
						<br/>
						<table class="curvedEdges" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
						<td bgcolor="#FF6633" align="center" colspan=2><div align="center"><strong><font color="#FFFFFF">Settings</font></strong></div></td>
						<tr>
							<th>Details</th>
							<th>Action</th>
						</tr>
						<tr>
							<td width="310">Personal Information</td><td  width="310" align="center"><img height=10 src="images/modify.ico"/>&nbsp;&nbsp;<a  class="myLinks" href="update_personalinfo.php?userid=<?php echo($_SESSION['userid']);?>" onclick="window.open(this.href, '_blank', 'left=0,top=0,toolbar=1,resizable=0,width=500,height=660'); return false;">Edit</a></td>
						</tr>
						<tr>
							<td>Account Information</td><td align="center"><img height=10 src="images/modify.ico"/>&nbsp;&nbsp;<a class="myLinks" href="update_accountinfo.php?userid=<?php echo($_SESSION['userid']);?>" onclick="window.open(this.href, '_blank', 'left=0,top=0,toolbar=1,resizable=0,width=500,height=660'); return false;">Edit</a></td>
						</tr>
						</table>
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
		<?php 
		if($level==1 || $level==5)
		{		
			include 'includes/footernav_Guest.txt'; 
		}
		else if($level==2)
		{
			include 'includes/footernav_student.php'; 
		}
		?>		
	</div>
	
	<!-- FOOTER -->
	<div class="footer" align="center" >
		Copyright © Camp Crame High School All Rights Reserved 2014.
	</div>
	
</div>

</body>
</html>

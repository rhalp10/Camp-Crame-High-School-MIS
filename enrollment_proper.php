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
				if($_GET['id']=="")
				{
					header("location:admission_registrar.php");
				}
				else
				{
					$uid=$row['userid'];
					$_SESSION['uid']=$uid;
					$fname=$row['fname'];
					$mname=$row['mname'];
					$lname=$row['lname'];
					$pic="uploads/".$row['pic'];
					$fullname=$fname." ".$lname;
				}
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
	function checkForm(f)
	{
		var lrn = f.elements['LRN'].value;
		var lrnLen = lrn.length;	
		
		if (f.elements['LRN'].value == "" )
		{
			alert("LRN is missing!");
			f.elements['LRN'].focus();
			return false;
		}
		else if (lrnLen != 12 )
		{
			alert("LRN must be 12 characters!");
			f.elements['LRN'].focus();
			return false;
		}
		else
		{
			f.submit();
			return false;
		}
	}
	</script>	
	<!-- para numbers lang ang tanngapin-->
	 <script type="text/javascript">
	function isNumericKey(e)
	{
		if (window.event) { var charCode = window.event.keyCode; }
		else if (e) { var charCode = e.which; }
		else { return true; }
		if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; }
		return true;
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
						<h1><?php require_once('myFunctions.php'); displayPreregInfo($_GET['id']); ?></h1>
						<br>
						To complete the enrollment process, please fill-up the following:
						<br><br>
						<form method="POST" action="enrollment_proper_exec.php" onSubmit="return checkForm(this); return false;">
							<table class="curvedEdges" border="1" width=620 cellpadding="0" cellspacing="0" bordercolor="#FF6633">
							<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">STEP 1</font></strong></div></td>
								<tr>
									<td>LRN :</td>
									<?php
										$id=$_GET['id'];		
										$lrnval="";
										$query="SELECT * FROM studentmaster WHERE userid=$id";
										$result=mysql_query($query);
										$total=mysql_num_rows($result);
										if($total>0)
										{
											while($row=mysql_fetch_array($result))
											{
												$lrnval = $row['lrn'];
											}
										}
										else
										{
											$lrnval="";
										}
									
									?>
									<td><input autofocus maxlength=12  value="<?php echo $lrnval; ?>" type="text" onKeyPress="return isNumericKey(event);" name="LRN" placeholder="Learner's Reference No." size="73" /></td>
								</tr>							
							</table>
							<br>
							<table class="curvedEdges" border="1" width=620 cellpadding="0" cellspacing="0" bordercolor="#FF6633">
							<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">STEP 2</font></strong></div></td>
								<tr>
									<td align="center" >Option</td><td align="center" >Section</td><td align="center">Max</td><td align="center">Actual</td><td align="center">Vacant</td>
								</tr>							
								<?php require_once('myFunctions.php'); displaySection($_GET['id']); ?>
							</table>
							<br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="hidden" name="preregid" value="<?php echo($_GET['id']); ?>">
							<input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Finish">
						</form>

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

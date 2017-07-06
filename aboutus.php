<?php
session_start();
?>
<?php
	if(isset($_SESSION['username']))
	{
		$user=$_SESSION['username'];
		$pass=$_SESSION['password'];
		$level=$_SESSION['levelid'];
	if($level==1) //Guest
	{
?>
	<script type="text/javascript">
		window.location="index_guest.php";
	</script>	
<?php
	}
	elseif ($level==2) //Student
	{
?>
	<script type="text/javascript">
		window.location="index_student.php";
	</script>	
<?php
	}
	elseif ($level==3) //Faculty
	{
?>
	<script type="text/javascript">
		window.location="index_faculty.php";
	</script>	
<?php
	}
	elseif ($level==4) //Registrar
	{
?>
	<script type="text/javascript">
		window.location="index_registrar.php";
	</script>	
<?php
	}
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
		if (f.elements['user'].value == "" )
		{
			alert("Username is missing!");
			f.elements['user'].focus();
			return false;
		}
		else if	(f.elements['pass'].value == "" )
		{
			alert("Password is missing!");
			f.elements['pass'].focus();
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
		<?php include 'includes/mainNav.txt'; ?>
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
	  			<div class="ContentsIndex">
					<div style="width:240px; height:400px; float:left; ">
						<form method="post" action="login_exec.php" onSubmit="return checkForm(this); return false;">
						<br/>
						<table  width="200" height="128" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td bgcolor="#880000" colspan="2" align="center" width="168"><strong><font face="Arial" size="3" color="#FFFFFF" >Member Login</font><strong></td>
							</tr>
                        	<td>&nbsp;</td>
                      		<tr>
								<td>&nbsp;</td>
								<td colspan ="2">&nbsp;&nbsp;&nbsp;Username:</td>
                      		</tr>
                      		<tr>
								<td>&nbsp;</td>
                        		<td  colspan ="2">&nbsp;&nbsp;&nbsp;<input autofocus type="text" name="user"></td>
                      		</tr>
							<td>&nbsp;</td>
                      		<tr>
                        		<td>&nbsp;</td>
                        		<td colspan ="2">&nbsp;&nbsp;&nbsp;Password:</td>
                      		</tr>
                      		<tr>
                        		<td>&nbsp;</td>
                        		<td colspan ="2">&nbsp;&nbsp;&nbsp;<input type="password" name="pass"></td>
                      		</tr>
							<td>&nbsp;</td>
							<tr>
                        		<td>&nbsp;</td>
                        		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="width: 60px; height: 30px;" type="submit" name="submit" value="Login">&nbsp;&nbsp;&nbsp;<input type="reset" value="Clear" style="width: 60px; height: 30px;"></td>                      		</tr>
					  		<tr>
                        		<td>&nbsp;</td>
                      		</tr>
                    	</table>
						<br/>					
						</form>	
	
						<br/>
						<table  width="200" height="128" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td bgcolor="#880000" colspan="2" align="center" width="168"><strong><font face="Arial" size="-0.5" color="#FFFFFF" >Related Links</font></strong></td>
							</tr>
                        	<td>&nbsp;</td>
                      		<tr>
								<td>&nbsp;</td>
								<td align="justify" colspan ="2"><a href="history.php" class="myLinks"><img src="images/star.jpg" height="12" width="18">History</td>
                      		</tr>
                      		<tr>
								<td>&nbsp;</td>
								<td  align="justify" colspan ="2"><a href="facilities.php" class="myLinks"><img src="images/star.jpg" height="12" width="18">Facilities</td>
                      		</tr>
                      		<tr>
								<td>&nbsp;</td>
								<td  align="justify" colspan ="2"><a href="offerings.php" class="myLinks"><img src="images/star.jpg" height="12" width="18">Offerings</td>
                      		</tr>  
							</table>
						<br/>					
					</div>
					
					<div style="left:-250px;"> 
						<br>						
						<h1>The Developers</h1>
						<br>
						<img src="about_us/henry.jpg" border=1 width="128" height="128"  align="left">
						<br/>
						<p align="justify">
							<span class="firstcharacter">H</span> enry R. Rogacion: 
							is a fourth year BS Information Technology student at Cavite State University - Main Campus. He currently resides at Brgy. Guyam Malaki, Indang, Cavite.							
						</p>
						<br/><br/><br/><br/>
						<img src="about_us/gian.jpg" border=1 width="128" height="128"  align="right">
						<br/><br/><br/>
						<p align="justify">
							<span class="firstcharacter">G</span> ian Paul Rotairo: 
							is a fourth year BS Information Technology student at Cavite State University - Main Campus. He currently resides at Brgy. Guyam Malaki, Indang, Cavite.
						</p>

					</div>
		  		</div>
				<?php
					}
				?>

	</div>
	
	<!-- FOOTER NAV-->
	<div class="footerNav" align="center" >
		<?php include 'includes/footernav.txt'; ?>
	</div>
	
	<!-- FOOTER -->
	<div class="footer" align="center" >
		Copyright © Camp Crame High School All Rights Reserved 2014.
	</div>
	
</div>

</body>
</html>

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
					var pass = f.elements['passkey1'].value;
					var passLen = pass.length;
					var emp = f.elements['empno'].value;
					var empLen = emp.length;					
					if	(f.elements['regid'].value == "" )
					{
						alert("Invalid Registration Type!");
						f.elements['regid'].focus();
						return false;
					}
					
					else if	(f.elements['empno'].value == "" )
					{
						alert("Employee Number is missing!");
						f.elements['empno'].focus();
						return false;
					}

					else if	(empLen != 7 )
					{
						alert("Employee Number must be 7 characters!");
						f.elements['empno'].focus();
						return false;
					}
					
					else if (f.elements['fname'].value == "" )
					{
						alert("First Name is missing!");
						f.elements['fname'].focus();
						return false;
					}
					else if	(f.elements['mname'].value == "" )
					{
						alert("Middle Name is missing!");
						f.elements['mname'].focus();
						return false;
					}
					else if	(f.elements['lname'].value == "" )
					{
						alert("Last Name is missing!");
						f.elements['lname'].focus();
						return false;
					}
					else if	(f.elements['bmonth'].value == "" )
					{
						alert("Invalid Birthday!");
						f.elements['bmonth'].focus();
						return false;
					}
					else if	(f.elements['bday'].value == "" )
					{
						alert("Invalid Birthday!");
						f.elements['bmonth'].focus();
						return false;
					}
					else if	(f.elements['byear'].value == "" )
					{
						alert("Invalid Birthday!");
						f.elements['byear'].focus();
						return false;
					}
					else if	(f.elements['bplace'].value == "" )
					{
						alert("Birthplace is missing!");
						f.elements['bplace'].focus();
						return false;
					}
					else if	(f.elements['contactno'].value == "" )
					{
						alert("Contact Number is missing!");
						f.elements['contactno'].focus();
						return false;
					}
					else if	(f.elements['eadd'].value == "" )
					{
						alert("Email Address is missing!");
						f.elements['eadd'].focus();
						return false;
					}
					else if	(f.elements['radd'].value == "" )
					{
						alert("Address is missing!");
						f.elements['radd'].focus();
						return false;
					}
					else if	(f.elements['uname'].value == "" )
					{
						alert("Username is missing!");
						f.elements['uname'].focus();
						return false;
					}
					else if	(f.elements['passkey1'].value == "" )
					{
						alert("Password is missing!");
						f.elements['passkey1'].focus();
						return false;
					}					
					else if	(f.elements['passkey2'].value == "" )
					{
						alert("Please retype your password again!");
						f.elements['passkey2'].focus();
						return false;
					}
					else if	(f.elements['passkey1'].value != f.elements['passkey2'].value )
					{
						alert("Password and Retyped password did not match. Please try again!");
						f.elements['passkey2'].focus();
						return false;
					}
					else if	(passLen<6 )
					{
						alert("Password must be atleast 6 characters.");
						f.elements['passkey1'].focus();
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
					<div class="registerFacultyBody" style="left:-250px;"> 
					<div style="position:relative; left:25px;">
						<br>			
						<h1>Faculty Registration Form</h1>
						<br>
						<form enctype="multipart/form-data" action="faculty_create_account_exec.php" method="POST" onSubmit="return checkForm(this); return false;">
							<table class="curvedEdges" align="center" width="620" border="0">
								<tr>
									<td bgcolor="#FF6633" colspan="2"><font color="#FFFFFF">Please fill-up all necessary information below:</font></td>
								</tr>
								<tr>
									<td>Type:</td>
									<td>
										Teacher
										<input type="hidden" name="regid" value="3">
									</td>
								</tr
								<tr>
									<td>Employee No.:</td>
									<td><input  name="empno" onKeyPress="return isNumericKey(event);" type="text" placeholder="Employee Number" size="65" maxlength=7 /></td>
								</tr>
								<tr>
									<td>First Name:</td>
									<td><input  name="fname" type="text" placeholder="First Name" size="65" /></td>
								</tr>
								<tr>
									<td>Middle Name:</td>
									<td><input  name="mname" type="text" placeholder="Middle Name" size="65" /></td>
								</tr>
								<tr>
									<td>Last Name:</td>
									<td><input  name="lname" type="text" placeholder="Last Name" size="65" /></td>
								</tr>
								<tr>
									<td>Birthday:</td>
									<td><select name="bmonth" id="month">
									  <?php if ($bmonth==1){?>
									  <option selected value="1">January</option>
									  <?php }?>
									  <?php if ($bmonth==2){?>
									  <option selected value="2">February</option>
									  <?php }?>
									  <?php if ($bmonth==3){?>
									  <option selected value="3">March</option>
									  <?php }?>
									  <?php if ($bmonth==4){?>
									  <option selected value="4">April</option>
									  <?php }?>
									  <?php if ($bmonth==5){?>
									  <option selected value="5">May</option>
									  <?php }?>
									  <?php if ($bmonth==6){?>
									  <option selected value="6">June</option>
									  <?php }?>
									  <?php if ($bmonth==7){?>
									  <option selected value="7">July</option>
									  <?php }?>
									  <?php if ($bmonth==8){?>
									  <option selected value="8">August</option>
									  <?php }?>
									  <?php if ($bmonth==9){?>
									  <option selected value="9">September</option>
									  <?php }?>
									  <?php if ($bmonth==10){?>
									  <option selected value="10">October</option>
									  <?php }?>
									  <?php if ($bmonth==11){?>
									  <option selected value="11">November</option>
									  <?php }?>
									  <?php if ($bmonth==12){?>
									  <option selected value="12">December</option>
									  <?php }?>
									  <option></option>
									  <option value="1">January</option>
									  <option value="2">February</option>
									  <option value="3">March</option>
									  <option value="4">April</option>
									  <option value="5">May</option>
									  <option value="6">June</option>
									  <option value="7">July</option>
									  <option value="8">August</option>
									  <option value="9">September</option>
									  <option value="10">October</option>
									  <option value="11">November</option>
									  <option value="12">December</option>
									</select>
									  <select name="bday" id="day">
										<option></option>
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
										<option>13</option>
										<option>14</option>
										<option>15</option>
										<option>16</option>
										<option>17</option>
										<option>18</option>
										<option>19</option>
										<option>20</option>
										<option>21</option>
										<option>22</option>
										<option>23</option>
										<option>24</option>
										<option>25</option>
										<option>26</option>
										<option>27</option>
										<option>28</option>
										<option>29</option>
										<option>30</option>
										<option>31</option>
									</select>
									  <select name="byear" id="years">
										<option></option>
										<option>1960</option>
										<option>1961</option>
										<option>1962</option>
										<option>1963</option>
										<option>1964</option>
										<option>1965</option>
										<option>1966</option>
										<option>1967</option>
										<option>1968</option>
										<option>1969</option>
										<option>1970</option>
										<option>1971</option>
										<option>1972</option>
										<option>1973</option>
										<option>1974</option>
										<option>1975</option>
										<option>1976</option>
										<option>1977</option>
										<option>1978</option>
										<option>1979</option>
										<option>1980</option>
										<option>1981</option>
										<option>1982</option>
										<option>1983</option>
										<option>1984</option>
										<option>1985</option>
										<option>1986</option>
										<option>1987</option>
										<option>1988</option>
										<option>1989</option>
										<option>1990</option>
										<option>1991</option>
										<option>1992</option>
										<option>1993</option>
										<option>1994</option>
										<option>1995</option>
										<option>1996</option>
										<option>1997</option>
										<option>1998</option>
										<option>1999</option>
										<option>2000</option>
										<option>2001</option>
										<option>2002</option>
										<option>2003</option>
										<option>2004</option>
										<option>2005</option>
										<option>2006</option>
										<option>2007</option>
										<option>2008</option>
										<option>2009</option>
										<option>2010</option>
										<option>2011</option>
										<option>2012</option>
									</select>
								</td>
							</tr>
								<tr>
									<td >Birthplace :</td>
									<td><input type="text" name="bplace" placeholder="Birthplace"size="65" /></td>
								</tr>
								<tr>
									<td>Gender :</td>
									<td>
										<input type="radio" name="gender" checked id="radio" value=0>
										<label for="radio">Male &nbsp;
										<input type="radio" name="gender" id="radio2" value=1>
										Female</label>
									</td>
							    </tr>
								<tr>
									<td>Contact No. :</td>
									<td><input type="text" onKeyPress="return isNumericKey(event);" name="contactno" placeholder="Contact Number" maxlength="11" size="65" /></td>
								</tr>
								<td>Email Address :</td>
									<td><input type="email" name="eadd" placeholder="E-mail Address" size="65" /></td>
								</tr>
								<tr>
									<td>Address :</td>
									<td><input type="text" name="radd" placeholder="Residential Address" size="65" /></td>
								</tr>	
								<tr>
									<td>Username :</td>
									<td><input type="text" name="uname" placeholder="Username"size="65" /></td>
								</tr>	
								<tr>
									<td>Password :</td>
									<td><input type="password" name="passkey1" placeholder="Password" size="65" /></td>
								</tr>	
								<tr>
									<td>Retype :</td>
									<td><input type="password" name="passkey2" placeholder="Retype Password" size="65" /></td>
								</tr>	
							    <tr>
									<td>Profile Picture: </td>
									<td><input type="file" name="uploaded_file" accept="image/*"></td>
							    </tr>

							  <tr>
									<td colspan="2">
									  <div align="center">
										  <input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Save">
										  <input style="width: 60px; height: 30px;" type="reset" name="reset" id="reset" value="Clear">
									  </div>
									</label></td>
								</tr>
 							</table>
						</form>
					</div>
					</div>
		  		</div>
				<?php
					}
				?>
		
		<div class="RegisterFacultyRightBox" align="center">
				
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
	<br><br><br><br><br><br><br><br><br><br>
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

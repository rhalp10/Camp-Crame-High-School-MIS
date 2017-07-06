<?php
session_start();
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
					if	(f.elements['regid'].value == "" )
					{
						alert("Invalid Registration Type!");
						f.elements['regid'].focus();
						return false;
					}
					
					else if	(f.elements['gradeid'].value == "" )
					{
						alert("Invalid Grade Level!");
						f.elements['gradeid'].focus();
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
					else if	(f.elements['mother'].value == "" )
					{
						alert("Mothers Name is missing!");
						f.elements['mother'].focus();
						return false;
					}
					else if	(f.elements['motherocc'].value == "" )
					{
						alert("Mothers Occupation is missing!");
						f.elements['motherocc'].focus();
						return false;
					}
					else if	(f.elements['father'].value == "" )
					{
						alert("Father's name is missing!");
						f.elements['father'].focus();
						return false;
					}
					else if	(f.elements['fatherocc'].value == "" )
					{
						alert("Father's Occupation is missing!");
						f.elements['fatherocc'].focus();
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
					else if	(f.elements['schname'].value == "" )
					{
						alert("Last School Attended is missing!");
						f.elements['schname'].focus();
						return false;
					}
					else if	(f.elements['schadd'].value == "" )
					{
						alert("School Address is missing!");
						f.elements['byear'].focus();
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
		<script type = "text/javascript">
		function reveal() {
		var p = document.getElementById("regid").value;
		if (p == 1) {
			document.getElementById("gradeid").value="1"
			document.getElementById("gradeid").disabled="true"
			}
		else {
			document.getElementById("gradeid").disabled=""
			}
		}
		</script>
	<script language='javascript'>
	function checkLogin(f)
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
	 
		  xmlhttp.open("GET","grade_level.php?opt="+str, true);
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
	  			<div class="Contents">
					<div class="registerBody" style="left:-250px;"> 
					<div style="position:relative; left:25px;">
						<br>						
						<h1>Account Registration Form</h1>
						<br>
						<form enctype="multipart/form-data" action="register_exec.php" method="POST" onSubmit="return checkForm(this); return false;">
							<table class="curvedEdges" align="center" width="800" border="0">
								<tr>
									<td bgcolor="maroon" colspan="2"><font color="#FFFFFF">Please fill-up all necessary information below:</font></td>
								</tr>
								<tr>
									<td>Type :</td>
									<td><select autofocus onchange="update(this.value)" name ="regid" id="regid"><?php require_once("myFunctions.php"); displayRegistrationType(); ?></select></td>
								</tr>
								<tr>
									<td>Grade :</td>
									<td><select name="gradeid" id="data"  ><?php require_once("myFunctions.php"); displayGradeLevelReg(); ?></select></td>
								</tr>								<tr>
									<td>First Name :</td>
									<td><input  name="fname" type="text" placeholder="First Name" size="90" /></td>
								</tr>	
								<tr>
									<td>Middle Name :</td>
									<td><input type="text" name="mname" placeholder="Middle Name" size="90" /></td>
								</tr>	
								<tr>
									<td>Last Name :</td>
									<td><input type="text" name="lname" placeholder="Last Name" size="90" /></td>
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
									<td>Birthplace :</td>
									<td><input type="text" name="bplace" placeholder="Birthplace"size="90" /></td>
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
									<td>Mother :</td>
									<td><input type="text" name="mother" placeholder="Mother's Name"size="90" /></td>
								</tr>								<tr>
								<tr>
									<td>Occupation :</td>
									<td><input type="text" name="motherocc" placeholder="Mother's Occupation" size="90" /></td>
								</tr>								<tr>
								<tr>
									<td>Father :</td>
									<td><input type="text" name="father" placeholder="Father's Name"size="90" /></td>
								</tr>								<tr>
								<tr>
									<td>Occupation :</td>
									<td><input type="text" name="fatherocc" placeholder="Fathers's Occupation" size="90" /></td>
								</tr>
								<tr>
									<td>Contact No. :</td>
									<td><input type="text"  onKeyPress="return isNumericKey(event);" name="contactno" placeholder="Contact Number" maxlength="11" size="90" /></td>
								</tr>
								<td>Email Address :</td>
									<td><input type="email" name="eadd" placeholder="E-mail Address" size="90" /></td>
								</tr>
								<tr>
									<td>Address :</td>
									<td><input type="text" name="radd" placeholder="Residential Address" size="90" /></td>
								</tr>	
								<tr>
									<td>Last School Attended :</td>
									<td><input type="text" name="schname" placeholder="Last School Attended" size="90" /></td>
								</tr>	
								<tr>
									<td>Address :</td>
									<td><input type="text" name="schadd" placeholder="School Address" size="90" /></td>
								</tr>	
								<tr>
									<td>Username :</td>
									<td><input type="text" name="uname" placeholder="Username"size="90" /></td>
								</tr>	
								<tr>
									<td>Password :</td>
									<td><input type="password" name="passkey1" placeholder="Password" size="90" /></td>
								</tr>	
								<tr>
									<td>Retype :</td>
									<td><input type="password" name="passkey2" placeholder="Retype Password" size="90" /></td>
								</tr>	
							    <tr>
									<td>Profile Picture: </td>
									<td><input type="file" name="uploaded_file" accept="image/*"></td>
							    </tr>

							  <tr>
									<td colspan="2">
									  <div align="right">
										  <input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Save">
										  <a href="register.php"><input style="width: 60px; height: 30px;" type="button" name="reset" id="reset" value="Clear"></a>
									  </div>
									</label></td>
								</tr>
				</table>
						</form>
					</div></div>
		  		</div>
				<?php
					}
				?>

	</div>
	
	<!-- FOOTER NAV-->
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
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

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
					<div style="position:relative; left:-50px;">
						<br>						
						<center><h1>CCHS Facilities</h1></center>
						<br><br><br>
						<div align="center">
							<table width="800" height="190" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="20000"><div align="center"><img src="facilities/headquarters.jpg" width="300" height="300" title="Faculty"></div> <div align="center">Camp Crame Headquarters</div></td>								
									<td width="-20000"><div align="center"><img src="facilities/school.jpg" width="300" height="300" title="Student"></div> <div align="center">Camp Crame High School Building</div></td>								
																	
								</tr>	
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td width="20000"><div align="center"><img src="facilities/stage.jpg" width="300" height="300" title="Faculty"></div> <div align="center">Camp Crame High School Stage</div></td>								
									<td width="-20000"><div align="center"><img src="facilities/logo.jpg" width="300" height="300" title="Student"></div> <div align="center">Camp Crame High School Logo</div></td>								
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
												
								</table>
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

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
		function updateSubject(docid)
		{
			var newName=prompt('Enter new Subject Name:','');
			if (newName==null)
			{				
				return false;
			}
			else
			{
				if (newName!="")
				{
					var units=prompt('No. of Units:','');
					if (units==null)
					{
						return false;
					}
					else
					{
						if(units!="")
						{
							var ans=confirm('Are you sure you want to update this?');
							if(ans==true)
							{
								window.location="update_subject_exec.php?gradeid="+gradeId+"&&subjectid="+subjectid+"&&subjectname="+newName+"&&units="+units;
							}
							else
							{
								return false;
							}
						}
						else
						{
							return false;
						}
						
					}
				}
				else
				{
					return false;
				}
			}
		}
	</script>
	<script language='javascript'>
	function checkForm(f)
	{
		if (f.elements['docname'].value == "" )
		{
			alert("Please enter Document Name.");
			f.elements['docname'].focus();
			return false;
		}		
		else 
		{
			f.submit();
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
						<h1>Edit Requirements</h1>
						<br>
						<?php 
							$docid=$_GET['docid'];
							$query="SELECT * FROM requirementmaster WHERE docid=$docid";
							$result=mysql_query($query);
							while($row=mysql_fetch_array($result))
							{
								$regid=$row['regid'];
								$desc=$row['description'];
								$reqtype=$row['reqtype'];
							}
						
						
						
						?>						
						
						<form action="update_requirements_exec.php?docid=<?php echo $docid; ?>" method="POST" onSubmit="return checkForm(this); return false;" >
							<table class="curvedEdges" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
								<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Update Document</font></strong></div></td>
								<tr>
									<td>Registration Type:</td>
									<td><select autofocus name="regid" id="regid" ><?php require_once("myFunctions.php"); displayRequirementsSettings($regid); ?></select></td>
								</tr>
								<tr>
									<td>Name:</td>
									<td><input type="text" placeholder="Enter Document Name here..." name="docname" size="60" value="<?php echo $desc; ?>"></td>
								</tr>
								<tr>
									<td>Type:</td>
									<td >
										<select name="reqtype">
											<?php if($reqtype==1) { echo "selected"; } echo "<option value=1>Mandatory</option>";?>
											<?php if($reqtype==0) { echo "selected"; } echo "<option value=0>Optional</option>";?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan=2 align="right"><input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Update">&nbsp;&nbsp;&nbsp;<input style="width: 60px; height: 30px;" type="reset" name="reset" id="reset" value="Clear"></td>
								</tr>
							</table>
							</form>	

						<br><br>
						<a href="requirements_management.php" class="myLinks"><< Go Back</a>
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
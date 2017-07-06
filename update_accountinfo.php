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
	if (($level==1) || ($level==2) || ($level==3) || ($level==4) || ($level==5)) 
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

<?php 
require_once('dbconfig.php');
$userid=$_GET['userid'];
$query="SELECT * FROM usermaster WHERE userid='$userid'";
$result=mysql_query($query);
while($row=mysql_fetch_array($result))
{
	$username=$row['username'];
	$old=$row['password'];
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
					var pass = f.elements['np1'].value;
					var passLen = pass.length;
					if	(f.elements['uname'].value == "" )
					{
						alert("Please enter your username!");
						f.elements['uname'].focus();
						return false;
					}
					else if	(f.elements['old'].value == "" )
					{
						alert("Please enter your old password!");
						f.elements['old'].focus();
						return false;
					}
					else if	(f.elements['old'].value != "<?php echo($old);?>" )
					{
						alert("Invalid Old password!");
						f.elements['old'].focus();
						return false;
					}
					else if	(f.elements['np1'].value == "" )
					{
						alert("Please enter your new password!");
						f.elements['np1'].focus();
						return false;
					}
					else if	(f.elements['np2'].value == "" )
					{
						alert("Please Retype your new password!");
						f.elements['np2'].focus();
						return false;
					}
					else if	(f.elements['np1'].value != f.elements['np2'].value )
					{
						alert("Password and Retyped password did not match. Please try again!");
						f.elements['np2'].focus();
						return false;
					}
					else if	(passLen<6 )
					{
						alert("New Password must be atleast 6 characters.");
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
</head>

<body>

			
					<div class="registerBody" style="left:-250px;" > 
						<br/>						
						<h1>Update Account Information</h1>
						<br/>
						<form action="update_accountinfo_exec.php" method="POST" onSubmit="return checkForm(this); return false;">
							<table class="curvedEdges" align="center" width="410" border="0">
								<tr>
									<td bgcolor="maroon" colspan="2"><font color="#FFFFFF">Please fill-up all necessary information below:</font></td>
								</tr>
								<tr>
									<td width="500">Username :</td>
									<td><input autofocus type="label" name="uname" placeholder="Username" size="35" value="<?php echo($username); ?>"/></td>
								</tr>	
								<tr>
									<td width="500">Old Password :</td>
									<td><input type="password" name="old" placeholder="Old Password" size="35" /></td>
								</tr>	
								<tr>
									<td width="500">New Password :</td>
									<td><input type="password" name="np1" placeholder="New Password" size="35" /></td>
								</tr>	
								<tr>
									<td width="500">Retype :</td>
									<td><input type="password" name="np2" placeholder="Retype Password" size="35" /></td>
								</tr>	
							  <tr>
									<td colspan="2">
									  <div align="center">
										  <input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Update">
									  </div>
									</label></td>
								</tr>
							</table>
						</form>
					</div>

</body>
</html>

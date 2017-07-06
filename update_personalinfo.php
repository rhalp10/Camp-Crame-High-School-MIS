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
	if (($level==1) || ($level==2)|| ($level==5))
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
	//Registrar
	elseif ($level==4)
	{
?>
	<script type="text/javascript">
		//window.location="index_registrar.php";
		<?php header("location:index_registrar.php"); ?>
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
						f.elements['schadd'].focus();
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
</head>

<body>

<?php 
require_once('dbconfig.php');

$tblname="";
$userid=$_GET['userid'];
$query="SELECT * FROM preregmaster WHERE userid=$userid";
$result=mysql_query($query);
$totalPre = mysql_num_rows($result);

if($totalPre>0)
{
	$tblname="preregmaster";
}
else
{
	$tblname="studentmaster";
}





$query="SELECT um.*, pm.*, month(pm.birthday) as bmonth, day(pm.birthday) as bday, year(pm.birthday) as byear FROM usermaster as um, $tblname as pm WHERE um.userid=pm.userid AND um.userid='$userid'";
$result=mysql_query($query);
while($row=mysql_fetch_array($result))
{
	$fname=$row['fname'];
	$mname=$row['mname'];
	$lname=$row['lname'];
	$bplace=$row['birthplace'];
	$mother=$row['mother'];
	$motherocc=$row['motherocc'];
	$father=$row['father'];
	$fatherocc=$row['fatherocc'];
	$cellno=$row['cellno'];
	$eadd=$row['email'];
	$radd=$row['address'];	
	$last=$row['lastschoolattended'];
	$schadd=$row['schooladdress'];
	$bmonth=$row['bmonth'];
	$bday=$row['bday'];
	$byear=$row['byear'];
	$sex=$row['sex'];
	$pic=$row['pic'];
	$regid=$row['levelid'];
	$gradeid=$row['gradeid'];
}
?>
					<div class="windowBody" style="left:-250px;" > 
						<br>						
						<h1>Update Personal Information</h1>
						<br>
						<form enctype="multipart/form-data" action="update_personalinfo_exec.php" method="POST" onSubmit="return checkForm(this); return false;">
							<table class="curvedEdges" align="center" width="410" border="0">
								<tr>
									<td bgcolor="maroon" colspan="2"><font color="#FFFFFF">Please fill-up all necessary information below:</font></td>
								</tr>
								<tr>
									<td>Grade :</td>
									<td width="386">
									<?php
										require_once('dbconfig.php');
										$q="SELECT description FROM gradelevelmaster where gradeid=$gradeid";
										$res=mysql_query($q);
										while($row=mysql_fetch_array($res))
										{
											$gg=$row['description'];
										}
										echo $gg; 
									?>
									</td>
								</tr>
								<input type="hidden" name="gradeid" value="<?php echo $gradeid; ?>">
								<tr>
									<td width="179">First Name :</td>
									<td width="386"><input  name="fname" type="text" placeholder="First Name" size="35" value="<?php echo($fname); ?> "/></td>
								</tr>	
								<tr>
									<td width="500">Middle Name :</td>
									<td><input type="text" name="mname" placeholder="Middle Name" size="35"  value="<?php echo($mname); ?> "/></td>
								</tr>	
								<tr>
									<td width="500">Last Name :</td>
									<td><input type="text" name="lname" placeholder="Last Name" size="35"  value="<?php echo($lname); ?>" /></td>
								</tr>	
								<tr>
									<td>Birthday:</td>
									<td><select name="bmonth" id="month">
									  <option <?php if($bmonth==1){ echo("selected");} ?>  value="1">January</option>
									  <option <?php if($bmonth==2){ echo("selected");} ?>  value="2">February</option>
									  <option <?php if($bmonth==3){ echo("selected");} ?>  value="3">March</option>
									  <option <?php if($bmonth==4){ echo("selected");} ?>  value="4">April</option>
									  <option <?php if($bmonth==5){ echo("selected");} ?> value="5">May</option>
									  <option <?php if($bmonth==6){ echo("selected");} ?>  value="6">June</option>
									  <option <?php if($bmonth==7){ echo("selected");} ?> value="7">July</option>
									  <option <?php if($bmonth==8){ echo("selected");} ?>  value="8">August</option>
									  <option <?php if($bmonth==9){ echo("selected");} ?>  value="9">September</option>
									  <option <?php if($bmonth==10){ echo("selected");} ?>  value="10">October</option>
									  <option <?php if($bmonth==11){ echo("selected");} ?> value="11">November</option>
									  <option <?php if($bmonth==12){ echo("selected");} ?>  value="12">December</option>
									</select>
									  <select name="bday" id="day">
										<option <?php if($bday==1){ echo("selected");} ?> value=1>1</option>
										<option <?php if($bday==2){ echo("selected");} ?> value=2>2</option>
										<option <?php if($bday==3){ echo("selected");} ?> value=3>3</option>
										<option <?php if($bday==4){ echo("selected");} ?> value=4>4</option>
										<option <?php if($bday==5){ echo("selected");} ?> value=5>5</option>
										<option <?php if($bday==6){ echo("selected");} ?> value=6>6</option>
										<option <?php if($bday==7){ echo("selected");} ?> value=7>7</option>
										<option <?php if($bday==8){ echo("selected");} ?> value=8>8</option>
										<option <?php if($bday==9){ echo("selected");} ?> value=9>9</option>
										<option <?php if($bday==10){ echo("selected");} ?> value=10>10</option>
										<option <?php if($bday==11){ echo("selected");} ?> value=11>11</option>
										<option <?php if($bday==12){ echo("selected");} ?> value=12>12</option>
										<option <?php if($bday==13){ echo("selected");} ?> value=13>13</option>
										<option <?php if($bday==14){ echo("selected");} ?> value=14>14</option>
										<option <?php if($bday==15){ echo("selected");} ?> value=15>15</option>
										<option <?php if($bday==16){ echo("selected");} ?> value=16>16</option>
										<option <?php if($bday==17){ echo("selected");} ?> value=17>17</option>
										<option <?php if($bday==18){ echo("selected");} ?> value=18>18</option>
										<option <?php if($bday==19){ echo("selected");} ?> value=19>19</option>
										<option <?php if($bday==20){ echo("selected");} ?> value=20>20</option>
										<option <?php if($bday==21){ echo("selected");} ?> value=21>21</option>
										<option <?php if($bday==22){ echo("selected");} ?> value=22>22</option>
										<option <?php if($bday==23){ echo("selected");} ?> value=23>23</option>
										<option <?php if($bday==24){ echo("selected");} ?> value=24>24</option>
										<option <?php if($bday==25){ echo("selected");} ?> value=25>25</option>
										<option <?php if($bday==26){ echo("selected");} ?> value=26>26</option>
										<option <?php if($bday==27){ echo("selected");} ?> value=27>27</option>
										<option <?php if($bday==28){ echo("selected");} ?> value=28>28</option>
										<option <?php if($bday==29){ echo("selected");} ?> value=29>29</option>
										<option <?php if($bday==30){ echo("selected");} ?> value=30>30</option>
										<option <?php if($bday==31){ echo("selected");} ?> value=31>31</option>
									</select>
									  <select name="byear" id="years">
										<option <?php if($byear=="1990"){ echo("selected");} ?>>1990</option>
										<option <?php if($byear=="1991"){ echo("selected");} ?>>1991</option>
										<option <?php if($byear=="1992"){ echo("selected");} ?>>1992</option>
										<option <?php if($byear=="1993"){ echo("selected");} ?>>1993</option>
										<option <?php if($byear=="1994"){ echo("selected");} ?>>1994</option>
										<option <?php if($byear=="1995"){ echo("selected");} ?>>1995</option>
										<option <?php if($byear=="1996"){ echo("selected");} ?>>1996</option>
										<option <?php if($byear=="1997"){ echo("selected");} ?>>1997</option>
										<option <?php if($byear=="1998"){ echo("selected");} ?>>1998</option>
										<option <?php if($byear=="1999"){ echo("selected");} ?>>1999</option>
										<option <?php if($byear=="2000"){ echo("selected");} ?>>2000</option>
										<option <?php if($byear=="2001"){ echo("selected");} ?>>2001</option>
										<option <?php if($byear=="2002"){ echo("selected");} ?>>2002</option>
										<option <?php if($byear=="2003"){ echo("selected");} ?>>2003</option>
										<option <?php if($byear=="2004"){ echo("selected");} ?>>2004</option>
										<option <?php if($byear=="2005"){ echo("selected");} ?>>2005</option>
										<option <?php if($byear=="2006"){ echo("selected");} ?>>2006</option>
										<option <?php if($byear=="2007"){ echo("selected");} ?>>2007</option>
										<option <?php if($byear=="2008"){ echo("selected");} ?>>2008</option>
										<option <?php if($byear=="2009"){ echo("selected");} ?>>2009</option>
										<option <?php if($byear=="2010"){ echo("selected");} ?>>2010</option>
										<option <?php if($byear=="2011"){ echo("selected");} ?>>2011</option>
										<option <?php if($byear=="2012"){ echo("selected");} ?>>2012</option>
									</select>
								</td>
							</tr>
								<tr>
									<td width="500">Birthplace :</td>
									<td><input type="text" name="bplace" placeholder="Birthplace" size="35" value="<?php echo($bplace); ?>" /></td>
								</tr>
								<tr>
									<td>Gender :</td>
									<td>

										<input type="radio" name="gender" checked id="radio" value=0 <?php if($sex==0) { echo('checked');}?> ><label for="radio">Male &nbsp;
										<input type="radio" name="gender" id="radio2" value=1 <?php if($sex==1) { echo('checked');}?>>Female</label>
							</td>
							    </tr>
								<tr>
									<td width="500">Mother :</td>
									<td><input type="text" name="mother" placeholder="Mother's Name"size="35" value="<?php echo($mother); ?>" /></td>
								</tr>								<tr>
								<tr>
									<td width="500">Occupation :</td>
									<td><input type="text" name="motherocc" placeholder="Mother's Occupation" size="35" value="<?php echo($motherocc); ?>" /></td>
								</tr>								<tr>
								<tr>
									<td width="500">Father :</td>
									<td><input type="text" name="father" placeholder="Father's Name"size="35" value="<?php echo($father); ?>" /></td>
								</tr>								<tr>
								<tr>
									<td width="500">Occupation :</td>
									<td><input type="text" name="fatherocc" placeholder="Fathers's Occupation" size="35"value="<?php echo($fatherocc); ?>" /></td>
								</tr>
								<tr>
									<td width="500">Contact No. :</td>
									<td><input type="text" onKeyPress="return isNumericKey(event);" name="contactno" placeholder="Contact Number" maxlength="11" size="35"value="<?php echo($cellno); ?>" /></td>
								</tr>
								<td width="500">Email Address :</td>
									<td><input type="email" name="eadd" placeholder="E-mail Address" size="35" value="<?php echo($eadd); ?>" /></td>
								</tr>
								<tr>
									<td width="500">Address :</td>
									<td><input type="text" name="radd" placeholder="Residential Address" size="35"value="<?php echo($radd); ?>" /></td>
								</tr>	
								<tr>
									<td width="500">Last School Attended :</td>
									<td><input type="text" name="schname" placeholder="Last School Attended" size="35" value="<?php echo($last); ?>" /></td>
								</tr>	
								<tr>
									<td width="500">Address :</td>
									<td><input type="text" name="schadd" placeholder="School Address" size="35" value="<?php echo($schadd); ?>" /></td>
								</tr>	
							    <tr>
									<td>Profile Picture: </td>
									<td><input type="file" name="uploaded_file" accept="image/*" value="<?php echo($pic); ?>"></td>
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

</body>
</html>

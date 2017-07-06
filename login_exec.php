<?php
	session_start();
	// store session data
	$_SESSION['username']=$_POST['user'];
	$_SESSION['password']=$_POST['pass'];
	include("dbconfig.php");
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	$totalRecords=0;
	$indexName="";
	$userlevel=0;
	$result=mysql_query("SELECT count(*) as total,  userid, fname, mname, lname , pic,levelid,isactive FROM usermaster WHERE username ='".$user."' AND password=PASSWORD('".$pass."')");
	$totalRecords=mysql_num_rows($result);

	while($row=mysql_fetch_array($result))
	{
		if (($totalRecords=="1") && ($row['total']>0))
		{
		$_SESSION['userid'] =$row['userid'];
			if($row['isactive']==1)
			{
				$_SESSION['uid']=$row['userid'];
				if($row['levelid']==1)
				{
					$_SESSION['levelid']=1;
?>
				<script type="text/javascript">
				window.location="index_guest.php";
				</script>
<?php
				}
				elseif($row['levelid']==5)
				{
					$_SESSION['levelid']=5;
?>
				<script type="text/javascript">
				window.location="index_guest.php";
				</script>
<?php
				}
				elseif ($row['levelid']==2)
				{
					$_SESSION['levelid']=2;
?>
				<script type="text/javascript">
				window.location="index_student.php";
				</script>
<?php
				}
				elseif ($row['levelid']==3)
				{
					$_SESSION['levelid']=3;
?>
				<script type="text/javascript">
				window.location="index_faculty.php";
				</script>
<?php
				}
				elseif ($row['levelid']==4)
				{
					$_SESSION['levelid']=4;
?>
				<script type="text/javascript">
				window.location="index_registrar.php";
				</script>
<?php
				}
				else
				{
					$_SESSION['levelid']="ERROR";
?>
				<script type="text/javascript">
				window.location="index_guest.php";
				alert("Error in User Level identification. Please contact the administrator immediately.");
				</script>
<?php
				session_destroy();
				}
			}
			else
			{
?>
			<script type="text/javascript">
			window.location="Index.php";
			alert("Account is inactive. Please contact the administrator immediately.");
			</script>
<?php		
			session_destroy();
			}			
		}
		else
		{
?>
			<script type="text/javascript">
			window.location="Index.php";
			alert("Sorry no account matched! Please check your username and password.");
			</script>
<?php
		session_destroy();
		}
	}
?>


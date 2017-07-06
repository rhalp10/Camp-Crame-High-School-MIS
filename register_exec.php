<body>
<?php
	session_start();
	require_once('dbconfig.php');
	
	
	$query="show table status where name='usermaster'";
	$result=mysql_query($query);
	while($row=mysql_fetch_array($result))
	{
		$uidmaster=$row['Auto_increment'];
	}
	//Get data from POST method.
	$regid=$_POST['regid'];
	$gradeid=$_POST['gradeid'];
	
	$fname = ucwords($_POST['fname']);
	$mname = ucwords($_POST['mname']);
	$lname = ucwords($_POST['lname']);
	$bdate= $_POST['byear']."-".$_POST['bmonth']."-".$_POST['bday'];
	$bplace=$_POST['bplace'];
	$mother = $_POST['mother'];
	$motherocc = $_POST['motherocc'];
	$father = $_POST['father'];
	$fatherocc = $_POST['fatherocc'];
	$m=$_POST['bmonth'];
	$d=$_POST['bday'];
	$y=$_POST['byear'];
	$gender=$_POST['gender'];
	$radd=$_POST['radd'];
	$lastschool=$_POST['schname'];
	$eadd = $_POST['eadd'];
	$cellno = $_POST['contactno'];
	$uname = $_POST['uname'];
	$password = $_POST['passkey1'];
	$userlevel=$regid;
	$isactive="1";
	$age=date_diff(date_create($bdate),date_create('now'))->y;
	$schadd=$_POST['schadd'];
	//System related variables
	$count=0;

	//Variables to be used for uploading Picture.
	$fileName = $_FILES["uploaded_file"]["name"];
	$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; 
	$fileType = $_FILES["uploaded_file"]["type"]; 
	$fileSize = $_FILES["uploaded_file"]["size"]; 
	$fileErrorMsg = $_FILES["uploaded_file"]["error"];
	$fileName=preg_replace('#[^a-z.0-9]#i','cchs',$fileName);
	$fileName2 = explode(".", $fileName); 
	$fileExt = end($fileName2); 	
	$newName = $uidmaster.".".$fileExt;

	$result=mysql_query("SELECT count(*) as total FROM usermaster WHERE username ='".$uname."'");
	while($row=mysql_fetch_array($result))
	{
		if($row['total']==1)
		{
?>
			<script language="javascript">
				alert("Username is no longer available.");
				history.go(-1)
			</script>
<?php		
			exit();
		}
	}
	
if ($fileTmpLoc) { //pag may file na napili

				if($fileSize > 5000000) 
				{ // pag malaki sa 5mb ang file
				?>
			<script language="javascript">
				alert("Your image is larger than 5 Megabytes in size.\nPlease select other image.");
				history.go(-1)
			</script>
<?php
			unlink($fileTmpLoc); // aalisin ung file sa tmp folder
			exit();
		} 
		
		if (!preg_match("/.(gif|jpg|png)$/i", $fileName) ) 
		{  
?>			
			<script language="javascript">
			alert("Invalid image file!");
			history.go(-1)
			</script>
<?php
			unlink($fileTmpLoc); // aalisin sa tmp folder
			exit();
		}
		
		if ($fileErrorMsg == 1) 
		{ 
?>			
			<script language="javascript">
			alert("File not uploaded. Try again");
			history.go(-1)
			</script>
<?php
		exit();			
		}	
		
	// ilalagay na sa folder
	$moveResult = move_uploaded_file($fileTmpLoc, "uploads/$fileName");		
		
	//check kung na-move na ung file
	if ($moveResult != true) 
	{
?>
	<script language="javascript">
	alert("File not uploaded. Try again");
	history.go(-1)
	</script>
<?php
	unlink($fileTmpLoc); // remove ung file sa tmp folder
	exit();
	}		
		
	//ininclude ung code para sa thumbnails
	include_once("thumbnail.php");
	$target_file = "uploads/$fileName";
	$resized_file = "uploads/$newName";
	$wmax = 200;
	$hmax = 150;
	thumbnail($target_file, $resized_file, $wmax, $hmax, $fileExt);		
	unlink('uploads/'.$fileName);
	}	
		
	if(!$fileTmpLoc) //no pic
	{	
		$usermaster = "INSERT INTO usermaster (fname,mname,lname,username,password,levelid,isactive,pic) VALUES ('$fname','$mname','$lname','$uname',PASSWORD('$password'),'$userlevel','$isactive','Default.jpg')";
		mysql_query($usermaster);

	}	
	else //with pic
	{
		$usermaster = "INSERT INTO usermaster (fname,mname,lname,username,password,levelid,isactive,pic) VALUES ('$fname','$mname','$lname','$uname',PASSWORD('$password'),'$userlevel','$isactive','$newName')";
		mysql_query($usermaster);
	}
		
		$preregmaster = "INSERT INTO preregmaster(userid,address,sex,birthday,birthplace,cellno,mother,motherocc,father,fatherocc,lastschoolattended,schooladdress,email,gradeid,registrationid) VALUES ('$uidmaster','$radd','$gender','$bdate','$bplace','$cellno','$mother','$motherocc','$father','$fatherocc','$lastschool','$schadd','$eadd','$gradeid','$regid')";
		mysql_query($preregmaster);
		
		$reqmaster = "SELECT docid FROM requirementmaster where regid='$userlevel'";
		$result= mysql_query($reqmaster);
		while ($row=mysql_fetch_array($result))
		{
			$docid=$row['docid'];
			$reqtxn="INSERT INTO requirementstxn (userid,docid,status,regid) VALUES ('$uidmaster','$docid','0',$gradeid)";
			mysql_query($reqtxn);
		}
		
		
?>

<script type="text/javascript">
alert("Account has been successfully registered! You may now use your credentials to login.");
window.location="index.php";
</script>

</body>
<?php
	session_start();
	require_once('dbconfig.php');
	
	$userid = $_SESSION['userid'];
	$level = $_SESSION['levelid'];

	$fname=$_POST['fname'];
	$mname=$_POST['mname'];
	$lname=$_POST['lname'];
	$bplace=$_POST['bplace'];
	$cellno=$_POST['contactno'];
	$eadd=$_POST['eadd'];
	$radd=$_POST['radd'];	
	$bmonth=$_POST['bmonth'];
	$bdate=$_POST['byear']."-".$_POST['bmonth']."-".$_POST['bday'];
	$sex=$_POST['gender'];
	$m=$_POST['bmonth'];
	$d=$_POST['bday'];
	$y=$_POST['byear'];
	
	$fileName = $_FILES["uploaded_file"]["name"];
	$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; 
	$fileType = $_FILES["uploaded_file"]["type"]; 
	$fileSize = $_FILES["uploaded_file"]["size"]; 
	$fileErrorMsg = $_FILES["uploaded_file"]["error"];
	$fileName=preg_replace('#[^a-z.0-9]#i','cchs',$fileName);
	$fileName2 = explode(".", $fileName); 
	$fileExt = end($fileName2); 	
	$newName = $userid.".".$fileExt;	

	if ($fileTmpLoc) 
	{ //pag may file na napili
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
		//updates usermaster table
		$query="UPDATE usermaster SET ";
		$query=$query."fname='$fname', ";
		$query=$query."mname='$mname', ";
		$query=$query."lname='$lname', ";
		$query=$query."pic='Default.jpg' ";
		$query=$query."WHERE userid=$userid";

	}	
	else //with pic
	{
		//updates usermaster table
		$query="UPDATE usermaster SET ";
		$query=$query."fname='$fname', ";
		$query=$query."mname='$mname', ";
		$query=$query."lname='$lname', ";
		$query=$query."pic='$newName' ";
		$query=$query."WHERE userid=$userid";
	}
	mysql_query($query);
	
	$query="UPDATE ";
	$query=$query."facultymaster SET ";
	$query=$query."address='$radd', ";
	$query=$query."sex=$sex, ";
	$query=$query."birthday='$bdate', ";
	$query=$query."cellno='$cellno', ";
	$query=$query."birthplace='$bplace', ";
	$query=$query."email='$eadd', ";
	$query=$query."editdate=now() ";	
	$query=$query."WHERE userid=$userid";
	mysql_query($query);
?>

<html><script languange="javascript">
		alert("Personal Information has been successfully updated. You will be logged out for the changes to take effect.");
		window.opener.location="logout.php"
		window.close();
	</script>
</html>
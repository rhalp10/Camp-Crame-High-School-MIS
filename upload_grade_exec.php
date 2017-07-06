<?php
	session_start();
	$level=$_SESSION['levelid'];
	$uploadid=$_SESSION['uploadid'];
	include('dbconfig.php');
	
	if(!isset($_POST['gradeid']))
	{
?>
		<script type="text/javascript">
			window.location="upload_grade.php";
		</script>		
<?php
	}
	else
	{
		$syid=$_POST['syid'];
		$gradeid=$_POST['gradeid'];
		$subjectid=$_POST['subjectid'];
		$periodid=$_POST['periodid'];
		$f=$_POST['filename'];
				
		$file = fopen($f, "r");
		$heading=true;
		while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
		{
			if($heading)
			{
				$heading=false;
				continue;
			}
				$lrn=$emapData[0];
				$proj=$emapData[5];
				$quiz=$emapData[7];
				$att=$emapData[3];
				$ass=$emapData[1];
				$projp=$emapData[6];
				$quizp=$emapData[8];
				$attp=$emapData[4];
				$assp=$emapData[2];
				$exam=$emapData[9];
				$examp=$emapData[10];
				$extra=$emapData[11];
				$extrap=$emapData[12];
				$query ="DELETE FROM gradetxn WHERE gradeid=$gradeid AND subjectid=$subjectid AND gradingperiod=$periodid AND uploadedby=$uploadid AND lrn='$lrn'";
				//echo $query;
				mysql_query($query);

				$query="INSERT INTO gradetxn(lrn,subjectid,gradeid,project,quiz,assignment,attendance,projectpercent,assignmentpercent,attendancepercent,quizpercent,exam,exampercent,extracurricular,extracurricularpercent,gradingperiod,syid,uploadedby) VALUES ('$lrn',$subjectid,$gradeid,$proj,$quiz,$ass,$att,$projp,$assp,$attp,$quizp,$exam,$examp,$extra,$extrap,$periodid,$syid,$uploadid)";
				mysql_query($query);
		}
?>
			<script type="text/javascript">
				alert('Grades has been successfully uploaded.');
				window.location="upload_grade.php";
			</script>	
<?php
	
			fclose($file);
			unlink($f);
	}
?>
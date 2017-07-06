<?php
	include("dbconfig.php");
	
	function displaySchoolVision()
	{
		$query="SELECT * FROM informationmaster WHERE infoid=2";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
			$vision = $row['description'];
		}
		echo($vision);
	}
	
	function displaySchoolMission()
	{
		$query="SELECT * FROM informationmaster WHERE infoid=1";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
			$mission = $row['description'];
		}
		echo($mission);
	}	

	function displayPresidentsName()
	{
		$query="SELECT * FROM informationmaster WHERE infoid=3";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
			$presidentname = $row['infodesc'];
		}
		echo($presidentname);
	}		

	function displayPresidentsMessage()
	{
		$query="SELECT * FROM informationmaster WHERE infoid=4";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
			$presidentmessage = $row['infodesc'];
		}
		echo($presidentmessage);
	}		
	
	function displayActiveAnnouncement()
	{
		$query="SELECT * FROM announcementmaster WHERE isactive=1 order by adddate asc";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
?>
		<table>
			<td colspan=2 align="center"><font face="Tahoma" size=2.5><?php echo $row['title']; ?></font></td>
			<tr/><tr/><tr/><tr/><tr/>
			<td align="justify">WHO:</td><td><?php echo $row['who']; ?></td>
			<tr/><tr/><tr/><tr/><tr/>
			<td align="justify">WHAT:</td><td><?php echo $row['what']; ?></td>
			<tr/><tr/><tr/><tr/><tr/>
			<td align="justify">WHERE:</td><td><?php echo $row['where']; ?></td>
			<tr/><tr/><tr/><tr/><tr/>
			<td align="justify">WHEN:</td><td><?php echo $row['when']; ?></td>
		</table>
		
		<br/><br/>
<?php
		}
	}

	function displayPresidentsPhoto()
	{
		$query="SELECT * FROM informationmaster WHERE infoid=5";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
			$filepathPhoto = $row['infodesc'];
		}
		return $filepathPhoto;
	}		
	
?>


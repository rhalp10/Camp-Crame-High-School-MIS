<?php
	include("dbconfig.php");

function displayStudentViewAllGrade($uploadid,$lrn)
	{
		$per_page=10;
		if(empty($_GET['term']))
		{
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, sbm.subjectname, gpm.description, glm.description as GradeLevel, sec.section, gt.finalgrade, gt.gradetxnid  FROM usermaster as um, studentmaster as sm, gradetxn as gt, gradingperiodmaster as gpm, subjectmaster as sbm, gradelevelmaster as glm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.lrn=gt.lrn AND gt.subjectid=sbm.subjectid AND gt.gradingperiod=gpm.periodid AND gt.gradeid=glm.gradeid AND sm.gradeid=gt.gradeid AND sec.sectionid=sm.sectionid AND gt.lrn='$lrn'";
		}
		if(!empty($_GET['term']))
		{
				$term=$_GET['term'];
				$criteria=$_GET['criteria'];
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, sbm.subjectname, gpm.description, glm.description as GradeLevel, sec.section, gt.finalgrade, gt.gradetxnid FROM usermaster as um, studentmaster as sm, gradetxn as gt, gradingperiodmaster as gpm, subjectmaster as sbm, gradelevelmaster as glm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.lrn=gt.lrn AND gt.subjectid=sbm.subjectid AND gt.gradingperiod=gpm.periodid AND gt.gradeid=glm.gradeid AND sm.gradeid=gt.gradeid AND sec.sectionid=sm.sectionid AND gt.lrn='$lrn' and $criteria LIKE '%$term%' ";				

		}

		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}
		


?>
		<table class="PreRegMasterList" width="1500" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=23 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM studentmaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
		
?>
		<tr>
			<th>Grading Period</th>
			<th>Subject</th>
			<th>Final Grade</th>
			<th>Remarks</th>
			<th>Action</th>
		</tr>
<?php
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
?>
		<tr>
			<th>Grading Period</th>
			<th>Subject</th>
			<th>Final Grade</th>
			<th>Remarks</th>
			<th>Action</th>
		</tr>
<?php
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			

					echo "<tr>";
					echo '<td  align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td  align="center">'. mysql_result($result,$i,'subjectname') .'</td>';
					$final = round(mysql_result($result,$i,'finalgrade'),2);
					if($final>=75)
					{
						$remarks="PASSED";
					}
					else
					{
						$remarks="FAILED";
					}
					
					echo '<td  align="center">'. $final .'</td>';
					echo '<td  align="center">'. $remarks .'</td>';
					
?>
                     <?php $gradetxn = mysql_result($result,$i,'gradetxnid'); ?>
					<td align="center"><img height=10 src="images/modify.ico"/>&nbsp;&nbsp;<a class="myLinks" href="update_grade.php?gradetxnid=<?php echo($gradetxn);?>" onclick="window.open(this.href, '_blank', 'left=0,top=0,toolbar=1,resizable=0,width=500,height=500'); return false;">Edit</a></td>
<?php
					
					//echo '<td width="150" align="center"><a class="myLinks" href="editall_grade.php?lrn='. mysql_result($result,$i,'lrn') .'" ><img height=15 width=15 src="images/modify.ico" alt="View"/>&nbsp;&nbsp;Edit</a></td>';
					echo "</tr>";
				}
			}
			else
			{
?>
		<tr>
			<th>Grading Period</th>
			<th>Subject</th>
			<th>Final Grade</th>
			<th>Remarks</th>
			<th>Action</th>
		</tr>
<?php
					echo '<td colspan=23 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					if(empty($_GET['term']) && empty($_GET['criteria']))
					{
					echo "<a href='editall_grade.php?page=$i&&lrn=$lrn' class='myLinks'>$i</a>";
					}
					else
					{
						$term=$_GET['term'];
						$criteria=$_GET['criteria'];
					echo "<a href='editall_grade.php?page=$i&&term=$term&&criteria=$criteria&&lrn=$lrn' class='myLinks'>$i</a>";
					}
				}
			}
		}
?>
		</table>
	<br/>	

<?php			
} // end function  displayStudentViewEditGrade
	
	
	
function displayStudentViewEditGrade()
	{
		$per_page=7;
		if(empty($_GET['term']))
		{
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec, gradetxn as gt WHERE sm.userid=um.userid AND gt.lrn=sm.lrn  AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid group by lrn ORDER BY glm.description, sec.section, sm.lrn ASC";
		}
		if(!empty($_GET['term']))
		{
			$term=$_GET['term'];
			$criteria=$_GET['criteria'];
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec, gradetxn AS gt WHERE sm.userid=um.userid AND gt.lrn=sm.lrn  AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid AND $criteria LIKE '%$term%' group by lrn ORDER BY sm.lrn ASC";
		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}
		


?>
		<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=7 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM studentmaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
			echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
			echo "<tr>";
			echo '<td colspan=7  align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
			echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			

					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lrn') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'section') .'</td>';
					echo '<td width="150" align="center"><a class="myLinks" href="editall_grade.php?lrn='. mysql_result($result,$i,'lrn') .'" ><img height=15 width=15 src="images/modify.ico" alt="View"/>&nbsp;&nbsp;Edit</a></td>';
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
					echo '<td colspan=7 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					if(empty($_GET['term']) && empty($_GET['criteria']))
					{
					echo "<a href='edit_grade.php?page=$i' class='myLinks'>$i</a>";
					}
					else
					{
					echo "<a href='edit_grade.php?page=$i&&term=$term&&criteria=$criteria' class='myLinks'>$i</a>";
					}
				}
			}
		}
?>
		</table>
	<br/>	

<?php			
} // end function  displayStudentViewEditGrade

	
	function displayDeletedAnnouncement($uid)
	{
		$per_page=15;
		
		$query="SELECT am.*,um.fname,um.mname,um.lname FROM announcementmaster as am, usermaster as um WHERE am.addby=um.userid AND am.isactive=1 AND am.expirydate>now() AND am.addby=$uid";
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		$totalActive=mysql_num_rows($result);
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}
?>
			<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
			<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Announcement</font></strong></div></td>			
<?php

		if($totalActive==0)
		{
?>
			<tr>
				<th>Title</th><th>Date Posted</th><th>Expiry Date</th><th>Posted By</th><th>Action</th>
			</tr>
			<tr>
				<td colspan=5 align="center">No Active Announcement to display.</td>
			</tr>
<?php
		}
		else
		{
?>
			<tr>
				<th>Title</th><th>Date Posted</th><th>Expiry Date</th><th>Posted By</th><th>Action</th>
			</tr>
<?php
			for($i=$start; $i<$end; $i++)
			{
				if ($i==$total_results){break;}
				$name= mysql_result($result,$i,'fname')." ".mysql_result($result,$i,'lname');
				$id=mysql_result($result,$i,'announcementid');
				echo "<tr>";
				echo '<td  align="center">'. mysql_result($result,$i,'title') .'</td>';
				echo '<td  align="center">'. date("F d,Y", strtotime(mysql_result($result,$i,'adddate'))) .'</td>';
				echo '<td  align="center">'. date("F d,Y", strtotime(mysql_result($result,$i,'expirydate'))) .'</td>';
				echo '<td  align="center">'. $name .'</td>';
?>
				<td align="center"><a class="myLinks" href="edit_announcement_topic.php?id=<?php echo $id; ?>"><img height=15 width=15 src="images/Modify.ico" alt="Edit"/>&nbsp;&nbsp;Edit</a></t';d>

<?php
				echo "</tr>";
			}

		}
?>
		</table>
		<br/>
<?php
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					echo "<a href='edit_announcement.php?page=$i' class='myLinks'>$i</a>";
				}
			}

	}
	
	function displayDeactivateAnnouncement($userid)
	{
		$per_page=15;
		
		$query="SELECT am.*,um.fname,um.mname,um.lname FROM announcementmaster as am, usermaster as um WHERE am.addby=um.userid AND am.expirydate>now() AND am.addby=$userid";
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		$totalActive=mysql_num_rows($result);
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}
?>
			<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
			<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Announcement</font></strong></div></td>			
<?php

		if($totalActive==0)
		{
?>
			<tr>
				<th>Title</th><th>Date Posted</th><th>Expiry Date</th><th>Posted By</th><th>Action</th>
			</tr>
			<tr>
				<td colspan=5 align="center">No Announcement to display.</td>
			</tr>
<?php
		}
		else
		{
?>
			<tr>
				<th>Title</th><th>Date Posted</th><th>Expiry Date</th><th>Posted By</th><th>Action</th>
			</tr>
<?php
			for($i=$start; $i<$end; $i++)
			{
				if ($i==$total_results){break;}
				$stat=mysql_result($result,$i,'isactive');
				if($stat==0)
				{
					$h="images/OK.ico";
					$g="Activate";
					$val="1";
				}
				else
				{
					$h="images/No.ico";
					$g="Deactivate";
					$val="2";
				}
				$name= mysql_result($result,$i,'fname')." ".mysql_result($result,$i,'lname');
				$id=mysql_result($result,$i,'announcementid');
				echo "<tr>";
				echo '<td  align="center">'. mysql_result($result,$i,'title') .'</td>';
				echo '<td  align="center">'. date("F d,Y", strtotime(mysql_result($result,$i,'adddate'))) .'</td>';
				echo '<td  align="center">'. date("F d,Y", strtotime(mysql_result($result,$i,'expirydate'))) .'</td>';
				echo '<td  align="center">'. $name .'</td>';
?>
				<td align="center"><a class="myLinks" onclick="return confirm('Are you sure you want to continue?'); return false;" href="deactivate_announcement_exec.php?id=<?php echo($id); ?>&&val=<?php echo $val; ?>"><img src="<?php echo $h; ?>">&nbsp;&nbsp;<?php echo $g; ?></a></td>

<?php
				echo "</tr>";
			}

		}
?>
		</table>
		<br/>
<?php
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					echo "<a href='deactivate_announcement.php?page=$i' class='myLinks'>$i</a>";
				}
			}
	}
	
	function displaySelectedAnnouncementTopic($id)
	{
		$query="SELECT * FROM announcementmaster WHERE announcementid=$id";
		$result=mysql_query($query);		
		while($row=mysql_fetch_array($result))
		{
			$title=$row['title'];
			$what=$row['what'];
			$venue=$row['venue'];
			$eventdate=$row['eventdate'];
			$who=$row['who'];
			$expirydate=$row['expirydate'];
			$addby=$row['addby'];
			$adddate=$row['adddate'];
		}
		$query="SELECT * FROM usermaster WHERE userid=$addby";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$author=$row['fname']." ".$row['lname'];
		}
?>
		<img src="images/announcementtitle.png" width="30" height="30">&nbsp;<font color="maroon" size=3><strong><?php echo $title; ?></strong></font>
		<br>
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<font size=1><i>Date Posted:&nbsp;<?php echo date("F d, Y",strtotime($adddate)); ?><br>		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Author:&nbsp;<?php echo $author; ?></i></font>
		<br>
		<br>
		<font size="2">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		What:&nbsp;&nbsp;&nbsp;<?php echo $what ?>
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Where:&nbsp;<?php echo $venue ?>
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		When:&nbsp;&nbsp;<?php echo $eventdate ?>
		<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Who:&nbsp;&nbsp;&nbsp;<?php echo $who ?>
		</font>
		<br><br>
		<a class="myLinks" href="view_all_announcement.php"><< Go Back</a>
<?php
	}
	
	function displayAllAnnouncement()
	{
		$per_page=15;
		
		$query="SELECT am.*,um.fname,um.mname,um.lname FROM announcementmaster as am, usermaster as um WHERE am.addby=um.userid AND am.isactive=1 AND am.expirydate>now() ";
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		$totalActive=mysql_num_rows($result);
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}
?>
			<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
			<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Announcement</font></strong></div></td>			
<?php

		if($totalActive==0)
		{
?>
			<tr>
				<th>Title</th><th>Date Posted</th><th>Expiry Date</th><th>Posted By</th><th>Action</th>
			</tr>
			<tr>
				<td colspan=5 align="center">No Active Announcement to display.</td>
			</tr>
<?php
		}
		else
		{
?>
			<tr>
				<th>Title</th><th>Date Posted</th><th>Expiry Date</th><th>Posted By</th><th>Action</th>
			</tr>
<?php
			for($i=$start; $i<$end; $i++)
			{
				if ($i==$total_results){break;}
				$name= mysql_result($result,$i,'fname')." ".mysql_result($result,$i,'lname');
				$id=mysql_result($result,$i,'announcementid');
				echo "<tr>";
				echo '<td  align="center">'. mysql_result($result,$i,'title') .'</td>';
				echo '<td  align="center">'. date("F d,Y", strtotime(mysql_result($result,$i,'adddate'))) .'</td>';
				echo '<td  align="center">'. date("F d,Y", strtotime(mysql_result($result,$i,'expirydate'))) .'</td>';
				echo '<td  align="center">'. $name .'</td>';
?>
				<td align="center"><a class="myLinks" href="view_announcement_topic.php?id=<?php echo $id; ?>"><img height=15 width=15 src="images/View.png" alt="View"/>&nbsp;&nbsp;View</a></t';d>

<?php
				echo "</tr>";
			}

		}
?>
		</table>
		<br/>
<?php
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					echo "<a href='view_all_announcement.php?page=$i' class='myLinks'>$i</a>";
				}
			}

	}
	
	function displayStudentFinalGrades($lrn,$syid,$gradeid)
	{
		$query="SET @sql=NULL;SELECT GROUP_CONCAT(DISTINCT CONCAT('MAX(IF(gt.gradingperiod=''',gt.gradingperiod,''',gt.finalgrade,NULL)) AS ''',gt.gradingperiod,''''))INTO @sql FROM gradetxn gt, subjectmaster sm; SET @sql=CONCAT('SELECT sm.subjectname, gt.gradetxnid, ', @sql, ' FROM gradetxn gt, subjectmaster sm WHERE gt.subjectid=sm.subjectid AND lrn=''$lrn'' AND gt.syid=$syid GROUP BY gt.subjectid');";
		
		$totalFilipino=0;
		$finalGradeFilipino=0;
		$totalEnglish=0;
		$finalGradeEnglish=0;
		$totalMath=0;
		$finalGradeMath=0;		
		$totalSci=0;
		$finalGradeSci=0;				
		$totalAp=0;
		$finalGradeAp=0;		
		$totalTle=0;
		$finalGradeTle=0;	
		$totalMapeh=0;
		$finalGradeMapeh=0;	
		$totalEp=0;
		$finalGradeEp=0;	
		$totalSub=0;		
?>
		<tr>
<?php
			$query="SELECT subjectname, units FROM subjectmaster WHERE subjectid=1";
			$result=mysql_query($query);
			while($row=mysql_fetch_array($result))
			{
				$filipinoUnits = $row['units'];
				$subjectname = $row['subjectname'];
			}
			echo '<td>'.$subjectname.'</td>';
			echo '<td align=center>'.$filipinoUnits.'</td>';
		
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=1 AND syid=$syid AND lrn='$lrn' AND gradingperiod=1";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$filipinoGradeFirst = $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $filipinoGradeFirst >=grademin AND $filipinoGradeFirst<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalFilipino=$totalFilipino+1;
						}
					}
				}
			}
			else
			{
				$grade="";
				$filipinoGradeFirst=0;
				echo '<td align=center>'."".'</td>';
			}
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=1 AND syid=$syid AND lrn='$lrn' AND gradingperiod=2";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$filipinoGradeSecond= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $filipinoGradeSecond >=grademin AND $filipinoGradeSecond<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalFilipino=$totalFilipino+1;
						}
					}
				}
			}
			else
			{
				$filipinoGradeSecond=0;
				echo '<td align=center>'."".'</td>';
			}			
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=1 AND syid=$syid AND lrn='$lrn' AND gradingperiod=3";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$filipinoGradeThird= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $filipinoGradeThird >=grademin AND $filipinoGradeThird<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalFilipino=$totalFilipino+1;
						}
					}
				}
			}
			else
			{
				$filipinoGradeThird=0;
				echo '<td align=center>'."".'</td>';
			}			

			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=1 AND syid=$syid AND lrn='$lrn' AND gradingperiod=4";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$filipinoGradeFourth= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $filipinoGradeFourth >=grademin AND $filipinoGradeFourth<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalFilipino=$totalFilipino+1;
						}
					}
				}
			}
			else
			{
				$filipinoGradeFourth=0;
				echo '<td align=center>'."".'</td>';
			}				
			
			if ($totalFilipino>0)
			{
				$finalGradeFilipino = ($filipinoGradeFirst + $filipinoGradeSecond + $filipinoGradeThird + $filipinoGradeFourth)/$totalFilipino;
				$finalGradeFilipino = round($finalGradeFilipino,0);
				echo '<td align=center>'.$finalGradeFilipino.'</td>';
				if($finalGradeFilipino>=75)
				{
					$remarks="Passed";
				}
				else
				{
					$remarks="Failed";
				}
				echo '<td align=center>'.$remarks.'</td>';
			}
			else
			{
				echo '<td></td>';
				echo '<td></td>';
			}			
?>
		</tr>
		<tr>
<?php
			$query="SELECT subjectname, units FROM subjectmaster WHERE subjectid=2";
			$result=mysql_query($query);
			while($row=mysql_fetch_array($result))
			{
				$englishUnits = $row['units'];
				$subjectname = $row['subjectname'];
			}
			echo '<td>'.$subjectname.'</td>';
			echo '<td align=center>'.$englishUnits.'</td>';
		
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=2 AND syid=$syid AND lrn='$lrn' AND gradingperiod=1";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$englishGradeFirst = $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $englishGradeFirst >=grademin AND $englishGradeFirst<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalEnglish=$totalEnglish+1;
						}
					}
				}
			}
			else
			{
				$grade="";
				$englishGradeFirst=0;
				echo '<td align=center>'."".'</td>';
			}
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=2 AND syid=$syid AND lrn='$lrn' AND gradingperiod=2";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$englishGradeSecond= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $englishGradeSecond >=grademin AND $englishGradeSecond<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalEnglish=$totalEnglish+1;
						}
					}
				}
			}
			else
			{
				$englishGradeSecond=0;
				echo '<td align=center>'."".'</td>';
			}			
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=2 AND syid=$syid AND lrn='$lrn' AND gradingperiod=3";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$englishGradeThird= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $englishGradeThird >=grademin AND $englishGradeThird<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalEnglish=$totalEnglish+1;
						}
					}
				}
			}
			else
			{
				$englishGradeThird=0;
				echo '<td align=center>'."".'</td>';
			}			

			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=2 AND syid=$syid AND lrn='$lrn' AND gradingperiod=4";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$englishGradeFourth= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $englishGradeFourth >=grademin AND $englishGradeFourth<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalEnglish=$totalEnglish+1;
						}
					}
				}
			}
			else
			{
				$englishGradeFourth=0;
				echo '<td align=center>'."".'</td>';
			}				
			
			if ($totalEnglish>0)
			{
				$finalGradeEnglish = ($englishGradeFirst + $englishGradeSecond + $englishGradeThird + $englishGradeFourth)/$totalEnglish;
				$finalGradeEnglish = round($finalGradeEnglish,0);
				echo '<td align=center>'.$finalGradeEnglish.'</td>';
				if($finalGradeEnglish>=75)
				{
					$remarks="Passed";
				}
				else
				{
					$remarks="Failed";
				}
				echo '<td align=center>'.$remarks.'</td>';
			}
			else
			{
				echo '<td></td>';
				echo '<td></td>';
			}			
?>
		</tr>
		<tr>
<?php
			$query="SELECT subjectname, units FROM subjectmaster WHERE subjectid=3";
			$result=mysql_query($query);
			while($row=mysql_fetch_array($result))
			{
				$mathUnits = $row['units'];
				$subjectname = $row['subjectname'];
			}
			echo '<td>'.$subjectname.'</td>';
			echo '<td align=center>'.$mathUnits.'</td>';
		
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=3 AND syid=$syid AND lrn='$lrn' AND gradingperiod=1";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$mathGradeFirst = $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $mathGradeFirst >=grademin AND $mathGradeFirst<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalMath=$totalMath+1;
						}
					}
				}
			}
			else
			{
				$grade="";
				$mathGradeFirst=0;
				echo '<td align=center>'."".'</td>';
			}
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=3 AND syid=$syid AND lrn='$lrn' AND gradingperiod=2";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$mathGradeSecond= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $mathGradeSecond >=grademin AND $mathGradeSecond<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalMath=$totalMath+1;
						}
					}
				}
			}
			else
			{
				$mathGradeSecond=0;
				echo '<td align=center>'."".'</td>';
			}			
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=3 AND syid=$syid AND lrn='$lrn' AND gradingperiod=3";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$mathGradeThird= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $mathGradeThird >=grademin AND $mathGradeThird<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalMath=$totalMath+1;
						}
					}
				}
			}
			else
			{
				$mathGradeThird=0;
				echo '<td align=center>'."".'</td>';
			}			

			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=3 AND syid=$syid AND lrn='$lrn' AND gradingperiod=4";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$mathGradeFourth= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $mathGradeFourth >=grademin AND $mathGradeFourth<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalMath=$totalMath+1;
						}
					}
				}
			}
			else
			{
				$mathGradeFourth=0;
				echo '<td align=center>'."".'</td>';
			}				
			
			if ($totalMath>0)
			{
				$finalGradeMath = ($mathGradeFirst + $mathGradeSecond + $mathGradeThird + $mathGradeFourth)/$totalMath;
				$finalGradeMath = round($finalGradeMath,0);
				echo '<td align=center>'.$finalGradeMath.'</td>';
				if($finalGradeMath>=75)
				{
					$remarks="Passed";
				}
				else
				{
					$remarks="Failed";
				}
				echo '<td align=center>'.$remarks.'</td>';
			}
			else
			{
				echo '<td></td>';
				echo '<td></td>';
			}			
?>
		</tr>		
		<tr>
<?php
			$query="SELECT subjectname, units FROM subjectmaster WHERE subjectid=4";
			$result=mysql_query($query);
			while($row=mysql_fetch_array($result))
			{
				$sciUnits = $row['units'];
				$subjectname = $row['subjectname'];
			}
			echo '<td>'.$subjectname.'</td>';
			echo '<td align=center>'.$sciUnits.'</td>';
		
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=4 AND syid=$syid AND lrn='$lrn' AND gradingperiod=1";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sciGradeFirst = $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $sciGradeFirst >=grademin AND $sciGradeFirst<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalSci=$totalSci+1;
						}
					}
				}
			}
			else
			{
				$grade="";
				$sciGradeFirst=0;
				echo '<td align=center>'."".'</td>';
			}
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=4 AND syid=$syid AND lrn='$lrn' AND gradingperiod=2";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sciGradeSecond= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $sciGradeSecond >=grademin AND $sciGradeSecond<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalSci=$totalSci+1;
						}
					}
				}
			}
			else
			{
				$sciGradeSecond=0;
				echo '<td align=center>'."".'</td>';
			}			
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=4 AND syid=$syid AND lrn='$lrn' AND gradingperiod=3";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sciGradeThird= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $sciGradeThird >=grademin AND $sciGradeThird<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalSci=$totalSci+1;
						}
					}
				}
			}
			else
			{
				$sciGradeThird=0;
				echo '<td align=center>'."".'</td>';
			}			

			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=4 AND syid=$syid AND lrn='$lrn' AND gradingperiod=4";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$sciGradeFourth= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $sciGradeFourth >=grademin AND $sciGradeFourth<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalSci=$totalSci+1;
						}
					}
				}
			}
			else
			{
				$sciGradeFourth=0;
				echo '<td align=center>'."".'</td>';
			}				
			
			if ($totalSci>0)
			{
				$finalGradeSci = ($sciGradeFirst + $sciGradeSecond + $sciGradeThird + $sciGradeFourth)/$totalSci;
				$finalGradeSci = round($finalGradeSci,0);
				echo '<td align=center>'.$finalGradeSci.'</td>';
				if($finalGradeSci>=75)
				{
					$remarks="Passed";
				}
				else
				{
					$remarks="Failed";
				}
				echo '<td align=center>'.$remarks.'</td>';
			}
			else
			{
				echo '<td></td>';
				echo '<td></td>';
			}			
?>
		</tr>			
		<tr>
<?php
			$query="SELECT subjectname, units FROM subjectmaster WHERE subjectid=5";
			$result=mysql_query($query);
			while($row=mysql_fetch_array($result))
			{
				$apUnits = $row['units'];
				$subjectname = $row['subjectname'];
			}
			echo '<td>'.$subjectname.'</td>';
			echo '<td align=center>'.$apUnits.'</td>';
		
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=5 AND syid=$syid AND lrn='$lrn' AND gradingperiod=1";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$apGradeFirst = $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $apGradeFirst >=grademin AND $apGradeFirst<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalAp=$totalAp+1;
						}
					}
				}
			}
			else
			{
				$grade="";
				$apGradeFirst=0;
				echo '<td align=center>'."".'</td>';
			}
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=5 AND syid=$syid AND lrn='$lrn' AND gradingperiod=2";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$apGradeSecond= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $apGradeSecond >=grademin AND $apGradeSecond<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalAp=$totalAp+1;
						}
					}
				}
			}
			else
			{
				$apGradeSecond=0;
				echo '<td align=center>'."".'</td>';
			}			
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=5 AND syid=$syid AND lrn='$lrn' AND gradingperiod=3";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$apGradeThird= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $apGradeThird >=grademin AND $apGradeThird<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalAp=$totalAp+1;
						}
					}
				}
			}
			else
			{
				$apGradeThird=0;
				echo '<td align=center>'."".'</td>';
			}			

			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=5 AND syid=$syid AND lrn='$lrn' AND gradingperiod=4";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$apGradeFourth= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $apGradeFourth >=grademin AND $apGradeFourth<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalAp=$totalAp+1;
						}
					}
				}
			}
			else
			{
				$apGradeFourth=0;
				echo '<td align=center>'."".'</td>';
			}				
			
			if ($totalAp>0)
			{
				$finalGradeAp = ($apGradeFirst + $apGradeSecond + $apGradeThird + $apGradeFourth)/$totalAp;
				$finalGradeAp = round($finalGradeAp,0);
				echo '<td align=center>'.$finalGradeAp.'</td>';
				if($finalGradeAp>=75)
				{
					$remarks="Passed";
				}
				else
				{
					$remarks="Failed";
				}
				echo '<td align=center>'.$remarks.'</td>';
			}
			else
			{
				echo '<td></td>';
				echo '<td></td>';
			}			
?>
		</tr>		
		<tr>
<?php
			$query="SELECT subjectname, units FROM subjectmaster WHERE subjectid=6";
			$result=mysql_query($query);
			while($row=mysql_fetch_array($result))
			{
				$tleUnits = $row['units'];
				$subjectname = $row['subjectname'];
			}
			echo '<td>'.$subjectname.'</td>';
			echo '<td align=center>'.$tleUnits.'</td>';
		
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=6 AND syid=$syid AND lrn='$lrn' AND gradingperiod=1";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$tleGradeFirst = $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $tleGradeFirst >=grademin AND $tleGradeFirst<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalTle=$totalTle+1;
						}
					}
				}
			}
			else
			{
				$grade="";
				$tleGradeFirst=0;
				echo '<td align=center>'."".'</td>';
			}
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=6 AND syid=$syid AND lrn='$lrn' AND gradingperiod=2";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$tleGradeSecond= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $tleGradeSecond >=grademin AND $tleGradeSecond<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalTle=$totalTle+1;
						}
					}
				}
			}
			else
			{
				$tleGradeSecond=0;
				echo '<td align=center>'."".'</td>';
			}			
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=6 AND syid=$syid AND lrn='$lrn' AND gradingperiod=3";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$tleGradeThird= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $tleGradeThird >=grademin AND $tleGradeThird<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalTle=$totalTle+1;
						}
					}
				}
			}
			else
			{
				$tleGradeThird=0;
				echo '<td align=center>'."".'</td>';
			}			

			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=6 AND syid=$syid AND lrn='$lrn' AND gradingperiod=4";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$tleGradeFourth= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $tleGradeFourth >=grademin AND $tleGradeFourth<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalTle=$totalTle+1;
						}
					}
				}
			}
			else
			{
				$tleGradeFourth=0;
				echo '<td align=center>'."".'</td>';
			}				
			
			if ($totalTle>0)
			{
				$finalGradeTle = ($tleGradeFirst + $tleGradeSecond + $tleGradeThird + $tleGradeFourth)/$totalTle;
				$finalGradeTle = round($finalGradeTle,0);
				echo '<td align=center>'.$finalGradeTle.'</td>';
				if($finalGradeTle>=75)
				{
					$remarks="Passed";
				}
				else
				{
					$remarks="Failed";
				}
				echo '<td align=center>'.$remarks.'</td>';
			}
			else
			{
				echo '<td></td>';
				echo '<td></td>';
			}			
?>
		</tr>		
		<tr>
<?php
			$query="SELECT subjectname, units FROM subjectmaster WHERE subjectid=7";
			$result=mysql_query($query);
			while($row=mysql_fetch_array($result))
			{
				$mapehUnits = $row['units'];
				$subjectname = $row['subjectname'];
			}
			echo '<td>'.$subjectname.'</td>';
			echo '<td align=center>'.$mapehUnits.'</td>';
		
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=7 AND syid=$syid AND lrn='$lrn' AND gradingperiod=1";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$mapehGradeFirst = $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $mapehGradeFirst >=grademin AND $mapehGradeFirst<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalMapeh=$totalMapeh+1;
						}
					}
				}
			}
			else
			{
				$grade="";
				$mapehGradeFirst=0;
				echo '<td align=center>'."".'</td>';
			}
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=7 AND syid=$syid AND lrn='$lrn' AND gradingperiod=2";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$mapehGradeSecond= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $mapehGradeSecond >=grademin AND $mapehGradeSecond<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalMapeh=$totalMapeh+1;
						}
					}
				}
			}
			else
			{
				$mapehGradeSecond=0;
				echo '<td align=center>'."".'</td>';
			}			
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=7 AND syid=$syid AND lrn='$lrn' AND gradingperiod=3";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$mapehGradeThird= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $mapehGradeThird >=grademin AND $mapehGradeThird<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalMapeh=$totalMapeh+1;
						}
					}
				}
			}
			else
			{
				$mapehGradeThird=0;
				echo '<td align=center>'."".'</td>';
			}			

			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=7 AND syid=$syid AND lrn='$lrn' AND gradingperiod=4";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$mapehGradeFourth= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $mapehGradeFourth >=grademin AND $mapehGradeFourth<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalMapeh=$totalMapeh+1;
						}
					}
				}
			}
			else
			{
				$mapehGradeFourth=0;
				echo '<td align=center>'."".'</td>';
			}				
			
			if ($totalMapeh>0)
			{
				$finalGradeMapeh = ($mapehGradeFirst + $mapehGradeSecond + $mapehGradeThird + $mapehGradeFourth)/$totalMapeh;
				$finalGradeMapeh = round($finalGradeMapeh,0);
				echo '<td align=center>'.$finalGradeMapeh.'</td>';
				if($finalGradeMapeh>=75)
				{
					$remarks="Passed";
				}
				else
				{
					$remarks="Failed";
				}
				echo '<td align=center>'.$remarks.'</td>';
			}
			else
			{
				echo '<td></td>';
				echo '<td></td>';
			}			
?>
		</tr>	
		<tr>
<?php
			$query="SELECT subjectname, units FROM subjectmaster WHERE subjectid=8";
			$result=mysql_query($query);
			while($row=mysql_fetch_array($result))
			{
				$epUnits = $row['units'];
				$subjectname = $row['subjectname'];
			}
			echo '<td>'.$subjectname.'</td>';
			echo '<td align=center>'.$epUnits.'</td>';
		
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=8 AND syid=$syid AND lrn='$lrn' AND gradingperiod=1";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$epGradeFirst = $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $epGradeFirst >=grademin AND $epGradeFirst<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalEp=$totalEp+1;
						}
					}
				}
			}
			else
			{
				$grade="";
				$epGradeFirst=0;
				echo '<td align=center>'."".'</td>';
			}
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=8 AND syid=$syid AND lrn='$lrn' AND gradingperiod=2";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$epGradeSecond= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $epGradeSecond >=grademin AND $epGradeSecond<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalEp=$totalEp+1;
						}
					}
				}
			}
			else
			{
				$epGradeSecond=0;
				echo '<td align=center>'."".'</td>';
			}			
			
			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=8 AND syid=$syid AND lrn='$lrn' AND gradingperiod=3";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$epGradeThird= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $epGradeThird >=grademin AND $epGradeThird<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalEp=$totalEp+1;
						}
					}
				}
			}
			else
			{
				$epGradeThird=0;
				echo '<td align=center>'."".'</td>';
			}			

			$query="SELECT finalgrade FROM gradetxn WHERE subjectid=8 AND syid=$syid AND lrn='$lrn' AND gradingperiod=4";
			$result=mysql_query($query);
			$total = mysql_num_rows($result);
			
			if ($total>0)
			{
				while($row=mysql_fetch_array($result))
				{
					$epGradeFourth= $row['finalgrade'];
					$query="SELECT * FROM gradingconversion WHERE $epGradeFourth >=grademin AND $epGradeFourth<=grademax";
					$result=mysql_query($query);
					$tot = mysql_num_rows($result);
					if($tot>0)
					{
						while($row=mysql_fetch_array($result))
						{
							$grade=$row['conversionletter'];
							echo '<td align=center>'.$grade.'</td>';
							$totalEp=$totalEp+1;
						}
					}
				}
			}
			else
			{
				$epGradeFourth=0;
				echo '<td align=center>'."".'</td>';
			}				
			
			if ($totalEp>0)
			{
				$finalGradeEp = ($epGradeFirst + $epGradeSecond + $epGradeThird + $epGradeFourth)/$totalEp;
				$finalGradeEp = round($finalGradeEp,0);
				echo '<td align=center>'.$finalGradeEp.'</td>';
				if($finalGradeEp>=75)
				{
					$remarks="Passed";
				}
				else
				{
					$remarks="Failed";
				}
				echo '<td align=center>'.$remarks.'</td>';
			}
			else
			{
				echo '<td></td>';
				echo '<td></td>';
			}			
?>
		</tr>			
		<tr>
			<td colspan=6 align=right><strong>Average:</strong></td>
<?php
			if($finalGradeFilipino>0)
			{
				$totalSub = $totalSub+1;
			}
			if($finalGradeEnglish>0)
			{
				$totalSub = $totalSub+1;
			}
			if($finalGradeMath>0)
			{
				$totalSub = $totalSub+1;
			}
			if($finalGradeSci>0)
			{
				$totalSub = $totalSub+1;
			}
			if($finalGradeAp>0)
			{
				$totalSub = $totalSub+1;
			}
			if($finalGradeTle>0)
			{
				$totalSub = $totalSub+1;
			}
			if($finalGradeMapeh>0)
			{
				$totalSub = $totalSub+1;
			}
			if($finalGradeEp>0)
			{
				$totalSub = $totalSub+1;
			}
			
			$genave=$finalGradeFilipino + $finalGradeEnglish + $finalGradeMath + $finalGradeSci + $finalGradeAp + $finalGradeTle + $finalGradeMapeh + $finalGradeEp;
			if($totalSub>0)
			{
				$ave=$genave/$totalSub;
				$ave=round($ave,0);
			}
			else
			{
				$ave="";
			}
			
			if($ave>=75)
			{
				$remarks="Passed";
			}
			else
			{
				$remarks="Failed";
			}
	
			if($totalSub>0)
			{
?>
			<td align=center><strong><?php echo $ave; ?></strong></td>
			<td align=center><strong><?php echo $remarks; ?></strong></td>
<?php
			}
			else
			{
?>
			<td></td>
			<td></td>
<?php
			}
?>
		</tr>
<?php	
	

		
	}
	
	function displayGradeLevelDesc($gradeid)
	{
		$query="SELECT * FROM gradelevelmaster WHERE gradeid=$gradeid";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			echo "Grade ".$row['description'];
		}
	}

	function displayPeriodName($periodid)
	{
		$query="SELECT * FROM gradingperiodmaster WHERE periodid=$periodid";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			echo $row['description']." Grading Period";
		}
	}
	
	function displaySubjectsGrade($userid, $gradeid,$syid)
	{
		$query="SELECT lrn FROM studentmaster WHERE userid=$userid";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$lrn=$row['lrn'];
		}
 	
		$query="SELECT gpm.description as GradingPeriod, gpm.periodid FROM gradingperiodmaster as gpm, gradetxn as gt WHERE gt.gradingperiod=gpm.periodid AND gt.lrn='$lrn' AND gt.gradeid=$gradeid  AND gt.syid=$syid GROUP BY gt.lrn, gt.gradingperiod, gt.syid";
		echo $query;
		$result=mysql_query($query);
		while ($row=mysql_fetch_array($result))
		{
?>
		<tr>
			<td width=205 align="center"><?php echo $row['GradingPeriod']." Grading Period"; ?></td>
			<td width=205 align="center"><a href="student_view_grade_details.php?periodid=<?php echo $row['periodid']; ?>&&lrn=<?php echo $lrn; ?>&&syid=<?php echo $syid; ?>&&gradeid=<?php echo $gradeid; ?>" class="myLinks"><img height=15 width=15 src="images/View.png" alt="View Grades"/>&nbsp;&nbsp;View</a></td>
		</tr>
<?php		
		}
	}
	
	function GetStudentGradeLevel($userid)
	{
	$q="SELECT lrn FROM studentmaster WHERE userid=$userid";
	$res=mysql_query($q);
	while($row1=mysql_fetch_array($res))
	{
		$lrn=$row1['lrn'];
	}				
	
		$query="SELECT lrn FROM studentmaster WHERE userid=$userid";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$lrn=$row['lrn'];
		}
		
		$query="SELECT glm.gradeid, glm.description,sym.syid, sym.syname as schoolyear FROM gradetxn as gt,  gradelevelmaster as glm, schoolyearmaster as sym WHERE gt.gradeid=glm.gradeid AND gt.syid=sym.syid AND gt.lrn='$lrn' group by gt.lrn, gt.gradeid";
		$result=mysql_query($query);
		$totalGrade=mysql_num_rows($result);
		if($totalGrade==0)
		{
?>
		<tr>
			<td align "center" colspan=3>You don't have grades uploaded yet.</td>
		<tr>
<?php
		}
		else
		{

			while($row=mysql_fetch_array($result))
			{
?>
				<tr>
					<td align="center"><?php echo "Grade ".$row['description']; ?></td>
					<td align="center"><?php echo $row['schoolyear']; ?></td>
					<td align="center"><a href="student_view_grade_details.php?gradeid=<?php echo $row['gradeid']; ?>&&syid=<?php echo $row['syid']; ?>&&lrn=<?php echo $lrn; ?>" class="myLinks"><img height=15 width=15 src="images/View.png" alt="View Grades"/>&nbsp;&nbsp;View</a></td>
				</tr>
<?php
			}
		}
	}
	
	function GetStudentName($lrn)
	{
		$query="SELECT um.fname, um.mname, um.lname FROM usermaster as um, studentmaster as sm WHERE um.userid=sm.userid AND sm.lrn='$lrn'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$studentname = $row['lname'].", ".$row['fname']." ".$row['mname'];
			echo $studentname;
		}
	}
	
	function displayStudentGradeDetails($lrn)
	{
		$query="SELECT sm.lrn, um.fname, um.mname, um.lname, sbm.subjectname, gp.description as GradingPeriod, glm.description as GradeLevel, sec.section, gt.finalgrade FROM usermaster as um, studentmaster as sm, gradetxn as gt, gradingperiodmaster as gp, subjectmaster as sbm, gradelevelmaster as glm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.lrn=gt.lrn AND gt.subjectid=sbm.subjectid AND gt.gradingperiod=gp.periodid AND gt.gradeid=glm.gradeid AND sm.gradeid=gt.gradeid AND sec.sectionid=sm.sectionid AND gt.lrn='$lrn' ";
		$result=mysql_query($query);
?>
		<table class="PreRegMasterList" width="1500" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=22 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Grade Breakdown</font></strong></div></td>			
		<tr>
			<th>Grading Period</th>
			<th>Subject</th>
			<th>Final Grade</th>
			<th>Remarks</th>
		</tr>
<?php
		while($row=mysql_fetch_array($result))
		{
			$gradingperiod=$row['GradingPeriod'];
			$subjectname=$row['subjectname'];
			$finalGrade= $row['finalgrade'];
			if ($finalGrade>=75)
			{
				$remarks="PASSED";
			}
			else
			{
				$remarks="FAILED";
			}
?>
			<tr>
				<td align="center"><?php echo $gradingperiod;  ?></td>
				<td align="center"><?php echo $subjectname;  ?></td>
				<td align="center"><?php echo $finalGrade;  ?></td>
				<td align="center"><?php echo $remarks;  ?></td>
			</tr>
<?php			
		}
?>
		</table>
<?php
	}

	function displayStudentGradeBreakdown($txnid)
	{
		$query="SELECT sm.lrn, um.fname, um.mname, um.lname, sbm.subjectname, gp.description as GradingPeriod, glm.description as GradeLevel, sec.section, gt.project,   gt.projectpercent, gt.quiz, gt.quizpercent, gt.assignment, gt.assignmentpercent, gt.attendance, gt.attendancepercent, gt.exam, gt.exampercent, gt.extracurricular, gt.extracurricularpercent, gt.subjectid,gt.gradeid,gt.gradingperiod, gt.uploadedby, gt.adddate FROM usermaster as um, studentmaster as sm, gradetxn as gt, gradingperiodmaster as gp, subjectmaster as sbm, gradelevelmaster as glm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.lrn=gt.lrn AND gt.subjectid=sbm.subjectid AND gt.gradingperiod=gp.periodid AND gt.gradeid=glm.gradeid AND sec.sectionid=sm.sectionid AND gt.gradetxnid=$txnid";
		$result=mysql_query($query);
?>
		<table class="PreRegMasterList" width="1500" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=22 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Grade Breakdown</font></strong></div></td>			
		<tr>
			<th>Grading Period</th>
			<th>Subject</th>
			<th>Assignment</th>
			<th>%</th>
			<th>Total</th>
			<th>Attendance</th>
			<th>%</th>
			<th>Total</th>
			<th>Project</th>
			<th>%</th>
			<th>Total</th>
			<th>Quiz</th>
			<th>%</th>
			<th>Total</th>
			<th>Exam</th>
			<th>%</th>
			<th>Total</th>
			<th>Extra Curricular</th>
			<th>%</th>
			<th>Total</th>
			<th>Final Grade</th>
			<th>Remarks</th>
		</tr>
<?php
		while($row=mysql_fetch_array($result))
		{
			$gradingperiod=$row['GradingPeriod'];
			$subjectname=$row['subjectname'];
			$assignment=$row['assignment'];
			$assignmentpercent=$row['assignmentpercent'];
			$assignmentTotal=$assignment*($assignmentpercent/100);
			$attendance=$row['attendance'];
			$attendancepercent=$row['attendancepercent'];
			$attendanceTotal=$attendance*($attendancepercent/100);
			$project=$row['project'];
			$projectpercent=$row['projectpercent'];
			$projectTotal=$project*($projectpercent/100);
			$quiz=$row['quiz'];
			$quizpercent=$row['quizpercent'];
			$quizTotal=$quiz*($quizpercent/100);
			$exam=$row['exam'];
			$exampercent=$row['exampercent'];
			$examTotal=$exam*($exampercent/100);
			$extracurricular=$row['extracurricular'];
			$extracurricularpercent=$row['extracurricularpercent'];
			$extracurricularTotal=$extracurricular*($extracurricularpercent/100);
			$finalGrade= $assignmentTotal + $attendanceTotal + $projectTotal + $quizTotal + $examTotal + $extracurricularTotal;
			if ($finalGrade>=75)
			{
				$remarks="PASSED";
			}
			else
			{
				$remarks="FAILED";
			}
?>
			<tr>
				<td align="center"><?php echo $gradingperiod;  ?></td>
				<td align="center"><?php echo $subjectname;  ?></td>
				<td align="center"><?php echo $assignment;  ?></td>
				<td align="center"><?php echo $assignmentpercent;  ?></td>
				<td align="center"><?php echo $assignmentTotal;  ?></td>
				<td align="center"><?php echo $attendance;  ?></td>
				<td align="center"><?php echo $attendancepercent;  ?></td>
				<td align="center"><?php echo $attendanceTotal;  ?></td>
				<td align="center"><?php echo $project;  ?></td>
				<td align="center"><?php echo $projectpercent;  ?></td>
				<td align="center"><?php echo $projectTotal;  ?></td>
				<td align="center"><?php echo $quiz;  ?></td>
				<td align="center"><?php echo $quizpercent;  ?></td>
				<td align="center"><?php echo $quizTotal;  ?></td>
				<td align="center"><?php echo $exam;  ?></td>
				<td align="center"><?php echo $exampercent;  ?></td>
				<td align="center"><?php echo $examTotal;  ?></td>
				<td align="center"><?php echo $extracurricular;  ?></td>
				<td align="center"><?php echo $extracurricularpercent;  ?></td>
				<td align="center"><?php echo $extracurricularTotal;  ?></td>
				<td align="center"><?php echo $finalGrade;  ?></td>
				<td align="center"><?php echo $remarks;  ?></td>
			</tr>
<?php			
		}
?>
		</table>
<?php
	}
	
	
	function displayStudentGrades()
	{
		$per_page=7;
		if(empty($_GET['criteria']))
		{
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, sbm.subjectname, gp.description as GradingPeriod, glm.description as GradeLevel, sec.section, gt.subjectid,gt.gradeid,gt.gradingperiod, gt.uploadedby, gt.adddate FROM usermaster as um, studentmaster as sm, gradetxn as gt, gradingperiodmaster as gp, subjectmaster as sbm, gradelevelmaster as glm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.lrn=gt.lrn AND gt.subjectid=sbm.subjectid AND gt.gradingperiod=gp.periodid AND gt.gradeid=glm.gradeid AND sec.sectionid=sm.sectionid AND uploadedby= $_SESSION[userid] GROUP BY gt.lrn";
		}
		if(!empty($_GET['criteria']))
		{
			$keyword=$_GET['keyword'];
			$criteria=$_GET['criteria'];
			if ($criteria=="gradeid")
			{
				$q="SELECT gradeid FROM gradelevelmaster WHERE description='$keyword'";
				$res=mysql_query($q);
				$tt = mysql_num_rows($res);
				if($tt==0)
				{
					$g="0";
				}
				else
				{
					while($r=mysql_fetch_array($res))
					{
						$g=$r['gradeid'];
					}
					$keyword=$g;
				}
			}
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, sbm.subjectname, gp.description as GradingPeriod, glm.description as GradeLevel, sec.section, gt.subjectid,gt.gradeid,gt.gradingperiod, gt.uploadedby, gt.adddate FROM usermaster as um, studentmaster as sm, gradetxn as gt, gradingperiodmaster as gp, subjectmaster as sbm, gradelevelmaster as glm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.lrn=gt.lrn AND gt.subjectid=sbm.subjectid AND gt.gradingperiod=gp.periodid AND gt.gradeid=glm.gradeid AND sec.sectionid=sm.sectionid AND gt.gradeid=glm.gradeid AND gt.$criteria LIKE '%$keyword%' order by gt.lrn";
		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}

?>
		<table class="PreRegMasterList" width="640" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=7 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		
		if($total_results==0)
		{
			echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
			echo "<tr>";
			echo '<td colspan=7  align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
				echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			
					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lrn') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'GradeLevel') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'section') .'</td>';
					echo '<td width="150" align="center"><a class="myLinks" href="faculty_view_student_grade_details.php?id='. mysql_result($result,$i,'lrn') .'"><img height=15 width=15 src="images/View.png" alt="View Grades"/>&nbsp;&nbsp;View</a></td>';
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
					echo '<td colspan=7 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					if(empty($_GET['keyword']) && empty($_GET['criteria']))
					{
					echo "<a href='view_student_grade.php?page=$i' class='myLinks'>$i</a>";
					}
					else
					{
					echo "<a href='view_student_grade.php?page=$i&&keyword=$keyword&&criteria=$criteria' class='myLinks'>$i</a>";
					}
				}
			}
		}
?>
		</table>
	<br/>	

<?php			
}	

	function displaySchoolYear()
	{
		$query="SELECT * FROM schoolyearmaster";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
?>
			<option value="<?php echo $row['syid']; ?>"><?php echo $row['syname']; ?></option>
<?php
		}
	}

	
	function displayGradingPeriod()
	{
		$query="SELECT * FROM gradingperiodmaster ORDER BY periodid ASC";
		$result=mysql_query($query);
		$totalRes=mysql_num_rows($result);
		if($totalRes==0)
		{
?>
			<option>No Data found.</option>
<?php
		}
		else
		{
			while($row=mysql_fetch_array($result))
			{
?>			
			<option value="<?php echo $row['periodid']; ?>"><?php echo $row['description']; ?></option>
<?php
			}
		}
	}
	
	function displaySubjectUpload()
	{
	$q="SELECT subjectid, subjectname from subjectmaster where gradeid=1";
	$res=mysql_query($q);

	while ($row=mysql_fetch_array($res))
	{
	?>
		<option value="<?php echo($row['subjectid']); ?>"><?php echo($row['subjectname']); ?></option>
	<?php
	}	
	}

	function displaySubjectMasterlist()
	{
		if(empty($_GET['page']))
		{
			$query="SELECT glm.gradeid, sm.units, sm.subjectid, glm.description, sm.subjectname FROM subjectmaster as sm, gradelevelmaster as glm WHERE sm.gradeid=glm.gradeid ORDER BY CONVERT(glm.description,UNSIGNED INTEGER), sm.subjectname ASC";
		}
		if(!empty($_GET['page']))
		{
			$query="SELECT glm.gradeid, sm.units, sm.subjectid, glm.description, sm.subjectname FROM subjectmaster as sm, gradelevelmaster as glm WHERE sm.gradeid=glm.gradeid ORDER BY CONVERT(glm.description,UNSIGNED INTEGER), sm.subjectname ASC";
		}
		$result=mysql_query($query);
		$t=mysql_num_rows($result);
		if($t==0)
		{
?>
		<tr>
			<td align="center" colspan=9><strong>No data found.</strong></td>
		</tr>
<?php
		}
		else
		{
			$per_page=3;
			$result=mysql_query($query);
			$total_results=mysql_num_rows($result);
			$total_pages=ceil($total_results/$per_page);

			if (isset($_GET['page']) && is_numeric($_GET['page']))
			{
				$show_page=$_GET['page'];
				if($show_page>0 && $show_page<=$total_pages)
				{
					$start=($show_page-1)*$per_page;
					$end= $start+$per_page;
				}
				else
				{
					$start=0;
					$end=$per_page;
				}
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
			if($total_results==0)
			{
?>
				<tr>
					<td align="center" colspan=8><strong>No data found.</strong></td>
				</tr>
<?php
			}
			else
			{
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
					$subjectid=mysql_result($result,$i,'subjectid');
					$gradeid=mysql_result($result,$i,'gradeid');
					echo "<tr>";
					//echo '<td align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'units') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'subjectname') .'</td>';

?>
					<td colspan=2 align="center"><a class="myLinks" onclick="updateSubject(<?php echo($gradeid); ?>,<?php echo($subjectid); ?>); return false;" href=""><img src="images/Modify.ico">&nbsp;&nbsp;Edit</a></td>
<?php
					echo "</tr>";			
				}
			}
		}		
	}
	
	
	function displayPageSubjectMasterlist()
	{
		$query="SELECT glm.gradeid, sm.subjectid, glm.description, sm.subjectname FROM subjectmaster as sm, gradelevelmaster as glm WHERE sm.gradeid=glm.gradeid";
		$res=mysql_query($query);
		$per_page=3;
		$total_results=mysql_num_rows($res);
		$total_pages=ceil($total_results/$per_page);	
		if($total_results>1)
		{
			echo "Page:";
			for($i=1; $i<=$total_pages; $i++)
			{
				echo "<a href='subject_management.php?page=$i' class='myLinks'>$i</a>";
			}
		}
	}
	
	function displayGradeLevelSectionMasterlist()
	{
		if(empty($_GET['page']))
		{
			$query="SELECT sm.gradeid, sm.sectionid, glm.description, sm.section, sm.maxcount, sm.actualcount, sm.maxcount-sm.actualcount as vacant  FROM gradelevelmaster as glm, sectionmaster as sm WHERE glm.gradeid=sm.gradeid ORDER BY glm.gradeid, sm.section ASC";
		}
		if(!empty($_GET['page']))
		{
			$query="SELECT sm.gradeid, sm.sectionid, glm.description, sm.section, sm.maxcount, sm.actualcount, sm.maxcount-sm.actualcount as vacant  FROM gradelevelmaster as glm, sectionmaster as sm WHERE glm.gradeid=sm.gradeid ORDER BY glm.gradeid, sm.section ASC";
		}
		
		
		$result=mysql_query($query);
		$t=mysql_num_rows($result);
		if($t==0)
		{
?>
		<tr>
			<td align="center" colspan=7><strong>No data found.</strong></td>
		</tr>
<?php
		}
		else
		{
			$per_page=4;
			$result=mysql_query($query);
			$total_results=mysql_num_rows($result);
			$total_pages=ceil($total_results/$per_page);

			if (isset($_GET['page']) && is_numeric($_GET['page']))
			{
				$show_page=$_GET['page'];
				if($show_page>0 && $show_page<=$total_pages)
				{
					$start=($show_page-1)*$per_page;
					$end= $start+$per_page;
				}
				else
				{
					$start=0;
					$end=$per_page;
				}
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
			if($total_results==0)
			{
?>
				<tr>
					<td align="center" colspan=7><strong>No data found.</strong></td>
				</tr>
<?php
			}
			else
			{
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
					$grade=mysql_result($result,$i,'gradeid');
					$sectionid=mysql_result($result,$i,'sectionid');
					echo "<tr>";
					echo '<td align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'section') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'maxcount') .'</td>';
					
					$q="SELECT * FROM studentmaster WHERE sex=0 and gradeid=$grade and sectionid=$sectionid";
					$res=mysql_query($q);
					$totalMale=mysql_num_rows($res);

					if($totalMale==0)
					{
						echo '<td align="center">'.$totalMale.'</td>';
					}
					else
					{
?>
						<td align="center"><a title="Click to View" href="view_gender_section.php?gradeid=<?php echo($grade); ?>&&sectionid=<?php echo($sectionid); ?>&&gender=0" class="myLinks" target="_blank"><?php echo $totalMale; ?></a></td>
<?php
					}
					
					
					
					$q="SELECT * FROM studentmaster WHERE sex=1 and gradeid=$grade and sectionid=$sectionid";
					$res=mysql_query($q);
					$totalFemale=mysql_num_rows($res);

					if($totalFemale==0)
					{
						echo '<td align="center">'.$totalFemale.'</td>';
					}
					else
					{
?>
						<td align="center"><a title="Click to View" href="view_gender_section.php?gradeid=<?php echo($grade); ?>&&sectionid=<?php echo($sectionid); ?>&&gender=1" class="myLinks" target="_blank"><?php echo $totalFemale; ?></a></td>
<?php
					}
					
					
					if(mysql_result($result,$i,'actualcount')==0)
					{
						echo '<td align="center">'. mysql_result($result,$i,'actualcount') .'</td>';
					}
					else
					{
?>
						<td align="center"><a title="Click to View" href="view_section_student.php?gradeid=<?php echo($grade); ?>&&sectionid=<?php echo($sectionid); ?>" class="myLinks" target="_blank"><?php echo( mysql_result($result,$i,'actualcount')); ?></a></td>
<?php
					}
					echo '<td align="center">'. mysql_result($result,$i,'vacant') .'</td>';
					?>
					<td align="center"><a class="myLinks" onclick="updateSection(<?php echo($grade); ?>,<?php echo($sectionid); ?>); return false;" href=""><img src="images/Modify.ico">&nbsp;&nbsp;Edit</a></td>
					<td align="center"><a class="myLinks" onclick="return confirm('Are you sure you want to delete this section level?'); return false;" href="delete_section_exec.php?gradeid=<?php echo($grade); ?>&&sectionid=<?php echo($sectionid); ?>"><img src="images/delete.ico">&nbsp;&nbsp;Delete</a></td>
					<?php
					echo "</tr>";			
				}
			}
		}		
	}

	function displayPageGradeLevelSection()
	{
		$query="SELECT sm.gradeid, sm.sectionid, glm.description, sm.section, sm.maxcount, sm.actualcount, sm.maxcount-sm.actualcount as vacant  FROM gradelevelmaster as glm, sectionmaster as sm WHERE glm.gradeid=sm.gradeid ORDER BY glm.gradeid, sm.sectionid ASC";
		$res=mysql_query($query);
		$per_page=4;
		$total_results=mysql_num_rows($res);
		$total_pages=ceil($total_results/$per_page);	
		if($total_results>1)
		{
			echo "Page:";
			for($i=1; $i<=$total_pages; $i++)
			{
				echo "<a href='section_management.php?page=$i' class='myLinks'>$i</a>";
			}
		}
	}

	function displayGradeLevelMasterlist()
	{
		if(empty($_GET['page']))
		{
			$query="SELECT * FROM gradelevelmaster";
		}
		if(!empty($_GET['page']))
		{
			$query="SELECT * FROM gradelevelmaster";
		}
		
		$result=mysql_query($query);
		$t=mysql_num_rows($result);
		if($t==0)
		{
?>
		<tr>
			<td align="center" colspan=4><strong>No data found.</strong></td>
		</tr>
<?php
		}
		else
		{
			$per_page=5;
			$result=mysql_query($query);
			$total_results=mysql_num_rows($result);
			$total_pages=ceil($total_results/$per_page);

			if (isset($_GET['page']) && is_numeric($_GET['page']))
			{
				$show_page=$_GET['page'];
				if($show_page>0 && $show_page<=$total_pages)
				{
					$start=($show_page-1)*$per_page;
					$end= $start+$per_page;
				}
				else
				{
					$start=0;
					$end=$per_page;
				}
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
			if($total_results==0)
			{
?>
				<tr>
					<td align="center" colspan=4><strong>No data found.</strong></td>
				</tr>
<?php
			}
			else
			{
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
					$grade=mysql_result($result,$i,'gradeid');
					$q1="SELECT * FROM studentmaster WHERE gradeid=$grade AND sectionid NOT IN ('0','')";
					$res=mysql_query($q1);
					$tot=mysql_num_rows($res);

					echo "<tr>";
					echo '<td align="center">'. mysql_result($result,$i,'gradeid') .'</td>';
					if($tot==0)
					{
						echo '<td align="center">'. mysql_result($result,$i,'description') .'</td>';
					}
					else
					{
?>
						<td align="center"><a title="Click to View" href="view_grade_student.php?gradeid=<?php echo($grade); ?>" class="myLinks" target="_blank"><?php echo( mysql_result($result,$i,'description')); ?></a></td>
<?php
					}
					?>
					<td align="center"><a class="myLinks" onclick="updateGradeLevel(<?php echo($grade); ?>); return false;" href=""><img src="images/Modify.ico">&nbsp;&nbsp;Edit</a></td>
					<?php
					echo "</tr>";			
				}
			}
		}		
	}

	function displaySYMasterlist()
	{
		if(empty($_GET['page']))
		{
			$query="SELECT * FROM schoolyearmaster ORDER BY syid ASC";
		}
		if(!empty($_GET['page']))
		{
			$query="SELECT * FROM schoolyearmaster ORDER BY syid ASC";
		}
		
		$result=mysql_query($query);
		$t=mysql_num_rows($result);
		if($t==0)
		{
?>
		<tr>
			<td align="center" colspan=4><strong>No data found.</strong></td>
		</tr>
<?php
		}
		else
		{
			$per_page=5;
			$result=mysql_query($query);
			$total_results=mysql_num_rows($result);
			$total_pages=ceil($total_results/$per_page);

			if (isset($_GET['page']) && is_numeric($_GET['page']))
			{
				$show_page=$_GET['page'];
				if($show_page>0 && $show_page<=$total_pages)
				{
					$start=($show_page-1)*$per_page;
					$end= $start+$per_page;
				}
				else
				{
					$start=0;
					$end=$per_page;
				}
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
			if($total_results==0)
			{
?>
				<tr>
					<td align="center" colspan=4><strong>No data found.</strong></td>
				</tr>
<?php
			}
			else
			{
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
					$syid=mysql_result($result,$i,'syid');
					$status=mysql_result($result,$i,'status');
					if($status=='1')
					{
						$stat="Active";
					}
					else
					{
						$stat="Inactive";
					}
					echo "<tr>";
					
					$q="SELECT um.fname, um.mname, um.lname, gt.lrn FROM usermaster as um, gradetxn as gt, studentmaster as sm WHERE um.userid=sm.userid AND sm.lrn=gt.lrn AND gt.syid= $syid GROUP BY gt.lrn  ORDER BY um.lname asc ";
					$res=mysql_query($q);
					$totRow = mysql_num_rows($res);
					
					if($totRow==0)
					{
						echo '<td align="center">'. mysql_result($result,$i,'syname') .'</td>';
					}
					else
					{
?>
						<td align="center"><a title="Click to View" href="view_sy_student.php?syid=<?php echo($syid); ?>" class="myLinks" target="_blank"><?php echo( mysql_result($result,$i,'syname')); ?></a></td>
<?php						
					}
					
					
					echo '<td align="center">'. $stat .'</td>';
					?>
					<td align="center"><a class="myLinks" onclick="updateSY(<?php echo($syid); ?>); return false;" href=""><img src="images/Modify.ico">&nbsp;&nbsp;Edit</a></td>
					<td align="center"><a class="myLinks" onclick="makeDefault(<?php echo($syid); ?>); return false;" href=""><img src="images/Modify.ico">&nbsp;&nbsp;Set</a></td>

					<?php
					echo "</tr>";			
				}
			}
		}		
	}

	function displaySubjectsFaculty($userid,$gradeid,$sectionid)
	{
		$query="SELECT employeeid FROM facultymaster WHERE userid=$userid";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{	
			$eid=$row['employeeid'];
		}
		
		$query="SELECT subjectid, subjectname FROM subjectmaster WHERE subjectid IN (SELECT subjectid FROM facultysubjectmaster WHERE employeeid='$eid' AND gradeid=$gradeid AND sectionid=$sectionid) GROUP BY subjectid ORDER BY subjectname ASC";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{	
?>
			<option value="<?php echo($row['subjectid']); ?>"><?php echo($row['subjectname']); ?></option>
<?php
		}
	}
	
	function displayCurrentSY()
	{
		$query="SELECT syname FROM schoolyearmaster WHERE status=1";
		$result=mysql_query($query);
		$total = mysql_num_rows($result);
		$syname="";
		if($total==1)
		{
			while($row=mysql_fetch_array($result))
			{
				$syname=$row['syname'];
			}
		}
		else
		{
			$syname="";
		}
		echo $syname;
	}
	
	function displayCurrentGL($gradeid)
	{
		$query="SELECT description FROM gradelevelmaster WHERE gradeid=$gradeid";
		$result=mysql_query($query);
		$total = mysql_num_rows($result);
		$gl="";
		if($total==1)
		{
			while($row=mysql_fetch_array($result))
			{
				$gl=$row['description'];
			}
		}
		else
		{
			$gl="";
		}
		echo $gl;
	}	
	
	function displayStudentInputGrade($gradeid,$secid,$subjectid,$periodid,$syid)
	{
		$query="SELECT sm.lrn, um.lname, um.fname, um.mname FROM usermaster as um, studentmaster as sm WHERE um.userid=sm.userid AND sm.gradeid=$gradeid and sm.sectionid=$secid ORDER BY um.lname, um.fname, um.lname ASC ";
		$result=mysql_query($query);
		$total = mysql_num_rows($result);;
?>
			<table class="curvedEdges" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">		
			<td colspan=3 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Input Grade</font></strong></div></td>
<?php
		if($total>0)
		{
?>
			<tr>
				<td align="center" >LRN</td><td align="center" >Student Name</td><td align="center">Final Grade</td>
			</tr>	
<?php
			$i=0;
			$withGrade = 0;
			while($row=mysql_fetch_array($result))
			{
				$lrn=$row['lrn'];
				$lname=$row['lname'];
				$mname=$row['mname'];
				$fname=$row['fname'];
				
				$sql = "SELECT * FROM gradetxn WHERE lrn='$lrn' AND subjectid =$subjectid AND gradeid=$gradeid AND gradingperiod=$periodid AND syid=$syid";
				$res = mysql_query($sql);
				$tot = mysql_num_rows($res);
				if($tot==0)
				{
?>
					<tr>
					<td width="200" align="center"><?php echo $lrn; ?></td>
					<td width="220"><?php echo $lname.", ".$fname." ".$mname; ?></td>
					<td width="200" align="center"><input autofocus type="text" name="fg[]"></td>
					</tr>
					<input type="hidden" name="lrn[]" value="<?php echo $lrn; ?>"> 
<?php
					$withGrade=$withGrade + 1;
				}
				else
				{
					while($row1=mysql_fetch_array($res))
					{
						$fg=$row1['finalgrade'];
					}
					if($fg>0)
					{
?>					<tr>
					<td width="200" align="center"><?php echo $lrn; ?></td>
					<td width="220"><?php echo $lname.", ".$fname." ".$mname; ?></td>
					<td width="200" align="center"><?php echo $fg; ?></td>
					</tr>
<?php					
					}	
					else
					{
?>
					<tr>
					<td width="200" align="center"><?php echo $lrn; ?></td>
					<td width="220"><?php echo $lname.", ".$fname." ".$mname; ?></td>
					<td width="200" align="center"><input autofocus type="text" name="fg[]"></td>
					</tr>
					<input type="hidden" name="lrn[]" value="<?php echo $lrn; ?>"> 
<?php					
					$withGrade=$withGrade + 1;
					}
					
					
				}
			}
			if($withGrade>0)
			{
?>
				<td colspan=3 align="right"><input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Upload">&nbsp;&nbsp;&nbsp;<input style="width: 60px; height: 30px;" type="reset" name="reset" id="reset" value="Clear"></td>
<?php
			}
		}
		else
		{
?>
			<tr>
			<td colspan=3 align="center">No student found.</td>
			</tr>
<?php
		}
?>
	</table>
	<br> 	
<a href="upload_grade.php" class="myLinks"><< Go Back</a>
<?php
	}
	
	function displayCurrentSec($gradeid,$secid)
	{
		$query="SELECT section FROM sectionmaster WHERE gradeid=$gradeid AND sectionid=$secid";
		$result=mysql_query($query);
		$total = mysql_num_rows($result);
		$sec="";
		if($total==1)
		{
			while($row=mysql_fetch_array($result))
			{
				$sec=$row['section'];
			}
		}
		else
		{
			$sec="";
		}
		echo $sec;
	}		
	
	function displayGradeLevelFaculty($userid)
	{
		$query="SELECT employeeid FROM facultymaster WHERE userid=$userid";
		$result=mysql_query($query);
		$rows = mysql_num_rows($result);
		if($rows==0) //Emp not found
		{
?>
		<script type="text/javascript">
			alert('Employee Id not found.');
			window.location="upload_grade.php";
		</script>	
<?php
		}
		else
		{
			while($row=mysql_fetch_array($result))
			{
				$eid=$row['employeeid'];
			}
			
			$query="SELECT gradeid, description FROM gradelevelmaster WHERE gradeid IN (SELECT gradeid FROM facultysubjectmaster WHERE employeeid = '$eid' GROUP BY gradeid) ORDER BY CONVERT(description,UNSIGNED INTEGER)";
			$result=mysql_query($query);
			$rows = mysql_num_rows($result);	
			if ($rows==0)
			{
			}
			else
			{
				if($rows==0)
				{
?>
					<option>No Data found.</option>
<?php
				}
				else
				{
?>
					<option value="0">Select Grade Level</option>
<?php
					while($row=mysql_fetch_array($result))
					{
?>			
						<option value="<?php echo $row['gradeid']; ?>"><?php echo $row['description']; ?></option>
<?php
					}
				}			
			}
		}
		
	}
	
	function displayPageGradeLevel()
	{
		$query="SELECT * FROM gradelevelmaster";
		$res=mysql_query($query);
		$per_page=5;
		$total_results=mysql_num_rows($res);
		$total_pages=ceil($total_results/$per_page);	
		if($total_results>1)
		{
			echo "Page:";
			for($i=1; $i<=$total_pages; $i++)
			{
				echo "<a href='grade_level_management.php?page=$i' class='myLinks'>$i</a>";
			}
		}
	}
	
	function displayPageSY()
	{
		$query="SELECT * FROM schoolyearmaster ORDER BY syid ASC";
		$res=mysql_query($query);
		$per_page=5;
		$total_results=mysql_num_rows($res);
		$total_pages=ceil($total_results/$per_page);	
		if($total_results>1)
		{
			echo "Page:";
			for($i=1; $i<=$total_pages; $i++)
			{
				echo "<a href='school_year_management.php?page=$i' class='myLinks'>$i</a>";
			}
		}
	}	
	
	function displayAvailableSection($lrn)
	{
		$q="SELECT gradeid,sectionid FROM studentmaster WHERE lrn='$lrn'";
		$res=mysql_query($q);
		while($r=mysql_fetch_array($res))
		{
			$gradeid=$r['gradeid'];
			$sectionid=$r['sectionid'];
		}
		
		$query="SELECT glm.gradeid, sm.sectionid,sm.actualcount, sm.maxcount, glm.description, sm.section, sm.maxcount-sm.actualcount as vacant FROM gradelevelmaster as glm, sectionmaster as sm WHERE glm.gradeid=sm.gradeid AND sm.gradeid=$gradeid ORDER BY glm.gradeid, sm.sectionid ASC";
		$result=mysql_query($query);
?>
		<table class="curvedEdges" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">		
		<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">SELECT SECTION</font></strong></div></td>
		<tr>
			<td align="center" >Option</td><td align="center" >Section</td><td align="center">Max</td><td align="center">Actual</td><td align="center">Vacant</td>
		</tr>							
<?php
		$a=1;
		while ($row=mysql_fetch_array($result))
		{
			$vacant =$row['vacant'];
			if($vacant==0)
			{
				$fontcolor="red";
			}
			else
			{
				$fontcolor="black";
			}
			
			if($a==1)
			{
				$check="checked";
			}
			else
			{
				$check="";
			}
			$a=$a+1;

?>
			<tr>
				<td align="center"><input type="radio" name="sectionid" id="radio" value=<?php echo($row['sectionid']);?> <?php echo($check); ?>></td>
				<td  align="center" ><font color="<?php echo($fontcolor); ?>"><label for="radio"><?php echo($row['section']); ?></font></td>
				<td  align="center"><font color="<?php echo($fontcolor); ?>"><?php echo($row['maxcount']); ?></font></td>
				<td  align="center"><font color="<?php echo($fontcolor); ?>"><?php echo($row['actualcount']); ?></font></td>
				<td  align="center"><font color="<?php echo($fontcolor); ?>"><?php echo($row['maxcount']-$row['actualcount']); ?></font></td>
			</tr>
<?php			
		}
?>
		</table>
<?php
	}
	
	
	function displayStudentSectionInfo($lrn)
	{
		$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec WHERE sm.userid=um.userid AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid AND sm.lrn='$lrn' ORDER BY sm.lrn ASC";
		$result=mysql_query($query);
?>
	<table class="curvedEdges" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
<?php
		
		if(mysql_num_rows($result)>0)
		{
?>
			<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Student Information</font></strong></div></td>	
<?php		
			while($row=mysql_fetch_array($result))
			{
?>
				<tr>
					<td>LRN:</td><td><strong><?php echo($row['lrn']); ?></strong></td>
				</tr>
				<tr>
					<td>Full Name:</td><td><strong><?php echo($row['lname'].", ".$row['fname']." ".$row['mname']); ?></strong></td>
				</tr>
				<tr>
					<td>Grade Level:</td><td><strong><?php echo($row['description']); ?></strong></td>
				</tr>
				<tr>
					<td>Section:</td><td><strong><?php echo($row['section']); ?></strong></td>
				</tr>
<?php				
			}
		}
		else
		{
?>
				<td colspan=2 align="center"><strong>No data found.</strong></td>
<?php
		}
?>
	</table>
<?php
		
	}
	
	function displayStudent($lrn)
	{
		$query="SELECT um.*,sm.*,glm.*,sec.* FROM usermaster AS um, studentmaster AS sm, gradelevelmaster as glm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid AND sm.lrn='$lrn'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$pic=$row['pic'];
			$fname=$row['fname'];
			$mname=$row['mname'];
			$lname=$row['lname'];
			$grade=$row['description'];
			$section=$row['section'];
			$bday=date("F d, Y",strtotime($row['birthday']));
			$age=date_diff(date_create($row['birthday']),date_create('now'))->y; 	
			$sex=$row['sex'];
			if($sex==0)
			{
				$sex="Male";
			}
			else
			{
				$sex="Female";
			}
			$cellno=$row['cellno'];
			$radd=$row['address'];
			$mother=$row['mother'];
			$father=$row['father'];
			$motherocc=$row['motherocc'];
			$fatherocc=$row['fatherocc'];
			$last=$row['lastschoolattended'];
			$schadd=$row['schooladdress'];
		}
		if(mysql_num_rows($result)==0)
		{
?>
			<tr>
				<td bgcolor="#144C69" colspan=26><font size="3px" color="white">&nbsp;</font></td>
			</tr>
			<tr>
				<td colspan=26 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found for LRN:&nbsp;<font color="red" size=4><?php echo($lrn); ?></font></td>
			</tr>
			<tr>
				<td bgcolor="#144C69" colspan=26><font size="3px" color="white">&nbsp;</font></td>
			</tr>
<?php		
		}
		else
		{
?>
			<tr>
				<td bgcolor="#144C69" colspan=26><font size="3px" color="white">&nbsp;</font></td>
			</tr>
			<tr>
				  <td align="center" colspan=3 rowspan="7"><img border=1 src="uploads/<?php echo($pic) ?>" width=160 height=150 /></td>
			</tr>		
			<tr>
				<td class="studentinfo" colspan=2>LRN:</td><td colspan=11><strong><?php echo($lrn); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>First Name:</td><td colspan=11><strong><?php echo($fname); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Middle Name:</td><td colspan=11><strong><?php echo($mname); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Last Name:</td><td colspan=11><strong><?php echo($lname); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Grade:</td><td colspan=11><strong><?php echo($grade); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Section:</td><td colspan=11><strong><?php echo($section); ?></strong></td>
			</tr>
			<tr>
				<td bgcolor="#144C69" colspan=26>&nbsp;</td>
			</tr>		
			<tr>
				<td class="studentinfo" colspan=2>Birthday:</td><td colspan=11><strong><?php echo($bday); ?></strong></td>
				<td class="studentinfo" colspan=2>Sex:</td><td colspan=11><strong><?php echo($sex); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Age:</td><td colspan=11><strong><?php echo($age); ?></strong></td>
				<td class="studentinfo" colspan=2>Contact No.:</td><td colspan=11><strong><?php echo($cellno); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Address:</td><td colspan=24><strong><?php echo($radd); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Mother:</td><td colspan=11><strong><?php echo($mother); ?></strong></td>
				<td class="studentinfo" colspan=2>Occupation:</td><td colspan=11><strong><?php echo($motherocc); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Father:</td><td colspan=11><strong><?php echo($father); ?></strong></td>
				<td class="studentinfo" colspan=2>Occupation:</td><td colspan=11><strong><?php echo($fatherocc); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Last School Attended:</td><td colspan=24><strong><?php echo($last); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Address:</td><td colspan=24><strong><?php echo($schadd); ?></strong></td>
			</tr>
			<tr>
				<td bgcolor="#144C69" colspan=26>&nbsp;</td>
			</tr>		
<?php
		}
	}

	function displayFaculty($employeeid)
	{
		$query="SELECT um.*, em.* FROM usermaster AS um, facultymaster AS em WHERE um.userid=em.userid AND em.employeeid='$employeeid'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$pic=$row['pic'];
			$fname=$row['fname'];
			$mname=$row['mname'];
			$lname=$row['lname'];
			$bday=date("F d, Y",strtotime($row['birthday']));
			$age=date_diff(date_create($row['birthday']),date_create('now'))->y; 	
			$sex=$row['sex'];
			if($sex==0)
			{
				$sex="Male";
			}
			else
			{
				$sex="Female";
			}
			$cellno=$row['cellno'];
			$radd=$row['address'];
		}
		if(mysql_num_rows($result)==0)
		{
?>
			<tr>
				<td bgcolor="#144C69" colspan=26><font size="3px" color="white">&nbsp;</font></td>
			</tr>
			<tr>
				<td colspan=26 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found for Employee No.:&nbsp;<font color="red" size=4><?php echo($employeeid); ?></font></td>
			</tr>
			<tr>
				<td bgcolor="#144C69" colspan=26><font size="3px" color="white">&nbsp;</font></td>
			</tr>
<?php		
		}
		else
		{
?>
			<tr>
				<td bgcolor="#144C69" colspan=26><font size="3px" color="white">&nbsp;</font></td>
			</tr>
			<tr>
				  <td align="center" colspan=3 rowspan="5"><img border=1 src="uploads/<?php echo($pic) ?>" width=160 height=150 /></td>
			</tr>		
			<tr>
				<td class="studentinfo" colspan=2>Employee No:</td><td colspan=11><strong><?php echo($employeeid); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>First Name:</td><td colspan=11><strong><?php echo($fname); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Middle Name:</td><td colspan=11><strong><?php echo($mname); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Last Name:</td><td colspan=11><strong><?php echo($lname); ?></strong></td>
			</tr>
			<tr>
				<td bgcolor="#144C69" colspan=26>&nbsp;</td>
			</tr>		
			<tr>
				<td class="studentinfo" colspan=2>Birthday:</td><td colspan=11><strong><?php echo($bday); ?></strong></td>
				<td class="studentinfo" colspan=2>Sex:</td><td colspan=11><strong><?php echo($sex); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Age:</td><td colspan=11><strong><?php echo($age); ?></strong></td>
				<td class="studentinfo" colspan=2>Contact No.:</td><td colspan=11><strong><?php echo($cellno); ?></strong></td>
			</tr>
			<tr>
				<td class="studentinfo" colspan=2>Address:</td><td colspan=24><strong><?php echo($radd); ?></strong></td>
			</tr>
			<tr>
				<td bgcolor="#144C69" colspan=26>&nbsp;</td>
			</tr>		
<?php
		}
	}
	
	function displayEnrollmentStatus($userid)
	{
		$preregCount=0;
		$studentCount=0;

		$prereg="SELECT COUNT(userid) as prereg FROM preregmaster WHERE userid=$userid";
		$resultpre= mysql_query($prereg);
		while($row=mysql_fetch_array($resultpre))
		{
			$preregCount=$row['prereg'];
		}
		
		$studentmaster = "SELECT COUNT(sm.userid) as student, glm.description as gradelevel, sec.section as section FROM studentmaster as sm, gradelevelmaster as glm, sectionmaster as sec WHERE sm.gradeid=glm.gradeid and sm.sectionid=sec.sectionid and sm.userid=$userid";
		$resultstud = mysql_query($studentmaster);
		while($row=mysql_fetch_array($resultstud))
		{
			$studentCount=$row['student'];
			$grade=$row['gradelevel'];
			$section=$row['section'];
		}

		$summer = "SELECT COUNT(sm.userid) as student FROM studentmaster as sm WHERE sm.userid=$userid AND sm.sectionid=0";
		$resultsummer = mysql_query($summer);
		while($row=mysql_fetch_array($resultsummer))
		{
			$studentsummer=$row['student'];
		}
		
		$status="";
		$imgName="";
		
		if($preregCount==1)
		{
			$status="Pre-Registered";
			$imgName="images/preregistered.ico";
		}
		elseif ($studentsummer==1)
		{
			$status="Pre-Registered";
			$imgName="images/preregistered.ico";		
		}
		else if($studentCount==1)
		{
			$status="Enrolled as Grade ".$grade." , Section: ".$section;
			$imgName="images/enrolled.ico";
		}
		
?>
		<td><div align="center"><strong><strong><font size=3><img src="<?php echo($imgName); ?>"/>&nbsp;&nbsp;&nbsp;<?php echo($status); ?></font></strong></div></td>
<?php
	}
	
	function displaySection($userid)
	{
		$query="SELECT * FROM studentmaster WHERE userid=$userid AND sectionid=0";
		$result=mysql_query($query);
		$total=mysql_num_rows($result);
		$lrn="";
		if($total>0)
		{
			$query1="SELECT um.userid, pm.gradeid  FROM usermaster as um, studentmaster as pm WHERE um.userid=pm.userid and um.userid=$userid";
			$result1=mysql_query($query1);
			while($row1=mysql_fetch_array($result1))
			{
				$gradeid=$row1['gradeid'];
			}
		}
		else 
		{
			$query1="SELECT um.userid, pm.gradeid FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid and um.userid=$userid";
			$result1=mysql_query($query1);
			while($row1=mysql_fetch_array($result1))
			{
				$gradeid=$row1['gradeid'];
			}
		}
	
		


		$query2="SELECT * FROM gradelevelmaster where gradeid=$gradeid";
		$result2=mysql_query($query2);
		while($row2=mysql_fetch_array($result2))
		{
			$gradename=$row2['description'];
		}
		
		$query="SELECT * FROM sectionmaster WHERE maxcount>actualcount and gradeid=$gradeid";
		$result=mysql_query($query);
		$tot=mysql_num_rows($result);
		$a=1;
		while($row=mysql_fetch_array($result))
		{
			$secid=$row['sectionid'];
			$secname=$row['section'];
			$maxCount = $row['maxcount'];
			$actCount = $row['actualcount'];
			$vacant=$maxCount-$actCount;
			if ($vacant<=0)
			{
				$vacant="FULL";
				$bg="#FFFF99";
			}
			else
			{
				$vacant=$vacant;
				$bg="";
			}
			if($a==1)
			{
				$check="checked";
			}
			else
			{
				$check="";
			}
			$a=$a+1;
?>			
				<tr>
					<td  bgcolor="<?php echo($bg); ?>" align="center"><input type="radio" name="sectionid" id="radio" value=<?php echo($secid);?> <?php echo($check); ?>></td><td bgcolor="<?php echo($bg); ?>" align="center" ><label for="radio"><?php echo($secname); ?></td><td bgcolor="<?php echo($bg); ?>" align="center"><?php echo($maxCount); ?></td><td bgcolor="<?php echo($bg); ?>" align="center"><?php echo($actCount); ?></td><td bgcolor="<?php echo($bg); ?>" align="center"><?php echo($vacant); ?></td>
				</tr>							
<?php
	}
			if($tot==0)
			{
?>
				<tr>
					<td colspan=5 width="400" align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No registered section found!</b></td>
				</tr>
<?php
			}
		
	}
	
	function displayPreregInfo($controlnum)
	{
		$query="SELECT um.*, pm.* FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid AND um.userid ='".$controlnum."'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
			$full = $row['lname'].", ".$row['fname'];
			echo($full);
		}
	}

	function displayStudentName($lrn)
	{
		$query="SELECT um.*, sm.* FROM usermaster as um, studentmaster as sm WHERE um.userid=sm.userid AND sm.lrn ='$lrn'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
			$full = $row['lname'].", ".$row['fname'];
			echo($full);
		}
	}
	
	function displayLRNRequirements($lrn)
	{
		$query="SELECT rm.docid,rm.description,rt.status FROM studentmaster sm, usermaster um, requirementstxn rt, requirementmaster as rm WHERE sm.userid=um.userid AND sm.userid=rt.userid AND rt.docid=rm.docid AND rm.reqtype=0 AND sm.lrn='$lrn'";
		$result=mysql_query($query);
		$total=mysql_num_rows($result);
?>
		<table class="curvedEdges" border="1" width=620 cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Requirements Checklist</font></strong></div></td>
<?php
		while($row=mysql_fetch_array($result))
		{
			$stat=$row['status'];
			$reqdesc=$row['description'];
			$docid=$row['docid'];
			$checked="";
			if ($stat==1)
			{
				$checked="checked";
			}
			else
			{
				$checked="";
			}
?>
			<tr>
			<td align="center" width="35"><input type="checkbox" name="reqs[]" value=<?php echo($docid); ?> <?php echo($checked); ?> /></td><td colspan=4><?php echo($reqdesc); ?></td>
			<tr/>
<?php			
		}

		if($total>1)
		{
?>
			<tr><td align="right" colspan=5><a id='cb1CA' href='' class="myLinks">Check All</a>|<a class="myLinks" id='cb1UA' href=''>Uncheck All</a></td></tr>
<?php
		}
?>
			<td align="right" colspan=5><input style="width: 60px; height: 30px;" type="submit" name="submit" value="Update"></td>
		</table>
		</br>
		<a class="myLinks" href="view_student_incomplete_requirements.php"><< Go Back</a>
<?php
	}

	function displayControlNumPrereg($controlnum)
	{
		$query="SELECT gradeid FROM studentmaster WHERE userid=$controlnum";
		$result=mysql_query($query);
		$total=mysql_num_rows($result);
		$grade=0;
		if($total>0)
		{
			while($row=mysql_fetch_array($result))
			{
				$grade=$row['gradeid'];
			}
		}
		else
		{
			$query="SELECT gradeid FROM preregmaster WHERE userid=$controlnum";
			$result=mysql_query($query);	
			while($row=mysql_fetch_array($result))
			{
				$grade=$row['gradeid'];
			}
		}
		$query="SELECT um.*, rt.*, rm.*  FROM usermaster as um, requirementstxn as rt, requirementmaster as rm WHERE um.userid=rt.userid AND rt.docid=rm.docid AND um.userid=$controlnum AND rt.regid=$grade ORDER by um.adddate ASC";
		$result=mysql_query($query);
?>
		<table class="curvedEdges" border="1" width=620 cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Requirements Checklist</font></strong></div></td>
<?php
		while($row=mysql_fetch_array($result))
		{
			$stat=$row['status'];
			$fname=$row['fname'];
			$mname=$row['mname'];
			$lname=$row['lname'];
			$reqdesc=$row['description'];
			$docid=$row['docid'];
			$checked="";
			if ($stat==1)
			{
				$checked="checked";
			}
?>
			<tr>
			<td align="center" width="35"><input type="checkbox" name="reqs[]" value=<?php echo($docid); ?> <?php echo($checked); ?> /></td><td colspan=4><?php echo($reqdesc); ?></td>
			<tr/>
<?php			
		}
?>
			<tr><td align="right" colspan=5><a id='cb1CA' href='' class="myLinks">Check All</a>|<a class="myLinks" id='cb1UA' href=''>Uncheck All</a></td></tr>
			<td align="right" colspan=5><input style="width: 60px; height: 30px;" type="submit" name="submit" value="Update"></td>
		</table>
		</br>
		<a class="myLinks" href="admission_registrar.php"><< Go Back</a>
<?php
	}
	
	function displayPreregMasterList()
	{
	
		$sql="SELECT COUNT(*) as t FROM preregmaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$numPreReg=$r['t'];
		}
		
		$sql="SELECT COUNT(*) as t FROM studentmaster WHERE sectionid=0";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$numStud=$r['t'];
		}
		
		$num=$numPreReg+$numStud;


		$per_page=10;
		if(empty($_GET['controlno']))
		{
			if($numPreReg==0 && $numStud>0 )
			{
				$query="SELECT um.userid, um.fname, um.mname, um.lname FROM usermaster as um, studentmaster as sm WHERE um.userid=sm.userid AND sm.sectionid=0 GROUP BY um.userid ORDER BY um.userid ASC";
			}
			elseif ($numPreReg>0 && $numStud==0 )
			{
				$query="SELECT um.userid, um.fname, um.mname, um.lname FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid GROUP BY um.userid ORDER BY um.userid ASC";
			}
			else
			{
				$query="SELECT um.userid, um.fname, um.mname, um.lname FROM usermaster as um, preregmaster as pm, studentmaster as sm WHERE um.userid=pm.userid or (um.userid=sm.userid AND sm.sectionid=0) GROUP BY um.userid ORDER BY um.userid ASC";
			}
			
			//$query="SELECT um.userid, um.fname, um.mname, um.lname FROM usermaster as um, preregmaster as pm, studentmaster as sm WHERE um.userid=pm.userid or (um.userid=sm.userid AND sm.sectionid=0) GROUP BY um.userid ORDER BY um.userid ASC";
		}
		if(!empty($_GET['controlno']))
		{
			$controlno=$_GET['controlno'];
			if($numPreReg==0 && $numStud>0 )
			{			
				$query="SELECT um.userid, um.fname, um.mname, um.lname FROM usermaster as um, studentmaster as sm WHERE um.userid=sm.userid AND sm.sectionid=0 AND um.userid=$controlno   GROUP BY um.userid ORDER BY um.userid ASC ";
			}
			elseif ($numPreReg>0 && $numStud==0 )
			{
				$query="SELECT um.userid, um.fname, um.mname, um.lname FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid AND um.userid=$controlno GROUP BY um.userid ORDER BY um.userid ASC";
			}
			
			else
			{
				$query="SELECT um.userid, um.fname, um.mname, um.lname FROM usermaster as um, preregmaster as pm, studentmaster as sm WHERE ((um.userid=pm.userid) or (um.userid=sm.userid AND sm.sectionid=0)) AND um.userid=$controlno   GROUP BY um.userid ORDER BY um.userid ASC ";			
			}

		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}


?>
		<table class="PreRegMasterList" width=620 border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Preregistration Master List</font></strong></div></td>
<?php

		
		if($num==0)
		{
			echo "<tr><th>Control No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th colspan=2>Action</th></tr>";
			echo "<tr>";
			echo '<td colspan=5 align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
				echo "<tr><th>Control No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th colspan=2>Action</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			
					if(empty($_GET['controlno']))
					{
						$id=mysql_result($result,$i,'userid');
					}
					
					if(!empty($_GET['controlno']))
					{
						$id=$_GET['controlno'];
					}
					echo "<tr>";
					//echo '<td width="50"  align="center">'. mysql_result($result,$i,'userid') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'userid') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
					echo '<td width="150" align="center"><a class="myLinks" href="enrollment_update_prereg.php?id='.$id.'"><img src="images/Modify.ico"/>&nbsp;&nbsp;Update</a></td>';
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo '<td colspan=5 width="400" align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found!</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if(empty($_GET['controlno']))
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					echo "<a href='admission_registrar.php?page=$i' class='myLinks'>$i</a>";
				}
			}
		}
?>
		</table>
	<br/>	
<?php			
}

	function displayStudentIncompleteRequirements()
	{
		$per_page=9;
		if(empty($_GET['lrn']))
		{
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, count(rt.docid) as total FROM studentmaster sm, usermaster um, requirementstxn rt, requirementmaster as rm WHERE sm.userid=um.userid AND sm.gradeid=rt.regid AND sm.userid=rt.userid AND rt.docid=rm.docid AND rm.reqtype=0 AND rt.status=0 group by rt.userid";
		}
		if(!empty($_GET['lrn']))
		{
			$lrn=$_GET['lrn'];
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, count(rt.docid) as total FROM studentmaster sm, usermaster um, requirementstxn rt, requirementmaster as rm WHERE sm.userid=um.userid AND sm.gradeid=rt.regid AND sm.userid=rt.userid AND rt.docid=rm.docid AND rm.reqtype=0 AND rt.status=0 AND sm.lrn='$lrn' group by rt.userid";
		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}


?>
		<table class="PreRegMasterList" width=620 border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=7 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Students With Incomplete Requirements</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM usermaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
			echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Total</th><th colspan=2>Action</th></tr>";
			echo "<tr>";
			echo '<td colspan=7 width="750" align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
				echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Total</th><th colspan=2>Action</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			
					if(empty($_GET['lrn']))
					{
						$id=mysql_result($result,$i,'lrn');
					}
					
					if(!empty($_GET['lrn']))
					{
						$id=$_GET['lrn'];
					}
					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lrn') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'total') .'</td>';
					echo '<td width="150" align="center"><a class="myLinks" href="update_student_incomplete_requirements.php?id='.$id.'"><img src="images/Modify.ico"/>&nbsp;&nbsp;Update</a></td>';
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo '<td colspan=7 width="400" align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if(mysql_num_rows($result)>0)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					echo "<a href='view_student_incomplete_requirements.php?page=$i' class='myLinks'>$i</a>";
				}
			}
		}
?>
		</table>
	<br/>	
<?php			
}
	
	function displayStudentView()
	{
		$per_page=8;
		if(empty($_GET['term']))
		{
				$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec WHERE sm.userid=um.userid AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid ORDER BY glm.description, sec.section, sm.lrn ASC";
		}
		if(!empty($_GET['term']))
		{
			$term=$_GET['term'];
			$criteria=$_GET['criteria'];
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec WHERE sm.userid=um.userid AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid AND $criteria LIKE '%$term%' ORDER BY sm.lrn ASC";
		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}


?>
		<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=7 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM studentmaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
			echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
			echo "<tr>";
			echo '<td colspan=7  align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
			echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			

					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lrn') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'section') .'</td>';
					echo '<td width="150" align="center"><a class="myLinks" href="view_student_info.php?id='. mysql_result($result,$i,'lrn') .'"><img height=15 width=15 src="images/View.png" alt="View"/>&nbsp;&nbsp;View</a></td>';
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
					echo '<td colspan=7 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					if(empty($_GET['term']) && empty($_GET['criteria']))
					{
					echo "<a href='view_student.php?page=$i' class='myLinks'>$i</a>";
					}
					else
					{
					echo "<a href='view_student.php?page=$i&&term=$term&&criteria=$criteria' class='myLinks'>$i</a>";
					}
				}
			}
		}
?>
		</table>
	<br/>	

<?php			
}

	function displayStudentViewTransferSection()
	{
		$per_page=5;
		if(empty($_GET['term']))
		{
				$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec WHERE sm.userid=um.userid AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid ORDER BY glm.description, sec.section, sm.lrn ASC";
		}
		if(!empty($_GET['term']))
		{
			$term=$_GET['term'];
			$criteria=$_GET['criteria'];
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec WHERE sm.userid=um.userid AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid AND $criteria LIKE '%$term%' ORDER BY sm.lrn ASC";
		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}


?>
		<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=7 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM studentmaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
			echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
			echo "<tr>";
			echo '<td colspan=7  align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
			echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			

					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lrn') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'section') .'</td>';
					echo '<td width="150" align="center"><a class="myLinks" href="transfer_student_section.php?id='. mysql_result($result,$i,'lrn') .'"><img height=15 width=15 src="images/Modify.ico" alt="View"/>&nbsp;&nbsp;Transfer</a></td>';
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th><th>Action</th></tr>";
					echo '<td colspan=7 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					if(empty($_GET['term']) && empty($_GET['criteria']))
					{
					echo "<a href='view_student_transfer_section.php?page=$i' class='myLinks'>$i</a>";
					}
					else
					{
					echo "<a href='view_student_transfer_section.php?page=$i&&term=$term&&criteria=$criteria' class='myLinks'>$i</a>";
					}
				}
			}
		}
?>
		</table>
	<br/>	

<?php			
}

	function displayFacultyView()
	{
		$per_page=8;
		if(empty($_GET['term']))
		{
				$query="SELECT em.employeeid, um.fname, um.mname, um.lname FROM usermaster AS um, facultymaster AS em WHERE em.userid=um.userid ORDER BY em.employeeid ASC";
		}
		if(!empty($_GET['term']))
		{
			$term=$_GET['term'];
			$criteria=$_GET['criteria'];
			$query="SELECT em.employeeid, um.fname, um.mname, um.lname FROM usermaster AS um, facultymaster AS em WHERE em.userid=um.userid  AND $criteria LIKE '%$term%' ORDER BY em.employeeid ASC";
		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}


?>
		<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM facultymaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
			echo "<tr><th>Employee No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Action</th></tr>";
			echo "<tr>";
			echo '<td colspan=5  align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
			echo "<tr><th>Employee No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Action</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			

					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'employeeid') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
					echo '<td width="150" align="center"><a class="myLinks" href="view_faculty_info.php?id='. mysql_result($result,$i,'employeeid') .'"><img height=15 width=15 src="images/View.png" alt="View"/>&nbsp;&nbsp;View</a></td>';
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo "<tr><th>Employee No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Action</th></tr>";
					echo '<td colspan=5 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					if(empty($_GET['term']) && empty($_GET['criteria']))
					{
					echo "<a href='view_faculty.php?page=$i' class='myLinks'>$i</a>";
					}
					else
					{
					echo "<a href='view_faculty.php?page=$i&&term=$term&&criteria=$criteria' class='myLinks'>$i</a>";
					}
				}
			}
		}
?>
		</table>
	<br/>	

<?php			
}
	
	function displayStudentMasterList()
	{
		$per_page=8;
		if(empty($_GET['searchby']))
		{
				$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec WHERE sm.userid=um.userid AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid ORDER BY glm.description, sec.section, sm.lrn ASC";
		}
		if(!empty($_GET['searchby']))
		{
			$keyword=$_GET['keyword'];
			$searchby=$_GET['searchby'];
			$sortby=$_GET['sortby'];
			$orderby=$_GET['orderby'];
			if($searchby=="all")
			{
				$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec WHERE sm.userid=um.userid AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid ORDER BY $sortby $orderby";
				
			}
			else
			{
				$getGradeid="SELECT gradeid FROM gradelevelmaster WHERE description='$keyword'";
				$resGradeid=mysql_query($getGradeid);
				if(mysql_num_rows($resGradeid)==0)
				{
					$gradeid=0;
				}
				else
				{
					while($rowGradeid=mysql_fetch_array($resGradeid))
					{
						$gradeid=$rowGradeid['gradeid'];
					}
				}
				
				if($searchby=="description")
				{
					$add=",section";
				}
				else
				{
					$add="";
				}
				
				$query="SELECT sm.lrn, um.fname, um.mname, um.lname, glm.description, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster AS glm, sectionmaster AS sec WHERE sm.userid=um.userid AND sm.gradeid=glm.gradeid AND sm.sectionid=sec.sectionid AND sm.gradeid=$gradeid ORDER BY $sortby$add $orderby";
			}
		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}

?>
		<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=6 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM studentmaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
			echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th></tr>";
			echo "<tr>";
			echo '<td colspan=6  align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
				echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			

					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lrn') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'section') .'</td>';
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo "<tr><th>LRN</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Grade</th><th>Section</th></tr>";
					echo '<td colspan=7 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					if(empty($_GET['keyword']) && empty($_GET['searchby']) && empty($_GET['sortby']) && empty($_GET['orderby']))
					{
					echo "<a href='view_student_masterlist.php?page=$i' class='myLinks'>$i</a>";
					}
					else
					{
					echo "<a href='view_student_masterlist.php?page=$i&&keyword=$keyword&&searchby=$searchby&&sortby=$sortby&&orderby=$orderby' class='myLinks'>$i</a>";
					}
				}
			}
		}
?>
		</table>
	<br/>	

<?php			
}

	function displayFacultyMasterList()
	{
		$per_page=11;
		if(empty($_GET['sortby']))
		{
				$query="SELECT em.employeeid, um.fname, um.mname, um.lname FROM usermaster as um, facultymaster as em WHERE em.userid=um.userid ORDER BY em.employeeid ASC";
		}
		if(!empty($_GET['sortby']))
		{
			$sortby=$_GET['sortby'];
			$orderby=$_GET['orderby'];
			$query="SELECT em.employeeid, um.fname, um.mname, um.lname FROM usermaster as um, facultymaster as em WHERE em.userid=um.userid ORDER BY $sortby $orderby";
		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}

?>
		<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM facultymaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
			echo "<tr><th>Employee No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Subjects</th></tr>";
			echo "<tr>";
			echo '<td colspan=4  align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
				echo "<tr><th>Employee No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Subjects</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			
					$eid=mysql_result($result,$i,'employeeid') ;
					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'employeeid') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
?>
					<td width="200" align="center"><a class="myLinks"  href="subject_faculty.php?eid=<?php echo $eid; ?>"><img height=15 width=15 src="images/View.png">&nbsp;&nbsp;View</a></td>				
<?php
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo "<tr><th>Employee No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Subjects</th></tr>";
					echo '<td colspan=4 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					
					if(empty($_GET['keyword']) && empty($_GET['searchby']) && empty($_GET['sortby']) && empty($_GET['orderby']))
					{
					echo "<a href='view_faculty_masterlist.php?page=$i' class='myLinks'>$i</a>";
					}
					else
					{
					echo "<a href='view_faculty_masterlist.php?page=$i&&sortby=$sortby&&orderby=$orderby' class='myLinks'>$i</a>";
					}
				}
			}
		}
?>
		</table>
	<br/>	

<?php			
}
	
	function displayFacultySubjectsMasterList($eid)
	{
		$per_page=5;
		
		if(empty($_GET['page']))
		{
			$query="SELECT fsm.fsid, sm.subjectname, glm.description, sec.section FROM subjectmaster AS sm, sectionmaster AS sec, gradelevelmaster as glm, facultysubjectmaster as fsm, facultymaster as fm WHERE fsm.employeeid = fm.employeeid AND fsm.subjectid = sm.subjectid AND fsm.gradeid = glm.gradeid AND fsm.sectionid = sec.sectionid AND fsm.employeeid ='$eid'ORDER BY  CONVERT(glm.description,UNSIGNED INTEGER), sm.subjectname, sec.section ASC";
		}
		if(!empty($_GET['page']))
		{
			$query="SELECT  fsm.fsid, sm.subjectname, glm.description, sec.section FROM subjectmaster AS sm, sectionmaster AS sec, gradelevelmaster as glm, facultysubjectmaster as fsm, facultymaster as fm WHERE fsm.employeeid = fm.employeeid AND fsm.subjectid = sm.subjectid AND fsm.gradeid = glm.gradeid AND fsm.sectionid = sec.sectionid AND fsm.employeeid ='$eid'ORDER BY  CONVERT(glm.description,UNSIGNED INTEGER), sm.subjectname, sec.section ASC";		
		}
		$result=mysql_query($query);
		$total_results=mysql_num_rows($result);
		$total_pages=ceil($total_results/$per_page);
		
		if (isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$show_page=$_GET['page'];
			if($show_page>0 && $show_page<=$total_pages)
			{
				$start=($show_page-1)*$per_page;
				$end= $start+$per_page;
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
		}
		else
		{
			$start=0;
			$end=$per_page;
		}

?>
		<table class="PreRegMasterList" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=4 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		$num=$total_results;
		if($num==0)
		{
			echo "<tr><th>Subject</th><th>Grade Level</th><th>Section</th><th>Action</th></tr>";
			echo "<tr>";
			echo '<td colspan=4  align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
			echo "<tr><th>Subject</th><th>Grade Level</th><th>Section</th><th>Action</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			
					//$eid=mysql_result($result,$i,'employeeid') ;
					$fsid=mysql_result($result,$i,'fsid');
					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'section') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'subjectname') .'</td>';
?>
					<td width="200" align="center"><a class="myLinks" onclick="return confirm('Are you sure you want to remove this subject?'); return false;"  href="subject_faculty_remove_exec.php?eid=<?php echo $eid ?>&&fsid=<?php echo $fsid; ?>"><img height=15 width=15 src="images/delete.ico">&nbsp;&nbsp;Remove</a></td>				
<?php					
					echo "</tr>";
				}
			}
			else
			{
				echo "<tr>";
				echo "<tr><th>Subject</th><th>Grade Level</th><th>Section</th><th>Action</th></tr>";
				echo '<td colspan=4 align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No data found.</b></td>';
			}
?>
		</table>
	<br/>	
<?php			
			if($total_results>1)
			{
				echo "Page:";
				for($i=1; $i<=$total_pages; $i++)
				{
					echo "<a href='subject_faculty.php?page=$i&&eid=$eid' class='myLinks'>$i</a>";
				}
			}
		}
?>
		</table>
	<br/>	

<?php			
}


	
	function displayLastLoginDate($userid)
	{
		$query="SELECT * FROM usermaster where userid='$userid'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			echo($row['lastlogindate']);
		}
	}
	
	function updateLoginTrail($userid)
	{
		$query="UPDATE usermaster set lastlogindate=(select now()) WHERE userid='$userid'";
		mysql_query($query);
	}
	
	function displayAnnouncementTitle($announcementid)
	{
		$query="SELECT title FROM announcementmaster WHERE announcementid='$announcementid'";
		$result=mysql_query($query);
		while ($row=mysql_fetch_array($result))
		{
			echo($row['title']);
		}
	}
	
	function displayAnnouncementTopic($announcementid)
	{
		$query="SELECT * FROM announcementmaster WHERE announcementid='$announcementid'";
		$result=mysql_query($query);
		while ($row=mysql_fetch_array($result))
		{
?>
		<tr>
		<td>What: </td><td><?php echo($row['what']); ?></td>
		</tr>
		<tr>
		<td>Where: </td><td><?php echo($row['when']); ?></td>
		</tr>
		<tr>
		<td>When: </td><td><?php echo($row['where']); ?></td>
		</tr>
		<tr>
		<td>Who: </td><td><?php echo($row['who']); ?></td>
		</tr>
<?php			
		}
	}
	
	function displayAnnouncement($expdate)
	{
		$query="SELECT * FROM announcementmaster where expirydate >='$expdate' and isactive=1 order by adddate desc";
		$result = mysql_query($query);
		$tot=mysql_num_rows($result);
		if($tot==0)
		{
?>
        <tr>
          <td colspan="5"><center><strong>No Active Announcement for today.</strong></center></td>
        </tr>
<?php
		}
		else
		{
		while($row=mysql_fetch_array($result))
		{
?>
        <tr>
          <td width="25" align="left" bgcolor="#FFFFFF"><img src="images/open.png" width="15" height="15"></td>
          <td width="551" align="left" bgcolor="#FFFFFF"><font size="2">&nbsp;<a href="view_announcement_topic.php?announcementid=<?php echo $row['announcementid']; ?>"><?php echo($row['title']); ?></td>
		  <td width="150" align="center"><font size="1.5"><?php echo($row['adddate']); ?></font></td>
		  <td width="150" align="center"><font size="1.5"><?php getPostedBy($row['addby']); ?></font></td>
		  </tr>
<?php	
		}
		}
	}
	
	function getPostedBy($userid)
	{
		$query = "SELECT * FROM usermaster where userid ='$userid'";
		$result=mysql_query($query);
		while ($row=mysql_fetch_array($result))
		{
			$name = $row['fname']." ".$row['lname'];
		}
		echo $name;
	}
	
	function displayRegistrationType()
	{
		$query = "SELECT * FROM registrationtypemaster order by registrationid  ASC";
		$result=mysql_query($query);
		//echo "<select name='regid' onchange='enableDisablecontrol()'>";
		while($row=mysql_fetch_array($result))
		{ 
		echo "<option value=".$row["registrationid"].">".$row["description"]."</option>";
		}
		//echo "</select>";
	}
	
	function displayRegistrationTypeSettings($typeid)
	{
		$query = "SELECT * FROM registrationtypemaster order by registrationid  ASC";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
?>	
			<option <?php if($typeid==$row['registrationid']){ echo("selected"); } ?>  value="<?php echo($row["registrationid"]); ?>"><?php echo($row["description"]); ?></option>
<?php
		}
	}

	function displayReqStat($userid,$tablename)
	{
		if ($tablename=="studentmaster")
		{
			$query="SELECT * FROM studentmaster WHERE userid=$userid";
			$result=mysql_query($query);
			$total=mysql_num_rows($result);
			if($total==0)
			{
				$tablename="preregmaster";
			}
			else
			{
				$tablename="studentmaster";
			}
		}
		else
		{
			$tablename="preregmaster";
		}
		$query="SELECT COUNT(*) as totalReqs FROM requirementstxn WHERE userid='$userid' AND status=0 AND regid=(SELECT gradeid FROM $tablename WHERE userid=$userid)";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$tot= ($row['totalReqs']);
		}
		
		if($tot==0)
		{
			$tot="";
		}
		else 
		{
			$tot = "(".$tot.")";
		}
		echo ($tot);
	}

	function displayTotalPrereg($userid)
	{
		$query="SELECT COUNT(*) as totalPrereg FROM preregmaster";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$tot= ($row['totalPrereg']);
		}
		
		$query="SELECT COUNT(*) as totalPrereg FROM studentmaster WHERE sectionid=0";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$tot1= ($row['totalPrereg']);
		}
				
		$f=$tot+$tot1;
		
		
		if($f==0)
		{
			$f="";
		}
		else 
		{
			$f = "(".$f.")";
		}
		echo ($f);
	}	
	
	function displayGradeLevels()
	{
		$query = "SELECT * FROM gradelevelmaster order by gradeid ASC";
		$result=mysql_query($query);
		//echo "<select name='gradeid'>";
		while($row=mysql_fetch_array($result))
		{ 
		echo "<option value='".$row["gradeid"]."'>".$row["description"]."</option>";
		}
		//echo "</select>";
	}
	
	function displayGradeLevelReg()
	{
		$query = "SELECT * FROM gradelevelmaster where gradeid in (1)";
		$result=mysql_query($query);
		//echo "<select name='gradeid'>";
		while($row=mysql_fetch_array($result))
		{ 
		echo "<option value='".$row["gradeid"]."'>".$row["description"]."</option>";
		}
		//echo "</select>";
	}	
	
	function displaySectionInitial()
	{
		$query = "SELECT * FROM sectionmaster where gradeid in (1)";
		$result=mysql_query($query);
		//echo "<select name='gradeid'>";
		while($row=mysql_fetch_array($result))
		{ 
		echo "<option value='".$row["sectionid"]."'>".$row["section"]."</option>";
		}
		//echo "</select>";
	}	
	
	function displaySectionInitial1()
	{
		echo "<option value='0'>Select grade level first.</option>";
	}	
	
	function displayGradeLevelsSettings($gradeid)
	{
		$query = "SELECT * FROM gradelevelmaster order by gradeid ASC";
		$result=mysql_query($query);
		//echo "<select name='gradeid'>";
		while($row=mysql_fetch_array($result))
		{ 
?>	
			<option <?php if($gradeid==$row['gradeid']){ echo("selected"); } ?>  value="<?php echo($row["description"]); ?>"><?php echo($row["description"]); ?></option>
<?php
		
		}
		//echo "</select>";
	}
	
	function displayRequirementsSettings($regid)
	{
		$query = "SELECT * FROM registrationtypemaster";
		$result=mysql_query($query);
		//echo "<select name='gradeid'>";
		while($row=mysql_fetch_array($result))
		{ 
?>	
			<option <?php if($regid==$row['registrationid']){ echo("selected"); } ?>  value="<?php echo($row["registrationid"]); ?>"><?php echo($row["description"]); ?></option>
<?php
		
		}
		//echo "</select>";
	}

	
	function displaySummerClasses()
	{
		$query = "SELECT * FROM GRADELEVELMASTER WHERE DESCRIPTION LIKE '%SUMMER'";
		$result=mysql_query($query);
		//echo "<select name='gradeid'>";
		while($row=mysql_fetch_array($result))
		{ 
?>	
			<option  value="<?php echo($row["gradeid"]); ?>"><?php echo($row["description"]); ?></option>
<?php
		
		}
		//echo "</select>";
	}	
	
	function displayAllRequirements($userid)
	{
	//		$query="SELECT rm.docid, rm.regid, rm.description, rm.reqtype, rt.status, rt.adddate, rt.datereceived, rt.receivedby  FROM requirementmaster as rm, requirementstxn as rt, preregmaster as pm where rm.docid=rt.docid AND pm.registrationid = rm.regid AND rt.userid='$userid'";
		$query="SELECT rm.docid, rm.regid,rm.description,rm.reqtype,rt.status, rt.adddate, rt.datereceived, rt.receivedby  FROM requirementmaster as rm, requirementstxn as rt, preregmaster as pm where rm.docid=rt.docid AND pm.userid=rt.userid AND pm.registrationid = rm.regid AND rt.userid='$userid' AND rt.regid=(SELECT gradeid FROM preregmaster WHERE userid=$userid)";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$description = $row['description'];		
			$stat = $row['status'];
			$imgname="";
			$facid=$row['receivedby'];
			$full="";
			$daterec="";
			if ($facid=="")
			{
				$full="";
				$daterec="";
			}
			else
			{
				$query1="SELECT * FROM usermaster WHERE userid=$facid";
				$result1=mysql_query($query1);
				while($row1=mysql_fetch_array($result1))
				{
					$daterec=$row['datereceived'];
					$full=$row1['fname']." ".$row1['lname'];
				}

			}
			
			
			
			if($stat==0)
			{
				$imgname="images/notyetreceived.ico";
			}
			else
			{
				$imgname="images/received.ico";
			}
?>		
		<tr>
			<td align="justify"><?php echo($description); ?></td><td width=10 align="center"><?php echo "<img src='".$imgname."' height='10'>";  ?></td><td align="center"><font size=1><?php echo($daterec); ?></font></td><td align="center"><font size=1><?php echo($full); ?></font></td>
		</tr>
<?php
		}
?>
		<form enctype="multipart/form-data" action="printdetails_guest_exec.php">
		 <td align="right" colspan="4"><input style="width: 60px; height: 30px;" method="POST" type="submit" name="button" id="button" value="Print"></td>	
		</form>
		 </table>
<?php	}	


	function displayAllRequirementsStud($userid)
	{

		$q="SELECT COUNT(lrn) as t FROM studentmaster WHERE userid=$userid";
		$res=mysql_query($q);
		while($r=mysql_fetch_array($res))
		{
			$t=$r['t'];
		}
		
	
		if($t==1)
		{
			$tblname="studentmaster";
		}
		else
		{
			$tblname="preregmaster";
		}
		
		$query="SELECT rt.* FROM requirementstxn as rt, requirementmaster as rm, $tblname as sm WHERE sm.gradeid=rt.regid and rm.docid=rt.docid AND rt.status=0 and rm.reqtype=1 and rt.userid=$userid";
		$res=mysql_query($query);
		$buttonStat=mysql_num_rows($res);
		
		//$query="SELECT rm.docid, rm.regid,rm.description,rm.reqtype,rt.status, rt.adddate, rt.datereceived, rt.receivedby  FROM requirementmaster as rm, requirementstxn as rt, $tblname as pm where rm.docid=rt.docid AND pm.userid=rt.userid AND rt.userid='$userid'";
		$query="SELECT rm.docid, rm.regid,rm.description,rm.reqtype,rt.status, rt.adddate, rt.datereceived, rt.receivedby  FROM requirementmaster as rm, requirementstxn as rt, $tblname as pm where rm.docid=rt.docid AND pm.userid=rt.userid AND rt.regid=pm.gradeid AND rt.userid=$userid AND rt.regid=(SELECT gradeid FROM $tblname WHERE userid=$userid)";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			$description = $row['description'];		
			$stat = $row['status'];
			$imgname="";
			$facid=$row['receivedby'];
			$full="";
			$daterec="";
			if ($facid=="")
			{
				$full="";
				$daterec="";
			}
			else
			{
				$query1="SELECT * FROM usermaster WHERE userid=$facid";
				$result1=mysql_query($query1);
				while($row1=mysql_fetch_array($result1))
				{
					$daterec=$row['datereceived'];
					$full=$row1['fname']." ".$row1['lname'];
				}

			}
			
			
			
			if($stat==0)
			{
				$imgname="images/notyetreceived.ico";
			}
			else
			{
				$imgname="images/received.ico";
			}
?>		
		<tr>
			<td align="justify"><?php echo($description); ?></td><td width=10 align="center"><?php echo "<img src='".$imgname."' height='10'>";  ?></td><td align="center"><font size=1><?php echo($daterec); ?></font></td><td align="center"><font size=1><?php echo($full); ?></font></td>
		</tr>
<?php
		}
		if($buttonStat>0)
		{
?>
		<form enctype="multipart/form-data" action="printdetails_guest_exec.php">
		 <td align="right" colspan="4"><input style="width: 60px; height: 30px;" method="POST" type="submit" name="button" id="button" value="Print"></td>	
		</form>
		 </table>
<?php	}}	
	
	function displayGuestInfo($userid)
	{
		$query="SELECT um.*, pm.* FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid AND um.userid ='".$userid."'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
?>		
		<table class="PreRegMasterList" width=620 border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Personal Details</font></strong></div></td>
		<tr>
			<td width=100><img src="images/name.ico"/>&nbsp;&nbsp;First Name :</td><th align="left"><?php echo $row['fname']; ?></th>
		<tr/>
		<tr>
			<td width=100><img src="images/name.ico"/>&nbsp;&nbsp;Middle Name :</td><th align="left"><?php echo $row['mname']; ?></th>
		<tr/>
		<tr>
			<td width=100><img src="images/name.ico"/>&nbsp;&nbsp;Last Name :</td><th align="left"><?php echo $row['lname']; ?></th>
		<tr/>
		<tr>
			<td width=100><img src="images/bday.ico"/>&nbsp;&nbsp;Birthday :</td><th align="left"><?php echo (date("F d, Y",strtotime($row['birthday']))); ?></th>
		<tr/>
		<tr>
			<td width=100><img src="images/age.ico"/>&nbsp;&nbsp;Age :</td><th align="left"><?php $age=date_diff(date_create($row['birthday']),date_create('now'))->y; echo $age." years old"; ?></th>
		<tr/>
		<tr>
			<td width=100><img src="images/sex.ico"/>&nbsp;&nbsp;Sex :</td><th align="left"><?php if($row['sex']==0) { echo('Male');} else { echo('Female');}?></th>
		<tr/>
		<tr>
			<td width=100 rowspan=3><img src="images/address.ico"/>&nbsp;&nbsp;Address :</td><th rowspan=3 align="left"><?php echo $row['address']; ?></th>
		<tr/>
		<tr></tr> 
		<tr>
			<td width=100><img src="images/email.ico"/>&nbsp;&nbsp;Email :</td><th align="left"><?php echo $row['email']; ?></th>
		</tr>
		<tr>
			<td width=100><img src="images/contactno.ico"/>&nbsp;&nbsp;Contact No. :</td><th align="left"><?php echo $row['cellno']; ?></th>
		</tr>
		<tr>
			<td width=100><img src="images/mother.ico"/>&nbsp;&nbsp;Mother's Name :</td><th align="left"><?php echo $row['mother']; ?></th>
		</tr>
		<tr>
			<td width=100><img src="images/occupation.ico"/>Mother's Occupation :</td><th align="left"><?php echo $row['motherocc']; ?></th>
		</tr>
		<tr>
			<td width=100><img src="images/father.ico"/>&nbsp;&nbsp;Father's Name :</td><th align="left"><?php echo $row['father']; ?></th>
		</tr>
		<tr>
			<td width=150><img src="images/occupation.ico"/>&nbsp;&nbsp;Father's Occupation :</td><th align="left"><?php echo $row['fatherocc']; ?></th>
		</tr>
	</table>
<?php
		}
	}

	function displayStudentInfo($userid)
	{
		$q="SELECT COUNT(lrn) as t FROM studentmaster WHERE userid=$userid";
		$res=mysql_query($q);
		while($r=mysql_fetch_array($res))
		{
			$t=$r['t'];
		}
	
		if($t==1)
		{
			$tblname="studentmaster";
		}
		else
		{
			$tblname="preregmaster";
		}	
	
		$query="SELECT um.*, sm.* FROM usermaster as um, $tblname as sm WHERE um.userid=sm.userid AND um.userid ='".$userid."'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
?>		
		<table class="PreRegMasterList" width=620 border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Personal Details</font></strong></div></td>
		<tr>
			<td><img src="images/name.ico"/>&nbsp;&nbsp;First Name :</td><th align="left"><?php echo $row['fname']; ?></th>
		<tr/>
		<tr>
			<td><img src="images/name.ico"/>&nbsp;&nbsp;Middle Name :</td><th align="left"><?php echo $row['mname']; ?></th>
		<tr/>
		<tr>
			<td><img src="images/name.ico"/>&nbsp;&nbsp;Last Name :</td><th align="left"><?php echo $row['lname']; ?></th>
		<tr/>
		<tr>
			<td><img src="images/bday.ico"/>&nbsp;&nbsp;Birthday :</td><th align="left"><?php echo (date("F d, Y",strtotime($row['birthday']))); ?></th>
		<tr/>
		<tr>
			<td><img src="images/age.ico"/>&nbsp;&nbsp;Age :</td><th align="left"><?php $age=date_diff(date_create($row['birthday']),date_create('now'))->y; echo $age." years old"; ?></th>
		<tr/>
		<tr>
			<td><img src="images/sex.ico"/>&nbsp;&nbsp;Sex :</td><th align="left"><?php if($row['sex']==0) { echo('Male');} else { echo('Female');}?></th>
		<tr/>
		<tr>
			<td rowspan=3><img src="images/address.ico"/>&nbsp;&nbsp;Address :</td><th rowspan=3 align="left"><?php echo $row['address']; ?></th>
		<tr/>
		<tr></tr> 
		<tr>
			<td><img src="images/email.ico"/>&nbsp;&nbsp;Email :</td><th align="left"><?php echo $row['email']; ?></th>
		</tr>
		<tr>
			<td><img src="images/contactno.ico"/>&nbsp;&nbsp;Contact No. :</td><th align="left"><?php echo $row['cellno']; ?></th>
		</tr>
		<tr>
			<td ><img src="images/mother.ico"/>&nbsp;&nbsp;Mother's Name :</td><th align="left"><?php echo $row['mother']; ?></th>
		</tr>
		<tr>
			<td ><img src="images/occupation.ico"/>Mother's Occupation :</td><th align="left"><?php echo $row['motherocc']; ?></th>
		</tr>
		<tr>
			<td ><img src="images/father.ico"/>&nbsp;&nbsp;Father's Name :</td><th align="left"><?php echo $row['father']; ?></th>
		</tr>
		<tr>
			<td ><img src="images/occupation.ico"/>&nbsp;&nbsp;Father's Occupation :</td><th align="left"><?php echo $row['fatherocc']; ?></th>
		</tr>

	</table>
<?php
		}
	}
	
	function displayEmpInfo($userid)
	{
		$query="SELECT um.*, fm.* FROM usermaster as um, facultymaster as fm WHERE um.userid=fm.userid AND fm.userid ='".$userid."'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
?>		
		<table class="PreRegMasterList" width=620 border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=2 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Personal Details</font></strong></div></td>
		<tr>
			<td><img src="images/name.ico"/>&nbsp;&nbsp;First Name :</td><th align="left"><?php echo $row['fname']; ?></th>
		<tr/>
		<tr>
			<td><img src="images/name.ico"/>&nbsp;&nbsp;Middle Name :</td><th align="left"><?php echo $row['mname']; ?></th>
		<tr/>
		<tr>
			<td><img src="images/name.ico"/>&nbsp;&nbsp;Last Name :</td><th align="left"><?php echo $row['lname']; ?></th>
		<tr/>
		<tr>
			<td><img src="images/bday.ico"/>&nbsp;&nbsp;Birthday :</td><th align="left"><?php echo (date("F d, Y",strtotime($row['birthday']))); ?></th>
		<tr/>
		<tr>
			<td><img src="images/age.ico"/>&nbsp;&nbsp;Age :</td><th align="left"><?php $age=date_diff(date_create($row['birthday']),date_create('now'))->y; echo $age." years old"; ?></th>
		<tr/>
		<tr>
			<td><img src="images/sex.ico"/>&nbsp;&nbsp;Sex :</td><th align="left"><?php if($row['sex']==0) { echo('Male');} else {echo('Female');}?></th>
		<tr/>
		<tr>
			<td rowspan=3><img src="images/address.ico"/>&nbsp;&nbsp;Address :</td><th rowspan=3 align="left"><?php echo $row['address']; ?></th>
		<tr/>
		<tr></tr> 
		<tr>
			<td><img src="images/email.ico"/>&nbsp;&nbsp;Email :</td><th align="left"><?php echo $row['email']; ?></th>
		</tr>
		<tr>
			<td><img src="images/contactno.ico"/>&nbsp;&nbsp;Contact No. :</td><th align="left"><?php echo $row['cellno']; ?></th>
		</tr>
	</table>
<?php
		}
	}
	
	function createPDF($uid, $regid)
	{
		$q="SELECT COUNT(lrn) as t FROM studentmaster WHERE userid=$uid";
		$res=mysql_query($q);
		while($row=mysql_fetch_array($res))
		{	
			$t=$row['t'];
		}
	
		if($t==0)
		{
			$query="SELECT um.*, pm.* FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid and um.userid=$uid";
		}
		else
		{
			$query="SELECT um.*, sm.* FROM usermaster as um, studentmaster as sm WHERE um.userid=sm.userid and um.userid=$uid";			
		}

		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
			$regid=$row['gradeid'];
			$fname = $row['fname'];
			$mname = $row['mname'];
			$lname = $row['lname'];
			$fullname = strtoupper($lname.', '.$fname.' '.$mname);
			$address = strtoupper($row['address']);
			$sex=strtoupper($row['sex']);
			$cn=$row['userid'];
			if($sex==0)
			{
				$sex="MALE";
			}
			else
			{
				$sex="FEMALE";
			}
			$age=date_diff(date_create($row['birthday']),date_create('now'))->y; 
			$bdate=$row['birthday'];
			$bdate = strtoupper(date("F d, Y",strtotime($bdate)));
			$cellno=$row['cellno'];
			$bplace=strtoupper($row['birthplace']);
			$mother=strtoupper($row['mother']);
			$motherocc=strtoupper($row['motherocc']);
			$father=strtoupper($row['father']);
			$fatherocc=strtoupper($row['fatherocc']);
			$lastschool=strtoupper($row['lastschoolattended']);
			$schadd=strtoupper($row['schooladdress']);
		}
		
	require_once('fpdf/fpdf.php');
	require_once('fpdi/fpdi.php');

	// initiate FPDI
	$pdf = new FPDI();

	// set the sourcefile
	$sourceFileName = 'PDF Template/template.pdf';

	//Set the source PDF file
	$pagecount = $pdf->setSourceFile($sourceFileName);

	$i = 1;
	do {
		// add a page
		$pdf->AddPage();
		// import page
		$tplidx = $pdf->ImportPage($i); 

		 $pdf->useTemplate($tplidx, 10, 10, 200);
		 
		 $pdf->SetFont('Arial');
		 $pdf->SetTextColor(0,0,0);
		 $pdf->SetFontSize(20);

		 //CONTROLNUMBER
		 $pdf->SetXY(170, 80);
		 $pdf->Write(1, $cn);

		 $pdf->SetFont('Arial');
		 $pdf->SetTextColor(0,0,0);
		 $pdf->SetFontSize(10);		
		//name
		 $pdf->SetXY(42, 95);
		 $pdf->Write(1, $fullname);
		//address
 		 $pdf->SetXY(42, 102);
		 $pdf->Write(1, $address);
		//birthday
 		 $pdf->SetXY(42, 108.5);
		 $pdf->Write(1, $bdate);
		//bplace
 		 $pdf->SetXY(42, 115.5);
		 $pdf->Write(1, $bplace);
		//mother
 		 $pdf->SetXY(42.5, 122.5);
		 $pdf->Write(1, $mother);
		//motherocc
 		 $pdf->SetXY(42.5, 129.5);
		 $pdf->Write(1, $motherocc);
		//father
 		 $pdf->SetXY(135, 122.5);
		 $pdf->Write(1, $father);
		//fatherocc
 		 $pdf->SetXY(135, 129.5);
		 $pdf->Write(1, $fatherocc);
		//lastschool
 		 $pdf->SetXY(62.5, 136.5);
		 $pdf->Write(1, $lastschool);
		//schadd
 		 $pdf->SetXY(42.5, 143.5);
		 $pdf->Write(1, $schadd);
		//cellno
 		 $pdf->SetXY(145, 108.5);
		 $pdf->Write(1, $cellno);
		//age
		 $pdf->SetXY(185, 95);
		 $pdf->Write(1, $age);
		//sex
		 $pdf->SetXY(151, 95);
		 $pdf->Write(1, $sex);
		 

		 $i++;

	} while($i <= $pagecount);


	//Select Arial italic 8
	//$pdf->SetFont('Arial','I',8);
	$pdf->SetFont('Arial');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFontSize(10);

	$query="SELECT rm.docid,rm.description FROM requirementmaster as rm, requirementstxn as rt WHERE rm.docid=rt.docid AND rt.userid=$uid AND rt.regid=$regid";
	$result=mysql_query($query);
	$total = mysql_num_rows($result);
	$posY=180;
	while($row=mysql_fetch_array($result))
	{
		//sex
		 $pdf->SetXY(21.5, $posY);
		 $pdf->Write(1, "__________   ".$row['description']);		
		 $posY= $posY+5;
	}
	
	$pdf->Output();

	}
	
	function create137($lrn)
	{
		
		$query="SELECT * FROM gradetxn WHERE lrn='$lrn'";
		$result=mysql_query($query);
		$total=mysql_num_rows($result);
		if($total==0)
		{
?>
		<script type="text/javascript">
		alert('No record found.');
		window.location="print_form_137.php";
		</script>	
<?php		
		}
		else
		{
			require_once('fpdf/fpdf.php');
			require_once('fpdi/fpdi.php');

			// initiate FPDI
			$pdf = new FPDI();

			// set the sourcefile
			$sourceFileName = 'PDF Template/137.pdf';

			//Set the source PDF file
			$pagecount = $pdf->setSourceFile($sourceFileName);

			$pdf->SetFont('courier','B');
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFontSize(10);

			$i = 1;
			do {
				// add a page
				$pdf->AddPage();
				// import page
				$tplidx = $pdf->ImportPage($i); 

				 $pdf->useTemplate($tplidx, 10, 10, 200);
				 		 
				 //Start of Grade 7 Part 1
				 if($i==1)
				 {
				 $filipinocount=0;
				 $filipinoFirst=0;
				 $filipinoSecond=0;
				 $filipinoThird=0;
				 $filipinoFourth=0;
				 $englishcount=0;
				 $englishFirst=0;
				 $englishSecond=0;
				 $englishThird=0;
				 $englishFourth=0;
				 $mathcount=0;
				 $mathFirst=0;
				 $mathSecond=0;
				 $mathThird=0;
				 $mathFourth=0;
				 $sciencecount=0;
				 $scienceFirst=0;
				 $scienceSecond=0;
				 $scienceThird=0;
				 $scienceFourth=0;
				 $apcount=0;
				 $apFirst=0;
				 $apSecond=0;
				 $apThird=0;
				 $apFourth=0;
				 $tlecount=0;
				 $tleFirst=0;
				 $tleSecond=0;
				 $tleThird=0;
				 $tleFourth=0;
				 $mapehcount=0;
				 $mapehFirst=0;
				 $mapehSecond=0;
				 $mapehThird=0;
				 $mapehFourth=0;
				 $epcount=0;
				 $epFirst=0;
				 $epSecond=0;
				 $epThird=0;
				 $epFourth=0;
				 $query="SELECT CONCAT(um.lname,', ', um.fname, ' ', um.mname) as fullname, sm.lastschoolattended, gm.description as gradelevel, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster as gm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.gradeid=gm.gradeid  AND sm.sectionid=sec.sectionid AND sm.lrn='$lrn'";
					$result=mysql_query($query);
					while($row=mysql_fetch_array($result))
					{
						$full=$row['fullname'];
						$school="CAMP CRAME HIGH SCHOOL";
					}
					 $pdf->SetFont('courier','b');
					 $pdf->SetTextColor(0,0,0);
					 $pdf->SetFontSize(10);
					 
					//LRN
					 $pdf->SetXY(170, 33);
					 $pdf->Write(1, $lrn);

					 //Fullname
					 $pdf->SetXY(25, 37);
					 $pdf->Write(1, $full);
					 
					 $pdf->SetFont('courier','b');
					 $pdf->SetTextColor(0,0,0);
					 $pdf->SetFontSize(8);		
					 
					 //School
					 $pdf->SetXY(43, 49);
					 $pdf->Write(1, $school);

					 //Grade Section
					 $pdf->SetXY(163, 49);
					 $pdf->Write(1, "7");	 
					 
					$q="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7') AND gt.lrn='$lrn'";
					$res=mysql_query($q); 
					$totrows=mysql_num_rows($res);
					if($totrows==0)
					{
						$sy="";
					}
					 
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='First') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);												
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}						
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFirst=$finalGrade;
							 $pdf->SetXY(69, 64);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFirst=$finalGrade;
							 $pdf->SetXY(69, 68.5);
							 $pdf->Write(1, $letter);
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFirst=$finalGrade;
							 $pdf->SetXY(69, 72.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFirst=$finalGrade;
							 $pdf->SetXY(69, 76.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFirst=$finalGrade;
							 $pdf->SetXY(69, 81);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFirst=$finalGrade;
							 $pdf->SetXY(69, 86);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFirst=$finalGrade;
							 $pdf->SetXY(69, 91);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFirst=$finalGrade;
							 $pdf->SetXY(69, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }
					 
					 //Second Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Second') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}	
						
						if($id==1)
						{
							 //Filipino
							 $filipinoSecond=$finalGrade;
							 $pdf->SetXY(86, 64);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishSecond=$finalGrade;
							 $pdf->SetXY(86, 68.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathSecond=$finalGrade;
							 $pdf->SetXY(86, 72.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceSecond=$finalGrade;
							 $pdf->SetXY(86, 76.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apSecond=$finalGrade;
							 $pdf->SetXY(86, 81);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleSecond=$finalGrade;
							 $pdf->SetXY(86, 86);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehSecond=$finalGrade;
							 $pdf->SetXY(86, 91);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epSecond=$finalGrade;
							 $pdf->SetXY(86, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }							
					 }					 
					 
					 //Third Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Third') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}	
						
						if($id==1)
						{
							 //Filipino
							 $filipinoThird=$finalGrade;
							 $pdf->SetXY(104, 64);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishThird=$finalGrade;
							 $pdf->SetXY(104, 68.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathThird=$finalGrade;
							 $pdf->SetXY(104, 72.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceThird=$finalGrade;
							 $pdf->SetXY(104, 76.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apThird=$finalGrade;
							 $pdf->SetXY(104, 81);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleThird=$finalGrade;
							 $pdf->SetXY(104, 86);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehThird=$finalGrade;
							 $pdf->SetXY(104, 91);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epThird=$finalGrade;
							 $pdf->SetXY(104, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }							 
					 
					 //Fourth Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Fourth') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}	
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFourth=$finalGrade;
							 $pdf->SetXY(121, 64);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFourth=$finalGrade;
							 $pdf->SetXY(121, 68.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFourth=$finalGrade;
							 $pdf->SetXY(121, 72.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFourth=$finalGrade;
							 $pdf->SetXY(121, 76.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFourth=$finalGrade;
							 $pdf->SetXY(121, 81);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFourth=$finalGrade;
							 $pdf->SetXY(121, 86);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFourth=$finalGrade;
							 $pdf->SetXY(121, 91);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFourth=$finalGrade;
							 $pdf->SetXY(121, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }					 
					 
					 //Average
					 //Filipino
					 if ($filipinocount>0)
					 {
						 $aveFilipino=round(($filipinoFirst+$filipinoSecond+$filipinoThird+$filipinoFourth)/$filipinocount,0);
						 $pdf->SetXY(137, 64);
						 $pdf->Write(1, $aveFilipino); 
						 
						 if($aveFilipino<75)
						 {
							 $pdf->SetXY(146.5, 64);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 64);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //English
					 if($englishcount>0)
					 {
						 $aveEnglish=round(($englishFirst+$englishSecond+$englishThird+$englishFourth)/$englishcount,0);
						 $pdf->SetXY(137, 68.5);
						 $pdf->Write(1, $aveEnglish); 	

						 if($aveEnglish<75)
						 {
							 $pdf->SetXY(146.5, 68.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 68.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Mathematics
					 if($mathcount>0)
					 {
						 $aveMath=round(($mathFirst+$mathSecond+$mathThird+$mathFourth)/$mathcount,0);
						 $pdf->SetXY(137, 72.5);
						 $pdf->Write(1, $aveMath); 						 

						 if($aveMath<75)
						 {
							 $pdf->SetXY(146.5, 72.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 72.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Science
					 if($sciencecount>0)
					 {
						 $aveScience=round(($scienceFirst+$scienceSecond+$scienceThird+$scienceFourth)/$sciencecount,0);
						 $pdf->SetXY(137, 76.5);
						 $pdf->Write(1, $aveScience); 					 
						 
						 if($aveScience<75)
						 {
							 $pdf->SetXY(146.5, 76.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 76.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //AP
					 if($apcount>0)
					 {
						 $aveAp=round(($apFirst+$apSecond+$apThird+$apFourth)/$apcount,0);
						 $pdf->SetXY(137, 81);
						 $pdf->Write(1, $aveAp); 					 
						 
						 if($aveAp<75)
						 {
							 $pdf->SetXY(146.5, 81);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 81);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //TLE
					 if($tlecount>0)
					 {
						 $aveTle=round(($tleFirst+$tleSecond+$tleThird+$tleFourth)/$tlecount,0);
						 $pdf->SetXY(137, 86);
						 $pdf->Write(1, $aveTle); 					 
						 
						 if($aveTle<75)
						 {
							 $pdf->SetXY(146.5, 86);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 86);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					//MAPEH
					if($mapehcount>0)
					{
						 $aveMapeh=round(($mapehFirst+$mapehSecond+$mapehThird+$mapehFourth)/$mapehcount,0);
						 $pdf->SetXY(137, 91);
						 $pdf->Write(1, $aveMapeh); 					 
						 
						 if($aveMapeh<75)
						 {
							 $pdf->SetXY(146.5, 91);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 91);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //EP
					 if($epcount>0)
					 {
						 $aveEP=round(($epFirst+$epSecond+$epThird+$epFourth)/$epcount,0);
						 $pdf->SetXY(137, 112);
						 $pdf->Write(1, $aveEP); 					 
						 
						 if($aveEP<75)
						 {
							 $pdf->SetXY(146.5, 112);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 112);
							 $pdf->Write(1, "P"); 
						 }					 
					 }
					 
					 //School Year
					 $pdf->SetXY(118, 49);
					 $pdf->Write(1, $sy);						 				 
				}
				 //End of Grade 7 Part 1
				 
				 
				 //Start of Grade 7 Summer
				elseif($i==2)
				{
				 $filipinocount=0;
				 $filipinoFirst=0;
				 $filipinoSecond=0;
				 $filipinoThird=0;
				 $filipinoFourth=0;
				 $englishcount=0;
				 $englishFirst=0;
				 $englishSecond=0;
				 $englishThird=0;
				 $englishFourth=0;
				 $mathcount=0;
				 $mathFirst=0;
				 $mathSecond=0;
				 $mathThird=0;
				 $mathFourth=0;
				 $sciencecount=0;
				 $scienceFirst=0;
				 $scienceSecond=0;
				 $scienceThird=0;
				 $scienceFourth=0;
				 $apcount=0;
				 $apFirst=0;
				 $apSecond=0;
				 $apThird=0;
				 $apFourth=0;
				 $tlecount=0;
				 $tleFirst=0;
				 $tleSecond=0;
				 $tleThird=0;
				 $tleFourth=0;
				 $mapehcount=0;
				 $mapehFirst=0;
				 $mapehSecond=0;
				 $mapehThird=0;
				 $mapehFourth=0;
				 $epcount=0;
				 $epFirst=0;
				 $epSecond=0;
				 $epThird=0;
				 $epFourth=0;

				 //School
					 $pdf->SetXY(127, 49.5);
					 $pdf->Write(1, $school);

					$q="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7-SUMMER') AND gt.lrn='$lrn'";
					$res=mysql_query($q); 
					$totrows=mysql_num_rows($res);
					if($totrows==0)
					{
						$sy="";
					}
					 

					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='First') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFirst=$finalGrade;
							 $pdf->SetXY(69, 65);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFirst=$finalGrade;
							 $pdf->SetXY(69, 69);
							 $pdf->Write(1, $letter);
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFirst=$finalGrade;
							 $pdf->SetXY(69, 73);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFirst=$finalGrade;
							 $pdf->SetXY(69, 77);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFirst=$finalGrade;
							 $pdf->SetXY(69, 81.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFirst=$finalGrade;
							 $pdf->SetXY(69, 86.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFirst=$finalGrade;
							 $pdf->SetXY(69, 91.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFirst=$finalGrade;
							 $pdf->SetXY(69, 112.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }
					 
					 //Second Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Second') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoSecond=$finalGrade;
							 $pdf->SetXY(86, 65);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishSecond=$finalGrade;
							 $pdf->SetXY(86, 69);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathSecond=$finalGrade;
							 $pdf->SetXY(86, 73);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceSecond=$finalGrade;
							 $pdf->SetXY(86, 77);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apSecond=$finalGrade;
							 $pdf->SetXY(86, 81.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleSecond=$finalGrade;
							 $pdf->SetXY(86, 86.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehSecond=$finalGrade;
							 $pdf->SetXY(86, 91.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epSecond=$finalGrade;
							 $pdf->SetXY(86, 112.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }							
					 }					 
					 
					 //Third Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Third') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);

						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}						
						
						if($id==1)
						{
							 //Filipino
							 $filipinoThird=$finalGrade;
							 $pdf->SetXY(104, 65);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishThird=$finalGrade;
							 $pdf->SetXY(104, 69);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathThird=$finalGrade;
							 $pdf->SetXY(104, 73);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceThird=$finalGrade;
							 $pdf->SetXY(104, 77);
							 $pdf->Write(1, $letter); 
							 $sciencecount= $sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apThird=$finalGrade;
							 $pdf->SetXY(104, 81.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleThird=$finalGrade;
							 $pdf->SetXY(104, 86.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehThird=$finalGrade;
							 $pdf->SetXY(104, 91.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epThird=$finalGrade;
							 $pdf->SetXY(104, 112.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }							 
					 
					 //Fourth Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='7-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Fourth') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFourth=$finalGrade;
							 $pdf->SetXY(121, 65);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFourth=$finalGrade;
							 $pdf->SetXY(121, 69);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFourth=$finalGrade;
							 $pdf->SetXY(121, 73);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFourth=$finalGrade;
							 $pdf->SetXY(121, 77);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFourth=$finalGrade;
							 $pdf->SetXY(121, 81.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFourth=$finalGrade;
							 $pdf->SetXY(121, 86.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFourth=$finalGrade;
							 $pdf->SetXY(121, 91.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFourth=$finalGrade;
							 $pdf->SetXY(121, 112.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }					 
					 
					 //Average
					 //Filipino
					 if ($filipinocount>0)
					 {
						 $aveFilipino=round(($filipinoFirst+$filipinoSecond+$filipinoThird+$filipinoFourth)/$filipinocount,0);
						 $pdf->SetXY(137, 65);
						 $pdf->Write(1, $aveFilipino); 
						 
						 if($aveFilipino<75)
						 {
							 $pdf->SetXY(146.5, 65);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 65);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //English
					 if($englishcount>0)
					 {
						 $aveEnglish=round(($englishFirst+$englishSecond+$englishThird+$englishFourth)/$englishcount,0);
						 $pdf->SetXY(137, 69);
						 $pdf->Write(1, $aveEnglish); 	

						 if($aveEnglish<75)
						 {
							 $pdf->SetXY(146.5, 69);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 69);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Mathematics
					 if($mathcount>0)
					 {
						 $aveMath=round(($mathFirst+$mathSecond+$mathThird+$mathFourth)/$mathcount,0);
						 $pdf->SetXY(137, 73);
						 $pdf->Write(1, $aveMath); 						 

						 if($aveMath<75)
						 {
							 $pdf->SetXY(146.5, 73);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 73);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Science
					 if($sciencecount>0)
					 {
						 $aveScience=round(($scienceFirst+$scienceSecond+$scienceThird+$scienceFourth)/$sciencecount,0);
						 $pdf->SetXY(137, 77);
						 $pdf->Write(1, $aveScience); 					 
						 
						 if($aveScience<75)
						 {
							 $pdf->SetXY(146.5, 77);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 77);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //AP
					 if($apcount>0)
					 {
						 $aveAp=round(($apFirst+$apSecond+$apThird+$apFourth)/$apcount,0);
						 $pdf->SetXY(137, 81.5);
						 $pdf->Write(1, $aveAp); 					 
						 
						 if($aveAp<75)
						 {
							 $pdf->SetXY(146.5, 81.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 81.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //TLE
					 if($tlecount>0)
					 {
						 $aveTle=round(($tleFirst+$tleSecond+$tleThird+$tleFourth)/$tlecount,0);
						 $pdf->SetXY(137, 86.5);
						 $pdf->Write(1, $aveTle); 					 
						 
						 if($aveTle<75)
						 {
							 $pdf->SetXY(146.5, 86.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 86.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					//MAPEH
					if($mapehcount>0)
					{
						 $aveMapeh=round(($mapehFirst+$mapehSecond+$mapehThird+$mapehFourth)/$mapehcount,0);
						 $pdf->SetXY(137, 91.5);
						 $pdf->Write(1, $aveMapeh); 					 
						 
						 if($aveMapeh<75)
						 {
							 $pdf->SetXY(146.5, 91.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 91.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //EP
					 if($epcount>0)
					 {
						 $aveEP=round(($epFirst+$epSecond+$epThird+$epFourth)/$epcount,0);
						 $pdf->SetXY(137, 112.5);
						 $pdf->Write(1, $aveEP); 					 
						 
						 if($aveEP<75)
						 {
							 $pdf->SetXY(146.5, 112.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 112.5);
							 $pdf->Write(1, "P"); 
						 }					 
					 }
					 
					 //School Year
					 $pdf->SetXY(50, 49);
					 $pdf->Write(1, $sy);						 
					 
				}
				//End of Grade 7 Summer
				
				//Start of Grade 8 Part 1
				 elseif($i==3)
				 {
				 $filipinocount=0;
				 $filipinoFirst=0;
				 $filipinoSecond=0;
				 $filipinoThird=0;
				 $filipinoFourth=0;
				 $englishcount=0;
				 $englishFirst=0;
				 $englishSecond=0;
				 $englishThird=0;
				 $englishFourth=0;
				 $mathcount=0;
				 $mathFirst=0;
				 $mathSecond=0;
				 $mathThird=0;
				 $mathFourth=0;
				 $sciencecount=0;
				 $scienceFirst=0;
				 $scienceSecond=0;
				 $scienceThird=0;
				 $scienceFourth=0;
				 $apcount=0;
				 $apFirst=0;
				 $apSecond=0;
				 $apThird=0;
				 $apFourth=0;
				 $tlecount=0;
				 $tleFirst=0;
				 $tleSecond=0;
				 $tleThird=0;
				 $tleFourth=0;
				 $mapehcount=0;
				 $mapehFirst=0;
				 $mapehSecond=0;
				 $mapehThird=0;
				 $mapehFourth=0;
				 $epcount=0;
				 $epFirst=0;
				 $epSecond=0;
				 $epThird=0;
				 $epFourth=0;
				 $query="SELECT CONCAT(um.lname,', ', um.fname, ' ', um.mname) as fullname, sm.lastschoolattended, gm.description as gradelevel, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster as gm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.gradeid=gm.gradeid  AND sm.sectionid=sec.sectionid AND sm.lrn='$lrn'";
					$result=mysql_query($query);
					while($row=mysql_fetch_array($result))
					{
						$full=$row['fullname'];
						$school="CAMP CRAME HIGH SCHOOL";
					}
					 $pdf->SetFont('courier','b');
					 $pdf->SetTextColor(0,0,0);
					 $pdf->SetFontSize(10);
					 
					//LRN
					 $pdf->SetXY(170, 36);
					 $pdf->Write(1, $lrn);

					 //Fullname
					 $pdf->SetXY(25, 41);
					 $pdf->Write(1, $full);
					 
					 $pdf->SetFont('courier','b');
					 $pdf->SetTextColor(0,0,0);
					 $pdf->SetFontSize(8);		
					 
					 //School
					 $pdf->SetXY(43, 52);
					 $pdf->Write(1, $school);

					 //Grade Section
					 $pdf->SetXY(163, 52);
					 $pdf->Write(1, "8");	 
					 
					$q="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8') AND gt.lrn='$lrn'";
					$res=mysql_query($q); 
					$totrows=mysql_num_rows($res);
					if($totrows==0)
					{
						$sy="";
					}

					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='First') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFirst=$finalGrade;
							 $pdf->SetXY(69, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFirst=$finalGrade;
							 $pdf->SetXY(69, 72);
							 $pdf->Write(1, $letter);
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFirst=$finalGrade;
							 $pdf->SetXY(69, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFirst=$finalGrade;
							 $pdf->SetXY(69, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFirst=$finalGrade;
							 $pdf->SetXY(69, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFirst=$finalGrade;
							 $pdf->SetXY(69, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFirst=$finalGrade;
							 $pdf->SetXY(69, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFirst=$finalGrade;
							 $pdf->SetXY(69, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }
					 
					 //Second Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Second') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}	
						
						if($id==1)
						{
							 //Filipino
							 $filipinoSecond=$finalGrade;
							 $pdf->SetXY(86, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishSecond=$finalGrade;
							 $pdf->SetXY(86, 72);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathSecond=$finalGrade;
							 $pdf->SetXY(86, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceSecond=$finalGrade;
							 $pdf->SetXY(86, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apSecond=$finalGrade;
							 $pdf->SetXY(86, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleSecond=$finalGrade;
							 $pdf->SetXY(86, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehSecond=$finalGrade;
							 $pdf->SetXY(86, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epSecond=$finalGrade;
							 $pdf->SetXY(86, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }							
					 }					 
					 
					 //Third Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Third') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoThird=$finalGrade;
							 $pdf->SetXY(104, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishThird=$finalGrade;
							 $pdf->SetXY(104, 72);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathThird=$finalGrade;
							 $pdf->SetXY(104, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceThird=$finalGrade;
							 $pdf->SetXY(104, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apThird=$finalGrade;
							 $pdf->SetXY(104, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleThird=$finalGrade;
							 $pdf->SetXY(104, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehThird=$finalGrade;
							 $pdf->SetXY(104, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epThird=$finalGrade;
							 $pdf->SetXY(104, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }							 
					 
					 //Fourth Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Fourth') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFourth=$finalGrade;
							 $pdf->SetXY(121, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFourth=$finalGrade;
							 $pdf->SetXY(121, 72);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFourth=$finalGrade;
							 $pdf->SetXY(121, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFourth=$finalGrade;
							 $pdf->SetXY(121, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFourth=$finalGrade;
							 $pdf->SetXY(121, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFourth=$finalGrade;
							 $pdf->SetXY(121, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFourth=$finalGrade;
							 $pdf->SetXY(121, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFourth=$finalGrade;
							 $pdf->SetXY(121, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }					 
					 
					 //Average
					 //Filipino
					 if ($filipinocount>0)
					 {
						 $aveFilipino=round(($filipinoFirst+$filipinoSecond+$filipinoThird+$filipinoFourth)/$filipinocount,0);
						 $pdf->SetXY(137, 68);
						 $pdf->Write(1, $aveFilipino); 
						 
						 if($aveFilipino<75)
						 {
							 $pdf->SetXY(146.5, 68);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 68);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //English
					 if($englishcount>0)
					 {
						 $aveEnglish=round(($englishFirst+$englishSecond+$englishThird+$englishFourth)/$englishcount,0);
						 $pdf->SetXY(137, 72);
						 $pdf->Write(1, $aveEnglish); 	

						 if($aveEnglish<75)
						 {
							 $pdf->SetXY(146.5, 72);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 72);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Mathematics
					 if($mathcount>0)
					 {
						 $aveMath=round(($mathFirst+$mathSecond+$mathThird+$mathFourth)/$mathcount,0);
						 $pdf->SetXY(137, 76);
						 $pdf->Write(1, $aveMath); 						 

						 if($aveMath<75)
						 {
							 $pdf->SetXY(146.5, 76);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 76);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Science
					 if($sciencecount>0)
					 {
						 $aveScience=round(($scienceFirst+$scienceSecond+$scienceThird+$scienceFourth)/$sciencecount,0);
						 $pdf->SetXY(137, 80);
						 $pdf->Write(1, $aveScience); 					 
						 
						 if($aveScience<75)
						 {
							 $pdf->SetXY(146.5, 80);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 80);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //AP
					 if($apcount>0)
					 {
						 $aveAp=round(($apFirst+$apSecond+$apThird+$apFourth)/$apcount,0);
						 $pdf->SetXY(137, 84.5);
						 $pdf->Write(1, $aveAp); 					 
						 
						 if($aveAp<75)
						 {
							 $pdf->SetXY(146.5, 84.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 84.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //TLE
					 if($tlecount>0)
					 {
						 $aveTle=round(($tleFirst+$tleSecond+$tleThird+$tleFourth)/$tlecount,0);
						 $pdf->SetXY(137, 89.5);
						 $pdf->Write(1, $aveTle); 					 
						 
						 if($aveTle<75)
						 {
							 $pdf->SetXY(146.5, 89.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 89.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					//MAPEH
					if($mapehcount>0)
					{
						 $aveMapeh=round(($mapehFirst+$mapehSecond+$mapehThird+$mapehFourth)/$mapehcount,0);
						 $pdf->SetXY(137, 94.5);
						 $pdf->Write(1, $aveMapeh); 					 
						 
						 if($aveMapeh<75)
						 {
							 $pdf->SetXY(146.5, 94.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 94.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //EP
					 if($epcount>0)
					 {
						 $aveEP=round(($epFirst+$epSecond+$epThird+$epFourth)/$epcount,0);
						 $pdf->SetXY(137, 111.5);
						 $pdf->Write(1, $aveEP); 					 
						 
						 if($aveEP<75)
						 {
							 $pdf->SetXY(146.5, 111.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 111.5);
							 $pdf->Write(1, "P"); 
						 }					 
					 }
					 
					 //School Year
					 $pdf->SetXY(118, 52);
					 $pdf->Write(1, $sy);						 				 
				}
				 //End of Grade 8 Part 1				

				 //Start of Grade 8 Summer
				elseif($i==4)
				{
				 $filipinocount=0;
				 $filipinoFirst=0;
				 $filipinoSecond=0;
				 $filipinoThird=0;
				 $filipinoFourth=0;
				 $englishcount=0;
				 $englishFirst=0;
				 $englishSecond=0;
				 $englishThird=0;
				 $englishFourth=0;
				 $mathcount=0;
				 $mathFirst=0;
				 $mathSecond=0;
				 $mathThird=0;
				 $mathFourth=0;
				 $sciencecount=0;
				 $scienceFirst=0;
				 $scienceSecond=0;
				 $scienceThird=0;
				 $scienceFourth=0;
				 $apcount=0;
				 $apFirst=0;
				 $apSecond=0;
				 $apThird=0;
				 $apFourth=0;
				 $tlecount=0;
				 $tleFirst=0;
				 $tleSecond=0;
				 $tleThird=0;
				 $tleFourth=0;
				 $mapehcount=0;
				 $mapehFirst=0;
				 $mapehSecond=0;
				 $mapehThird=0;
				 $mapehFourth=0;
				 $epcount=0;
				 $epFirst=0;
				 $epSecond=0;
				 $epThird=0;
				 $epFourth=0;

				 //School
					 $pdf->SetXY(127, 53);
					 $pdf->Write(1, $school);
					 
					$q="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8-SUMMER') AND gt.lrn='$lrn'";
					$res=mysql_query($q); 
					$totrows=mysql_num_rows($res);
					if($totrows==0)
					{
						$sy="";
					}
					 
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='First') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFirst=$finalGrade;
							 $pdf->SetXY(69, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFirst=$finalGrade;
							 $pdf->SetXY(69, 72.5);
							 $pdf->Write(1, $letter);
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFirst=$finalGrade;
							 $pdf->SetXY(69, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFirst=$finalGrade;
							 $pdf->SetXY(69, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFirst=$finalGrade;
							 $pdf->SetXY(69, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFirst=$finalGrade;
							 $pdf->SetXY(69, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFirst=$finalGrade;
							 $pdf->SetXY(69, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFirst=$finalGrade;
							 $pdf->SetXY(69, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }
					 
					 //Second Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Second') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoSecond=$finalGrade;
							 $pdf->SetXY(86, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishSecond=$finalGrade;
							 $pdf->SetXY(86, 72.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathSecond=$finalGrade;
							 $pdf->SetXY(86, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceSecond=$finalGrade;
							 $pdf->SetXY(86, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apSecond=$finalGrade;
							 $pdf->SetXY(86, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleSecond=$finalGrade;
							 $pdf->SetXY(86, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehSecond=$finalGrade;
							 $pdf->SetXY(86, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epSecond=$finalGrade;
							 $pdf->SetXY(86, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }							
					 }					 
					 
					 //Third Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Third') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoThird=$finalGrade;
							 $pdf->SetXY(104, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishThird=$finalGrade;
							 $pdf->SetXY(104, 72.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathThird=$finalGrade;
							 $pdf->SetXY(104, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceThird=$finalGrade;
							 $pdf->SetXY(104, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount= $sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apThird=$finalGrade;
							 $pdf->SetXY(104, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleThird=$finalGrade;
							 $pdf->SetXY(104, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehThird=$finalGrade;
							 $pdf->SetXY(104, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epThird=$finalGrade;
							 $pdf->SetXY(104, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }							 
					 
					 //Fourth Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='8-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Fourth') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFourth=$finalGrade;
							 $pdf->SetXY(121, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFourth=$finalGrade;
							 $pdf->SetXY(121, 72.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFourth=$finalGrade;
							 $pdf->SetXY(121, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFourth=$finalGrade;
							 $pdf->SetXY(121, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFourth=$finalGrade;
							 $pdf->SetXY(121, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFourth=$finalGrade;
							 $pdf->SetXY(121, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFourth=$finalGrade;
							 $pdf->SetXY(121, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFourth=$finalGrade;
							 $pdf->SetXY(121, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }					 
					 
					 //Average
					 //Filipino
					 if ($filipinocount>0)
					 {
						 $aveFilipino=round(($filipinoFirst+$filipinoSecond+$filipinoThird+$filipinoFourth)/$filipinocount,0);
						 $pdf->SetXY(137, 68.5);
						 $pdf->Write(1, $aveFilipino); 
						 
						 if($aveFilipino<75)
						 {
							 $pdf->SetXY(146.5, 68.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 68.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //English
					 if($englishcount>0)
					 {
						 $aveEnglish=round(($englishFirst+$englishSecond+$englishThird+$englishFourth)/$englishcount,0);
						 $pdf->SetXY(137, 72.5);
						 $pdf->Write(1, $aveEnglish); 	

						 if($aveEnglish<75)
						 {
							 $pdf->SetXY(146.5, 72.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 72.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Mathematics
					 if($mathcount>0)
					 {
						 $aveMath=round(($mathFirst+$mathSecond+$mathThird+$mathFourth)/$mathcount,0);
						 $pdf->SetXY(137, 76.5);
						 $pdf->Write(1, $aveMath); 						 

						 if($aveMath<75)
						 {
							 $pdf->SetXY(146.5, 76.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 76.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Science
					 if($sciencecount>0)
					 {
						 $aveScience=round(($scienceFirst+$scienceSecond+$scienceThird+$scienceFourth)/$sciencecount,0);
						 $pdf->SetXY(137, 80.5);
						 $pdf->Write(1, $aveScience); 					 
						 
						 if($aveScience<75)
						 {
							 $pdf->SetXY(146.5, 80.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 80.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //AP
					 if($apcount>0)
					 {
						 $aveAp=round(($apFirst+$apSecond+$apThird+$apFourth)/$apcount,0);
						 $pdf->SetXY(137, 85);
						 $pdf->Write(1, $aveAp); 					 
						 
						 if($aveAp<75)
						 {
							 $pdf->SetXY(146.5, 85);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 85);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //TLE
					 if($tlecount>0)
					 {
						 $aveTle=round(($tleFirst+$tleSecond+$tleThird+$tleFourth)/$tlecount,0);
						 $pdf->SetXY(137, 90);
						 $pdf->Write(1, $aveTle); 					 
						 
						 if($aveTle<75)
						 {
							 $pdf->SetXY(146.5, 90);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 90);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					//MAPEH
					if($mapehcount>0)
					{
						 $aveMapeh=round(($mapehFirst+$mapehSecond+$mapehThird+$mapehFourth)/$mapehcount,0);
						 $pdf->SetXY(137, 95);
						 $pdf->Write(1, $aveMapeh); 					 
						 
						 if($aveMapeh<75)
						 {
							 $pdf->SetXY(146.5, 95);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 95);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //EP
					 if($epcount>0)
					 {
						 $aveEP=round(($epFirst+$epSecond+$epThird+$epFourth)/$epcount,0);
						 $pdf->SetXY(137, 112);
						 $pdf->Write(1, $aveEP); 					 
						 
						 if($aveEP<75)
						 {
							 $pdf->SetXY(146.5, 112);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 112);
							 $pdf->Write(1, "P"); 
						 }					 
					 }
					 
					 //School Year
					 $pdf->SetXY(50, 53);
					 $pdf->Write(1, $sy);						 
					 
				}
				//End of Grade 8 Summer

				
				//Start of Grade 9 Part 1
				 elseif($i==5)
				 {
				 $filipinocount=0;
				 $filipinoFirst=0;
				 $filipinoSecond=0;
				 $filipinoThird=0;
				 $filipinoFourth=0;
				 $englishcount=0;
				 $englishFirst=0;
				 $englishSecond=0;
				 $englishThird=0;
				 $englishFourth=0;
				 $mathcount=0;
				 $mathFirst=0;
				 $mathSecond=0;
				 $mathThird=0;
				 $mathFourth=0;
				 $sciencecount=0;
				 $scienceFirst=0;
				 $scienceSecond=0;
				 $scienceThird=0;
				 $scienceFourth=0;
				 $apcount=0;
				 $apFirst=0;
				 $apSecond=0;
				 $apThird=0;
				 $apFourth=0;
				 $tlecount=0;
				 $tleFirst=0;
				 $tleSecond=0;
				 $tleThird=0;
				 $tleFourth=0;
				 $mapehcount=0;
				 $mapehFirst=0;
				 $mapehSecond=0;
				 $mapehThird=0;
				 $mapehFourth=0;
				 $epcount=0;
				 $epFirst=0;
				 $epSecond=0;
				 $epThird=0;
				 $epFourth=0;
				 $query="SELECT CONCAT(um.lname,', ', um.fname, ' ', um.mname) as fullname, sm.lastschoolattended, gm.description as gradelevel, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster as gm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.gradeid=gm.gradeid  AND sm.sectionid=sec.sectionid AND sm.lrn='$lrn'";
					$result=mysql_query($query);
					while($row=mysql_fetch_array($result))
					{
						$full=$row['fullname'];
						$school="CAMP CRAME HIGH SCHOOL";
					}
					 $pdf->SetFont('courier','b');
					 $pdf->SetTextColor(0,0,0);
					 $pdf->SetFontSize(10);
					 
					//LRN
					 $pdf->SetXY(170, 36);
					 $pdf->Write(1, $lrn);

					 //Fullname
					 $pdf->SetXY(25, 41);
					 $pdf->Write(1, $full);
					 
					 $pdf->SetFont('courier','b');
					 $pdf->SetTextColor(0,0,0);
					 $pdf->SetFontSize(8);		
					 
					 //School
					 $pdf->SetXY(43, 52);
					 $pdf->Write(1, $school);

					 //Grade Section
					 $pdf->SetXY(163, 52);
					 $pdf->Write(1, "9");	 
					 
					$q="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9') AND gt.lrn='$lrn'";
					$res=mysql_query($q); 
					$totrows=mysql_num_rows($res);
					if($totrows==0)
					{
						$sy="";
					}
					 
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='First') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFirst=$finalGrade;
							 $pdf->SetXY(69, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFirst=$finalGrade;
							 $pdf->SetXY(69, 72);
							 $pdf->Write(1, $letter);
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFirst=$finalGrade;
							 $pdf->SetXY(69, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFirst=$finalGrade;
							 $pdf->SetXY(69, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFirst=$finalGrade;
							 $pdf->SetXY(69, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFirst=$finalGrade;
							 $pdf->SetXY(69, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFirst=$finalGrade;
							 $pdf->SetXY(69, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFirst=$finalGrade;
							 $pdf->SetXY(69, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }
					 
					 //Second Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Second') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoSecond=$finalGrade;
							 $pdf->SetXY(86, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishSecond=$finalGrade;
							 $pdf->SetXY(86, 72);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathSecond=$finalGrade;
							 $pdf->SetXY(86, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceSecond=$finalGrade;
							 $pdf->SetXY(86, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apSecond=$finalGrade;
							 $pdf->SetXY(86, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleSecond=$finalGrade;
							 $pdf->SetXY(86, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehSecond=$finalGrade;
							 $pdf->SetXY(86, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epSecond=$finalGrade;
							 $pdf->SetXY(86, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }							
					 }					 
					 
					 //Third Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Third') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoThird=$finalGrade;
							 $pdf->SetXY(104, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishThird=$finalGrade;
							 $pdf->SetXY(104, 72);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathThird=$finalGrade;
							 $pdf->SetXY(104, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceThird=$finalGrade;
							 $pdf->SetXY(104, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apThird=$finalGrade;
							 $pdf->SetXY(104, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleThird=$finalGrade;
							 $pdf->SetXY(104, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehThird=$finalGrade;
							 $pdf->SetXY(104, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epThird=$finalGrade;
							 $pdf->SetXY(104, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }							 
					 
					 //Fourth Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Fourth') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFourth=$finalGrade;
							 $pdf->SetXY(121, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFourth=$finalGrade;
							 $pdf->SetXY(121, 72);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFourth=$finalGrade;
							 $pdf->SetXY(121, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFourth=$finalGrade;
							 $pdf->SetXY(121, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFourth=$finalGrade;
							 $pdf->SetXY(121, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFourth=$finalGrade;
							 $pdf->SetXY(121, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFourth=$finalGrade;
							 $pdf->SetXY(121, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFourth=$finalGrade;
							 $pdf->SetXY(121, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }					 
					 
					 //Average
					 //Filipino
					 if ($filipinocount>0)
					 {
						 $aveFilipino=round(($filipinoFirst+$filipinoSecond+$filipinoThird+$filipinoFourth)/$filipinocount,0);
						 $pdf->SetXY(137, 68);
						 $pdf->Write(1, $aveFilipino); 
						 
						 if($aveFilipino<75)
						 {
							 $pdf->SetXY(146.5, 68);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 68);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //English
					 if($englishcount>0)
					 {
						 $aveEnglish=round(($englishFirst+$englishSecond+$englishThird+$englishFourth)/$englishcount,0);
						 $pdf->SetXY(137, 72);
						 $pdf->Write(1, $aveEnglish); 	

						 if($aveEnglish<75)
						 {
							 $pdf->SetXY(146.5, 72);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 72);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Mathematics
					 if($mathcount>0)
					 {
						 $aveMath=round(($mathFirst+$mathSecond+$mathThird+$mathFourth)/$mathcount,0);
						 $pdf->SetXY(137, 76);
						 $pdf->Write(1, $aveMath); 						 

						 if($aveMath<75)
						 {
							 $pdf->SetXY(146.5, 76);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 76);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Science
					 if($sciencecount>0)
					 {
						 $aveScience=round(($scienceFirst+$scienceSecond+$scienceThird+$scienceFourth)/$sciencecount,0);
						 $pdf->SetXY(137, 80);
						 $pdf->Write(1, $aveScience); 					 
						 
						 if($aveScience<75)
						 {
							 $pdf->SetXY(146.5, 80);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 80);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //AP
					 if($apcount>0)
					 {
						 $aveAp=round(($apFirst+$apSecond+$apThird+$apFourth)/$apcount,0);
						 $pdf->SetXY(137, 84.5);
						 $pdf->Write(1, $aveAp); 					 
						 
						 if($aveAp<75)
						 {
							 $pdf->SetXY(146.5, 84.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 84.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //TLE
					 if($tlecount>0)
					 {
						 $aveTle=round(($tleFirst+$tleSecond+$tleThird+$tleFourth)/$tlecount,0);
						 $pdf->SetXY(137, 89.5);
						 $pdf->Write(1, $aveTle); 					 
						 
						 if($aveTle<75)
						 {
							 $pdf->SetXY(146.5, 89.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 89.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					//MAPEH
					if($mapehcount>0)
					{
						 $aveMapeh=round(($mapehFirst+$mapehSecond+$mapehThird+$mapehFourth)/$mapehcount,0);
						 $pdf->SetXY(137, 94.5);
						 $pdf->Write(1, $aveMapeh); 					 
						 
						 if($aveMapeh<75)
						 {
							 $pdf->SetXY(146.5, 94.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 94.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //EP
					 if($epcount>0)
					 {
						 $aveEP=round(($epFirst+$epSecond+$epThird+$epFourth)/$epcount,0);
						 $pdf->SetXY(137, 111.5);
						 $pdf->Write(1, $aveEP); 					 
						 
						 if($aveEP<75)
						 {
							 $pdf->SetXY(146.5, 111.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 111.5);
							 $pdf->Write(1, "P"); 
						 }					 
					 }
					 
					 //School Year
					 $pdf->SetXY(118, 52);
					 $pdf->Write(1, $sy);						 				 
				}
				 //End of Grade 9 Part 1				
				
				 //Start of Grade 9 Summer
				elseif($i==6)
				{
				 $filipinocount=0;
				 $filipinoFirst=0;
				 $filipinoSecond=0;
				 $filipinoThird=0;
				 $filipinoFourth=0;
				 $englishcount=0;
				 $englishFirst=0;
				 $englishSecond=0;
				 $englishThird=0;
				 $englishFourth=0;
				 $mathcount=0;
				 $mathFirst=0;
				 $mathSecond=0;
				 $mathThird=0;
				 $mathFourth=0;
				 $sciencecount=0;
				 $scienceFirst=0;
				 $scienceSecond=0;
				 $scienceThird=0;
				 $scienceFourth=0;
				 $apcount=0;
				 $apFirst=0;
				 $apSecond=0;
				 $apThird=0;
				 $apFourth=0;
				 $tlecount=0;
				 $tleFirst=0;
				 $tleSecond=0;
				 $tleThird=0;
				 $tleFourth=0;
				 $mapehcount=0;
				 $mapehFirst=0;
				 $mapehSecond=0;
				 $mapehThird=0;
				 $mapehFourth=0;
				 $epcount=0;
				 $epFirst=0;
				 $epSecond=0;
				 $epThird=0;
				 $epFourth=0;

				 //School
					 $pdf->SetXY(127, 53);
					 $pdf->Write(1, $school);
					 
					$q="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9-SUMMER') AND gt.lrn='$lrn'";
					$res=mysql_query($q); 
					$totrows=mysql_num_rows($res);
					if($totrows==0)
					{
						$sy="";
					}
					 
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='First') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFirst=$finalGrade;
							 $pdf->SetXY(69, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFirst=$finalGrade;
							 $pdf->SetXY(69, 72.5);
							 $pdf->Write(1, $letter);
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFirst=$finalGrade;
							 $pdf->SetXY(69, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFirst=$finalGrade;
							 $pdf->SetXY(69, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFirst=$finalGrade;
							 $pdf->SetXY(69, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFirst=$finalGrade;
							 $pdf->SetXY(69, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFirst=$finalGrade;
							 $pdf->SetXY(69, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFirst=$finalGrade;
							 $pdf->SetXY(69, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }
					 
					 //Second Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Second') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoSecond=$finalGrade;
							 $pdf->SetXY(86, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishSecond=$finalGrade;
							 $pdf->SetXY(86, 72.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathSecond=$finalGrade;
							 $pdf->SetXY(86, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceSecond=$finalGrade;
							 $pdf->SetXY(86, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apSecond=$finalGrade;
							 $pdf->SetXY(86, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleSecond=$finalGrade;
							 $pdf->SetXY(86, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehSecond=$finalGrade;
							 $pdf->SetXY(86, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epSecond=$finalGrade;
							 $pdf->SetXY(86, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }							
					 }					 
					 
					 //Third Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Third') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoThird=$finalGrade;
							 $pdf->SetXY(104, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishThird=$finalGrade;
							 $pdf->SetXY(104, 72.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathThird=$finalGrade;
							 $pdf->SetXY(104, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceThird=$finalGrade;
							 $pdf->SetXY(104, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount= $sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apThird=$finalGrade;
							 $pdf->SetXY(104, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleThird=$finalGrade;
							 $pdf->SetXY(104, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehThird=$finalGrade;
							 $pdf->SetXY(104, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epThird=$finalGrade;
							 $pdf->SetXY(104, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }							 
					 
					 //Fourth Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='9-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Fourth') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFourth=$finalGrade;
							 $pdf->SetXY(121, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFourth=$finalGrade;
							 $pdf->SetXY(121, 72.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFourth=$finalGrade;
							 $pdf->SetXY(121, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFourth=$finalGrade;
							 $pdf->SetXY(121, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFourth=$finalGrade;
							 $pdf->SetXY(121, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFourth=$finalGrade;
							 $pdf->SetXY(121, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFourth=$finalGrade;
							 $pdf->SetXY(121, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFourth=$finalGrade;
							 $pdf->SetXY(121, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }					 
					 
					 //Average
					 //Filipino
					 if ($filipinocount>0)
					 {
						 $aveFilipino=round(($filipinoFirst+$filipinoSecond+$filipinoThird+$filipinoFourth)/$filipinocount,0);
						 $pdf->SetXY(137, 68.5);
						 $pdf->Write(1, $aveFilipino); 
						 
						 if($aveFilipino<75)
						 {
							 $pdf->SetXY(146.5, 68.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 68.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //English
					 if($englishcount>0)
					 {
						 $aveEnglish=round(($englishFirst+$englishSecond+$englishThird+$englishFourth)/$englishcount,0);
						 $pdf->SetXY(137, 72.5);
						 $pdf->Write(1, $aveEnglish); 	

						 if($aveEnglish<75)
						 {
							 $pdf->SetXY(146.5, 72.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 72.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Mathematics
					 if($mathcount>0)
					 {
						 $aveMath=round(($mathFirst+$mathSecond+$mathThird+$mathFourth)/$mathcount,0);
						 $pdf->SetXY(137, 76.5);
						 $pdf->Write(1, $aveMath); 						 

						 if($aveMath<75)
						 {
							 $pdf->SetXY(146.5, 76.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 76.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Science
					 if($sciencecount>0)
					 {
						 $aveScience=round(($scienceFirst+$scienceSecond+$scienceThird+$scienceFourth)/$sciencecount,0);
						 $pdf->SetXY(137, 80.5);
						 $pdf->Write(1, $aveScience); 					 
						 
						 if($aveScience<75)
						 {
							 $pdf->SetXY(146.5, 80.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 80.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //AP
					 if($apcount>0)
					 {
						 $aveAp=round(($apFirst+$apSecond+$apThird+$apFourth)/$apcount,0);
						 $pdf->SetXY(137, 85);
						 $pdf->Write(1, $aveAp); 					 
						 
						 if($aveAp<75)
						 {
							 $pdf->SetXY(146.5, 85);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 85);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //TLE
					 if($tlecount>0)
					 {
						 $aveTle=round(($tleFirst+$tleSecond+$tleThird+$tleFourth)/$tlecount,0);
						 $pdf->SetXY(137, 90);
						 $pdf->Write(1, $aveTle); 					 
						 
						 if($aveTle<75)
						 {
							 $pdf->SetXY(146.5, 90);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 90);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					//MAPEH
					if($mapehcount>0)
					{
						 $aveMapeh=round(($mapehFirst+$mapehSecond+$mapehThird+$mapehFourth)/$mapehcount,0);
						 $pdf->SetXY(137, 95);
						 $pdf->Write(1, $aveMapeh); 					 
						 
						 if($aveMapeh<75)
						 {
							 $pdf->SetXY(146.5, 95);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 95);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //EP
					 if($epcount>0)
					 {
						 $aveEP=round(($epFirst+$epSecond+$epThird+$epFourth)/$epcount,0);
						 $pdf->SetXY(137, 112);
						 $pdf->Write(1, $aveEP); 					 
						 
						 if($aveEP<75)
						 {
							 $pdf->SetXY(146.5, 112);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 112);
							 $pdf->Write(1, "P"); 
						 }					 
					 }
					 
					 //School Year
					 $pdf->SetXY(50, 53);
					 $pdf->Write(1, $sy);						 
					 
				}
				//End of Grade 9 Summer
				
				
				//Start of Grade 10 Part 1
				 elseif($i==7)
				 {
				 $filipinocount=0;
				 $filipinoFirst=0;
				 $filipinoSecond=0;
				 $filipinoThird=0;
				 $filipinoFourth=0;
				 $englishcount=0;
				 $englishFirst=0;
				 $englishSecond=0;
				 $englishThird=0;
				 $englishFourth=0;
				 $mathcount=0;
				 $mathFirst=0;
				 $mathSecond=0;
				 $mathThird=0;
				 $mathFourth=0;
				 $sciencecount=0;
				 $scienceFirst=0;
				 $scienceSecond=0;
				 $scienceThird=0;
				 $scienceFourth=0;
				 $apcount=0;
				 $apFirst=0;
				 $apSecond=0;
				 $apThird=0;
				 $apFourth=0;
				 $tlecount=0;
				 $tleFirst=0;
				 $tleSecond=0;
				 $tleThird=0;
				 $tleFourth=0;
				 $mapehcount=0;
				 $mapehFirst=0;
				 $mapehSecond=0;
				 $mapehThird=0;
				 $mapehFourth=0;
				 $epcount=0;
				 $epFirst=0;
				 $epSecond=0;
				 $epThird=0;
				 $epFourth=0;
				 $query="SELECT CONCAT(um.lname,', ', um.fname, ' ', um.mname) as fullname, sm.lastschoolattended, gm.description as gradelevel, sec.section FROM usermaster AS um, studentmaster AS sm, gradelevelmaster as gm, sectionmaster as sec WHERE um.userid=sm.userid AND sm.gradeid=gm.gradeid  AND sm.sectionid=sec.sectionid AND sm.lrn='$lrn'";
					$result=mysql_query($query);
					while($row=mysql_fetch_array($result))
					{
						$full=$row['fullname'];
						$school="CAMP CRAME HIGH SCHOOL";
					}
					 $pdf->SetFont('courier','b');
					 $pdf->SetTextColor(0,0,0);
					 $pdf->SetFontSize(10);
					 
					//LRN
					 $pdf->SetXY(170, 36);
					 $pdf->Write(1, $lrn);

					 //Fullname
					 $pdf->SetXY(25, 41);
					 $pdf->Write(1, $full);
					 
					 $pdf->SetFont('courier','b');
					 $pdf->SetTextColor(0,0,0);
					 $pdf->SetFontSize(8);		
					 
					 //School
					 $pdf->SetXY(43, 52);
					 $pdf->Write(1, $school);

					 //Grade Section
					 $pdf->SetXY(163, 52);
					 $pdf->Write(1, "10");	 
					 
					$q="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10') AND gt.lrn='$lrn'";
					$res=mysql_query($q); 
					$totrows=mysql_num_rows($res);
					if($totrows==0)
					{
						$sy="";
					}
					 
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='First') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFirst=$finalGrade;
							 $pdf->SetXY(69, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFirst=$finalGrade;
							 $pdf->SetXY(69, 72);
							 $pdf->Write(1, $letter);
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFirst=$finalGrade;
							 $pdf->SetXY(69, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFirst=$finalGrade;
							 $pdf->SetXY(69, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFirst=$finalGrade;
							 $pdf->SetXY(69, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFirst=$finalGrade;
							 $pdf->SetXY(69, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFirst=$finalGrade;
							 $pdf->SetXY(69, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFirst=$finalGrade;
							 $pdf->SetXY(69, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }
					 
					 //Second Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Second') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoSecond=$finalGrade;
							 $pdf->SetXY(86, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishSecond=$finalGrade;
							 $pdf->SetXY(86, 72);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathSecond=$finalGrade;
							 $pdf->SetXY(86, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceSecond=$finalGrade;
							 $pdf->SetXY(86, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apSecond=$finalGrade;
							 $pdf->SetXY(86, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleSecond=$finalGrade;
							 $pdf->SetXY(86, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehSecond=$finalGrade;
							 $pdf->SetXY(86, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epSecond=$finalGrade;
							 $pdf->SetXY(86, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }							
					 }					 
					 
					 //Third Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Third') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoThird=$finalGrade;
							 $pdf->SetXY(104, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishThird=$finalGrade;
							 $pdf->SetXY(104, 72);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathThird=$finalGrade;
							 $pdf->SetXY(104, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceThird=$finalGrade;
							 $pdf->SetXY(104, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apThird=$finalGrade;
							 $pdf->SetXY(104, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleThird=$finalGrade;
							 $pdf->SetXY(104, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehThird=$finalGrade;
							 $pdf->SetXY(104, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epThird=$finalGrade;
							 $pdf->SetXY(104, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }							 
					 
					 //Fourth Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Fourth') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFourth=$finalGrade;
							 $pdf->SetXY(121, 68);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFourth=$finalGrade;
							 $pdf->SetXY(121, 72);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFourth=$finalGrade;
							 $pdf->SetXY(121, 76);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFourth=$finalGrade;
							 $pdf->SetXY(121, 80);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFourth=$finalGrade;
							 $pdf->SetXY(121, 84.5);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFourth=$finalGrade;
							 $pdf->SetXY(121, 89.5);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFourth=$finalGrade;
							 $pdf->SetXY(121, 94.5);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFourth=$finalGrade;
							 $pdf->SetXY(121, 111.5);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }					 
					 
					 //Average
					 //Filipino
					 if ($filipinocount>0)
					 {
						 $aveFilipino=round(($filipinoFirst+$filipinoSecond+$filipinoThird+$filipinoFourth)/$filipinocount,0);
						 $pdf->SetXY(137, 68);
						 $pdf->Write(1, $aveFilipino); 
						 
						 if($aveFilipino<75)
						 {
							 $pdf->SetXY(146.5, 68);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 68);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //English
					 if($englishcount>0)
					 {
						 $aveEnglish=round(($englishFirst+$englishSecond+$englishThird+$englishFourth)/$englishcount,0);
						 $pdf->SetXY(137, 72);
						 $pdf->Write(1, $aveEnglish); 	

						 if($aveEnglish<75)
						 {
							 $pdf->SetXY(146.5, 72);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 72);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Mathematics
					 if($mathcount>0)
					 {
						 $aveMath=round(($mathFirst+$mathSecond+$mathThird+$mathFourth)/$mathcount,0);
						 $pdf->SetXY(137, 76);
						 $pdf->Write(1, $aveMath); 						 

						 if($aveMath<75)
						 {
							 $pdf->SetXY(146.5, 76);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 76);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Science
					 if($sciencecount>0)
					 {
						 $aveScience=round(($scienceFirst+$scienceSecond+$scienceThird+$scienceFourth)/$sciencecount,0);
						 $pdf->SetXY(137, 80);
						 $pdf->Write(1, $aveScience); 					 
						 
						 if($aveScience<75)
						 {
							 $pdf->SetXY(146.5, 80);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 80);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //AP
					 if($apcount>0)
					 {
						 $aveAp=round(($apFirst+$apSecond+$apThird+$apFourth)/$apcount,0);
						 $pdf->SetXY(137, 84.5);
						 $pdf->Write(1, $aveAp); 					 
						 
						 if($aveAp<75)
						 {
							 $pdf->SetXY(146.5, 84.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 84.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //TLE
					 if($tlecount>0)
					 {
						 $aveTle=round(($tleFirst+$tleSecond+$tleThird+$tleFourth)/$tlecount,0);
						 $pdf->SetXY(137, 89.5);
						 $pdf->Write(1, $aveTle); 					 
						 
						 if($aveTle<75)
						 {
							 $pdf->SetXY(146.5, 89.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 89.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					//MAPEH
					if($mapehcount>0)
					{
						 $aveMapeh=round(($mapehFirst+$mapehSecond+$mapehThird+$mapehFourth)/$mapehcount,0);
						 $pdf->SetXY(137, 94.5);
						 $pdf->Write(1, $aveMapeh); 					 
						 
						 if($aveMapeh<75)
						 {
							 $pdf->SetXY(146.5, 94.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 94.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //EP
					 if($epcount>0)
					 {
						 $aveEP=round(($epFirst+$epSecond+$epThird+$epFourth)/$epcount,0);
						 $pdf->SetXY(137, 111.5);
						 $pdf->Write(1, $aveEP); 					 
						 
						 if($aveEP<75)
						 {
							 $pdf->SetXY(146.5, 111.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 111.5);
							 $pdf->Write(1, "P"); 
						 }					 
					 }
					 
					 //School Year
					 $pdf->SetXY(118, 52);
					 $pdf->Write(1, $sy);						 				 
				}
				 //End of Grade 10 Part 1				
				
				 //Start of Grade 10 Summer
				elseif($i==8)
				{
				 $filipinocount=0;
				 $filipinoFirst=0;
				 $filipinoSecond=0;
				 $filipinoThird=0;
				 $filipinoFourth=0;
				 $englishcount=0;
				 $englishFirst=0;
				 $englishSecond=0;
				 $englishThird=0;
				 $englishFourth=0;
				 $mathcount=0;
				 $mathFirst=0;
				 $mathSecond=0;
				 $mathThird=0;
				 $mathFourth=0;
				 $sciencecount=0;
				 $scienceFirst=0;
				 $scienceSecond=0;
				 $scienceThird=0;
				 $scienceFourth=0;
				 $apcount=0;
				 $apFirst=0;
				 $apSecond=0;
				 $apThird=0;
				 $apFourth=0;
				 $tlecount=0;
				 $tleFirst=0;
				 $tleSecond=0;
				 $tleThird=0;
				 $tleFourth=0;
				 $mapehcount=0;
				 $mapehFirst=0;
				 $mapehSecond=0;
				 $mapehThird=0;
				 $mapehFourth=0;
				 $epcount=0;
				 $epFirst=0;
				 $epSecond=0;
				 $epThird=0;
				 $epFourth=0;

				 //School
					 $pdf->SetXY(127, 53);
					 $pdf->Write(1, $school);
					 
					$q="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10-SUMMER') AND gt.lrn='$lrn'";
					$res=mysql_query($q); 
					$totrows=mysql_num_rows($res);
					if($totrows==0)
					{
						$sy="";
					}
					 
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='First') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFirst=$finalGrade;
							 $pdf->SetXY(69, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFirst=$finalGrade;
							 $pdf->SetXY(69, 72.5);
							 $pdf->Write(1, $letter);
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFirst=$finalGrade;
							 $pdf->SetXY(69, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFirst=$finalGrade;
							 $pdf->SetXY(69, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFirst=$finalGrade;
							 $pdf->SetXY(69, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFirst=$finalGrade;
							 $pdf->SetXY(69, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFirst=$finalGrade;
							 $pdf->SetXY(69, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFirst=$finalGrade;
							 $pdf->SetXY(69, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }
					 
					 //Second Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Second') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoSecond=$finalGrade;
							 $pdf->SetXY(86, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishSecond=$finalGrade;
							 $pdf->SetXY(86, 72.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathSecond=$finalGrade;
							 $pdf->SetXY(86, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceSecond=$finalGrade;
							 $pdf->SetXY(86, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apSecond=$finalGrade;
							 $pdf->SetXY(86, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleSecond=$finalGrade;
							 $pdf->SetXY(86, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehSecond=$finalGrade;
							 $pdf->SetXY(86, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epSecond=$finalGrade;
							 $pdf->SetXY(86, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }							
					 }					 
					 
					 //Third Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Third') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoThird=$finalGrade;
							 $pdf->SetXY(104, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishThird=$finalGrade;
							 $pdf->SetXY(104, 72.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathThird=$finalGrade;
							 $pdf->SetXY(104, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceThird=$finalGrade;
							 $pdf->SetXY(104, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount= $sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apThird=$finalGrade;
							 $pdf->SetXY(104, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleThird=$finalGrade;
							 $pdf->SetXY(104, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehThird=$finalGrade;
							 $pdf->SetXY(104, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epThird=$finalGrade;
							 $pdf->SetXY(104, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }							 
					 
					 //Fourth Grading
					 $query="SELECT sub.subjectid, sub.subjectname, gt.*, scm.syname FROM gradetxn AS gt, schoolyearmaster as scm, subjectmaster as sub WHERE gt.gradeid=(SELECT gradeid FROM gradelevelmaster WHERE description='10-SUMMER') AND gt.gradingperiod=(SELECT periodid FROM gradingperiodmaster WHERE description='Fourth') AND gt.syid=scm.syid AND gt.subjectid=sub.subjectid AND gt.lrn='$lrn'";
					 $result=mysql_query($query);
					 while ($row=mysql_fetch_array($result))
					 {
						$id=$row['subjectid'];
						$sy=$row['syname'];
						$subjectname=$row['subjectname'];
						$fg=$row['finalgrade'];
						$finalGrade= round($fg,0);														
						
						$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
						$res=mysql_query($q);
						while($r=mysql_fetch_array($res))
						{
							$letter=$r['conversionletter'];
						}							
						
						if($id==1)
						{
							 //Filipino
							 $filipinoFourth=$finalGrade;
							 $pdf->SetXY(121, 68.5);
							 $pdf->Write(1, $letter);
							 $filipinocount=$filipinocount+1;
						}
						else if($id==2)
						{
							 //English
							 $englishFourth=$finalGrade;
							 $pdf->SetXY(121, 72.5);
							 $pdf->Write(1, $letter); 
							 $englishcount=$englishcount+1;
					    }
						else if($id==3)
						{
							 //Mathematics
							 $mathFourth=$finalGrade;
							 $pdf->SetXY(121, 76.5);
							 $pdf->Write(1, $letter); 
							 $mathcount=$mathcount+1;
					    }
						else if($id==4)
						{
							 //Science
							 $scienceFourth=$finalGrade;
							 $pdf->SetXY(121, 80.5);
							 $pdf->Write(1, $letter); 
							 $sciencecount=$sciencecount+1;
					    }
						else if($id==5)
						{
							 //AP
							 $apFourth=$finalGrade;
							 $pdf->SetXY(121, 85);
							 $pdf->Write(1, $letter); 
							 $apcount=$apcount+1;
					    }		
						else if($id==6)
						{
							 //TLE
							 $tleFourth=$finalGrade;
							 $pdf->SetXY(121, 90);
							 $pdf->Write(1, $letter); 
							 $tlecount=$tlecount+1;
					    }	
						else if($id==7 )
						{
							 //MAPEH
							 $mapehFourth=$finalGrade;
							 $pdf->SetXY(121, 95);
							 $pdf->Write(1, $letter); 
							 $mapehcount=$mapehcount+1;
					    }	
						else if($id==8)
						{
							 //EP
							 $epFourth=$finalGrade;
							 $pdf->SetXY(121, 112);
							 $pdf->Write(1, $letter); 
							 $epcount=$epcount+1;
					    }								
					 }					 
					 
					 //Average
					 //Filipino
					 if ($filipinocount>0)
					 {
						 $aveFilipino=round(($filipinoFirst+$filipinoSecond+$filipinoThird+$filipinoFourth)/$filipinocount,0);
						 $pdf->SetXY(137, 68.5);
						 $pdf->Write(1, $aveFilipino); 
						 
						 if($aveFilipino<75)
						 {
							 $pdf->SetXY(146.5, 68.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 68.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //English
					 if($englishcount>0)
					 {
						 $aveEnglish=round(($englishFirst+$englishSecond+$englishThird+$englishFourth)/$englishcount,0);
						 $pdf->SetXY(137, 72.5);
						 $pdf->Write(1, $aveEnglish); 	

						 if($aveEnglish<75)
						 {
							 $pdf->SetXY(146.5, 72.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 72.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Mathematics
					 if($mathcount>0)
					 {
						 $aveMath=round(($mathFirst+$mathSecond+$mathThird+$mathFourth)/$mathcount,0);
						 $pdf->SetXY(137, 76.5);
						 $pdf->Write(1, $aveMath); 						 

						 if($aveMath<75)
						 {
							 $pdf->SetXY(146.5, 76.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 76.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //Science
					 if($sciencecount>0)
					 {
						 $aveScience=round(($scienceFirst+$scienceSecond+$scienceThird+$scienceFourth)/$sciencecount,0);
						 $pdf->SetXY(137, 80.5);
						 $pdf->Write(1, $aveScience); 					 
						 
						 if($aveScience<75)
						 {
							 $pdf->SetXY(146.5, 80.5);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 80.5);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //AP
					 if($apcount>0)
					 {
						 $aveAp=round(($apFirst+$apSecond+$apThird+$apFourth)/$apcount,0);
						 $pdf->SetXY(137, 85);
						 $pdf->Write(1, $aveAp); 					 
						 
						 if($aveAp<75)
						 {
							 $pdf->SetXY(146.5, 85);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 85);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //TLE
					 if($tlecount>0)
					 {
						 $aveTle=round(($tleFirst+$tleSecond+$tleThird+$tleFourth)/$tlecount,0);
						 $pdf->SetXY(137, 90);
						 $pdf->Write(1, $aveTle); 					 
						
						 if($aveTle<75)
						 {
							 $pdf->SetXY(146.5, 90);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 90);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					//MAPEH
					if($mapehcount>0)
					{
						 $aveMapeh=round(($mapehFirst+$mapehSecond+$mapehThird+$mapehFourth)/$mapehcount,0);
						 $pdf->SetXY(137, 95);
						 $pdf->Write(1, $aveMapeh); 					 
						 
						 if($aveMapeh<75)
						 {
							 $pdf->SetXY(146.5, 95);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 95);
							 $pdf->Write(1, "P"); 
						 }
					 }
					 
					 //EP
					 if($epcount>0)
					 {
						 $aveEP=round(($epFirst+$epSecond+$epThird+$epFourth)/$epcount,0);
						 $pdf->SetXY(137, 112);
						 $pdf->Write(1, $aveEP); 					 
						 
						 if($aveEP<75)
						 {
							 $pdf->SetXY(146.5, 112);
							 $pdf->Write(1, "F"); 
						 }
						 else
						 {
							 $pdf->SetXY(146.5, 112);
							 $pdf->Write(1, "P"); 
						 }					 
					 }
					 
					 //School Year
					 $pdf->SetXY(50, 53);
					 $pdf->Write(1, $sy);
					
					 $studname=$full;
					 $day=date("j").date("S");
					 $m=date("F");
					 $y=date("Y");
					 //Name
					 $pdf->SetXY(98, 140);
					 $pdf->Write(1, $studname);					 
					 
					 //Day
					 $pdf->SetXY(110, 143.5);
					 $pdf->Write(1, $day);							 
					 //Month
					 $pdf->SetXY(136, 143.5);
					 $pdf->Write(1, $m);	
					 //Year
					 $pdf->SetXY(165, 143.5);
					 $pdf->Write(1, $y);	
					 
					 //Principal
					 $query="SELECT description FROM informationmaster WHERE infoid=3";
					 $result=mysql_query($query);
					 while($row=mysql_fetch_array($result))
					 {
						$p=$row['description'];
					 }
					 
					 $pdf->SetFont('courier','B');
					 $pdf->SetXY(148, 151);
					 $pdf->Write(1, $p);						 
				}
				//End of Grade 10 Summer				
				 $i++;
			} while($i <= $pagecount);
		
			 $pdf->Output();
		}
	}	
		
	function createGoodMoral($studentName,$day,$m,$sy)
	{
		
		require_once('fpdf/fpdf.php');
		require_once('fpdi/fpdi.php');

		// initiate FPDI
		$pdf = new FPDI();

		// set the sourcefile
		$sourceFileName = 'PDF Template/GMC.pdf';

		//Set the source PDF file
		$pagecount = $pdf->setSourceFile($sourceFileName);

		$pdf->SetFont('courier','B');
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFontSize(12);

		$i = 1;
		do {
			// add a page
			$pdf->AddPage();
			// import page
			$tplidx = $pdf->ImportPage($i); 

			 $pdf->useTemplate($tplidx, 10, 10, 200);
			 
			 $pdf->SetFont('courier','b');
			 $pdf->SetTextColor(0,0,0);
			 $pdf->SetFontSize(12);

			 //Student Name
			 $pdf->SetXY(93, 116);
			 $pdf->Write(1, $studentName);
		 
			 //Day
			 $pdf->SetXY(112, 148);
			 $pdf->Write(1, $day);

			 //Month
			 $pdf->SetXY(143, 148);
			 $pdf->Write(1, $m);

			 //SY
			 $pdf->SetXY(93, 121);
			 $pdf->Write(1, "S.Y. ".$sy);
			 $i++;

		} while($i <= $pagecount);


		$pdf->SetFont('courier','B');
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFontSize(12);

		$query="SELECT description FROM informationmaster WHERE infoid=3";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{
			//officer
			 $pdf->SetXY(114, 190);
			 $pdf->Write(1,$row['description']);		
		}
		
		$pdf->Output();

		}

	function displayRequirementsMasterlist()
	{
		if(empty($_GET['page']))
		{
			$query="SELECT rm.*, rt.description as reg FROM requirementmaster as rm, registrationtypemaster as rt WHERE rm.regid=rt.registrationid ORDER BY rt.description, rm.description ASC";
		}
		if(!empty($_GET['page']))
		{
			$query="SELECT rm.*, rt.description as reg FROM requirementmaster as rm, registrationtypemaster as rt WHERE rm.regid=rt.registrationid ORDER BY rt.description, rm.description ASC";
		}
		$result=mysql_query($query);
		$t=mysql_num_rows($result);
		if($t==0)
		{
?>
		<tr>
			<td align="center" colspan=5><strong>No data found.</strong></td>
		</tr>
<?php
		}
		else
		{
			$per_page=3;
			$result=mysql_query($query);
			$total_results=mysql_num_rows($result);
			$total_pages=ceil($total_results/$per_page);

			if (isset($_GET['page']) && is_numeric($_GET['page']))
			{
				$show_page=$_GET['page'];
				if($show_page>0 && $show_page<=$total_pages)
				{
					$start=($show_page-1)*$per_page;
					$end= $start+$per_page;
				}
				else
				{
					$start=0;
					$end=$per_page;
				}
			}
			else
			{
				$start=0;
				$end=$per_page;
			}
			if($total_results==0)
			{
?>
				<tr>
					<td align="center" colspan=5><strong>No data found.</strong></td>
				</tr>
<?php
			}
			else
			{
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
					$regtype=mysql_result($result,$i,'reg');
					$reqtype=mysql_result($result,$i,'reqtype');
					$docid=mysql_result($result,$i,'docid');
					if($reqtype==0)
					{
						$reqtype="Optional";
					}
					else
					{
						$reqtype="Mandatory";
					}
					
					echo "<tr>";
					echo '<td align="center">'. mysql_result($result,$i,'reg') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td align="center">'. $reqtype .'</td>';

?>
					<td align="center"><a class="myLinks" href="edit_requirements.php?docid=<?php echo $docid; ?>"><img src="images/Modify.ico">&nbsp;&nbsp;Edit</a></td>
					<td align="center"><a class="myLinks" onclick="return confirm('Are you sure you want to delete this document?'); return false;" href="delete_requirements_exec.php?docid=<?php echo($docid); ?>"><img src="images/delete.ico">&nbsp;&nbsp;Delete</a></td>
<?php
					echo "</tr>";			
				}
			}
		}		
	}

	function displayPageRequirementstMasterlist()
	{
		$query="SELECT rm.*, rt.description as reg FROM requirementmaster as rm, registrationtypemaster as rt WHERE rm.regid=rt.registrationid ORDER BY rt.description, rm.description ASC";
		$res=mysql_query($query);
		$per_page=3;
		$total_results=mysql_num_rows($res);
		$total_pages=ceil($total_results/$per_page);	
		if($total_results>1)
		{
			echo "Page:";
			for($i=1; $i<=$total_pages; $i++)
			{
				echo "<a href='requirements_management.php?page=$i' class='myLinks'>$i</a>";
			}
		}
	}
	
	function create138($lrn)
	{
		require_once('fpdf/fpdf.php');
		require_once('fpdi/fpdi.php');

		// initiate FPDI
		$pdf = new FPDI();
		
		// set the sourcefile
		$sourceFileName = 'PDF Template/form 138.pdf';
		
		//Set the source PDF file
		$pagecount = $pdf->setSourceFile($sourceFileName);
		
		//Student Details
		$query="select * from studentmaster as sm
				left outer join usermaster as um 
				on sm.userid = um.userid
				left outer join gradelevelmaster as glm
				on sm.gradeid = glm.gradeid
				left outer join sectionmaster as sem 
				on sm.sectionid = sem.sectionid and sm.gradeid = sem.gradeid
				WHERE sm.lrn = '$lrn'";
		
		//variables
		$gradeid = '';
		$f1 = 0;
		$f1count = 0;
		$eng = 0;
		$engcount = 0;
		$math = 0;
		$mathcount = 0;
		$sci = 0;
		$scicount = 0;
		$ap = 0;
		$apcount = 0;
		$tle = 0;
		$tlecount = 0;
		$map = 0;
		$mapcount = 0;
		$esp = 0;
		$espcount = 0;
		$schoolyear = '';
		
		
		$result=mysql_query($query);
		while ($row=mysql_fetch_array($result))		
		{
			$lrn=$row['lrn'];
			$fname=$row['fname'];
			$mname=$row['mname'];
			$lname=$row['lname'];
			$full=$lname.", ".$fname." ".$mname;
			$bday=$row['birthday'];
			if($row['sex']==0)
			{
				$g="M";
			}
			else
			{
				$g="F";
			}
			$bplace=$row['birthplace'];
			$mother=$row['mother'];
			$motherocc=$row['motherocc'];
			$radd=$row['address'];
			$elem="Camp Crame High School";
			$gradesection = $row['description'] . " - " . $row['section'];
			$gradeid = $row['gradeid'];
		
		}
		
		$i = 1;
		do {
			// add a page
			$pdf->AddPage();
			// import page
			$tplidx = $pdf->ImportPage($i); 

			 $pdf->useTemplate($tplidx, 10, 10, 200);
			 
			 $pdf->SetFont('Courier','b');
			 $pdf->SetTextColor(0,0,0);
			 $pdf->SetFontSize(10);
			 if($i == 1)
			 {
			 //LRN
			 $pdf->SetXY(165, 33);
			 $pdf->Write(1, $lrn);

			 //Student Name
			 $pdf->SetXY(28, 38);
			 $pdf->Write(1, $full);
			 
			 $pdf->SetFontSize(8);
			 
			 //School
			 $pdf->SetXY(45, 49);
			 $pdf->Write(1, "Camp Crame High School");
			 
			 //GradeandSection
			 $pdf->SetXY(165, 49);
			 $pdf->Write(1,$gradesection);
			 
			 //plot grade
			 $query = "select * from studentmaster as sm
				left outer join gradetxn as gt 
				on sm.lrn = gt.lrn and sm.gradeid = gt.gradeid
				left outer join subjectmaster as sbm
				on gt.subjectid = sbm.subjectid
				LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
				where sm.lrn = '$lrn' and gt.gradingperiod = 1 and gt.gradeid=$gradeid";
				
			 $result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
										
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(69, 64);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
						
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(69, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(69, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(69, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(69, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(69, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(69, 91);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;

						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(69, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}
			
			$query = "select * from studentmaster as sm
				left outer join gradetxn as gt 
				on sm.lrn = gt.lrn and sm.gradeid = gt.gradeid
				left outer join subjectmaster as sbm
				on gt.subjectid = sbm.subjectid
				LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
				where sm.lrn = '$lrn' and gt.gradingperiod = 2 and gt.gradeid=$gradeid";
			 
			 $result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(86, 64);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(86, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(86, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(86, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(86, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(86, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(86, 91);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;

						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(86, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}
			 
			 $query = "select * from studentmaster as sm
				left outer join gradetxn as gt 
				on sm.lrn = gt.lrn and sm.gradeid = gt.gradeid
				left outer join subjectmaster as sbm
				on gt.subjectid = sbm.subjectid
				LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
				where sm.lrn = '$lrn' and gt.gradingperiod = 3 and gt.gradeid=$gradeid";
			 
			 $result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}							
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(103, 64);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(103, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(103, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(103, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(103, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(103, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(103, 91);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;

						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(103, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}
				
			$query = "select * from studentmaster as sm
				left outer join gradetxn as gt 
				on sm.lrn = gt.lrn and sm.gradeid = gt.gradeid
				left outer join subjectmaster as sbm
				on gt.subjectid = sbm.subjectid
				LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
				where sm.lrn = '$lrn' and gt.gradingperiod = 4 and gt.gradeid=$gradeid";
				
			$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}						
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(120, 64);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(120, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(120, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(120, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(120, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(120, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(120, 91);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;

						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(120, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}
				
				//average
				if($f1count>0)
				{
					//filipino
					$pdf->SetXY(136, 64);
					$pdf->Write(1,round($f1/$f1count,0));
					if(round($f1/$f1count,0) < 75)
					{
						$pdf->SetXY(146.5, 64);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 64);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($engcount>0)
				{
					//English
					$pdf->SetXY(136, 69);
					$pdf->Write(1,round($eng/$engcount,0));
					if(round($eng/$engcount,0) < 75)
					{
						$pdf->SetXY(146.5, 69);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 69);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($mathcount>0)
				{
					//Mathematics
					$pdf->SetXY(136, 73);
					$pdf->Write(1,round($math/$mathcount,0));
					if(round($math/$mathcount,0) < 75)
					{
						$pdf->SetXY(146.5, 73);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						
						$pdf->SetXY(146.5, 73);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($scicount>0)
				{
					//Science
					$pdf->SetXY(136, 77);
					$pdf->Write(1,round($sci/$scicount,0));
					if(round($sci/$scicount,0) < 75)
					{
						$pdf->SetXY(146.5, 77);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 77);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($apcount>0)
				{
					//Araling Panlipunan
					$pdf->SetXY(136, 81);
					$pdf->Write(1,round($ap/$apcount,0));
					if(round($ap/$apcount,0) < 75)
					{
						$pdf->SetXY(146.5, 81);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 81);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($tlecount>0)
				{
					//TLE
					$pdf->SetXY(136, 86);
					$pdf->Write(1,round($tle/$tlecount,0));
					if(round($tle/$tlecount,0) < 75)
					{
						$pdf->SetXY(146.5, 86);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 86);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($mapcount>0)
				{
					//MAPEH
					$pdf->SetXY(136, 91);
					$pdf->Write(1,round($map/$mapcount,0));
					if(round($map/$mapcount,0) < 75)
					{
						$pdf->SetXY(146.5, 91);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 91);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($espcount>0)
				{
					//EsP
					$pdf->SetXY(136, 112);
					$pdf->Write(1,round($esp/$espcount,0));
					if(round($esp/$espcount,0) < 75)
					{
						$pdf->SetXY(146.5, 112);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 112);
					    $pdf->Write(1, "P"); 
					}
				}
				
				//SchoolYear
			    $pdf->SetXY(118, 49);
			    $pdf->Write(1, $schoolyear);
				
			}
			 
			 if($i == 2) //summer
			 {
			 $pdf->SetFontSize(8);
			  //School
			 $pdf->SetXY(128, 50);
			 $pdf->Write(1, $elem);
			 
			 //grade 7 summer 
			 if($gradeid == '1') 
			 {
				//variables
				$gradeid = '';
				$f1 = 0;
				$f1count = 0;
				$eng = 0;
				$engcount = 0;
				$math = 0;
				$mathcount = 0;
				$sci = 0;
				$scicount = 0;
				$ap = 0;
				$apcount = 0;
				$tle = 0;
				$tlecount = 0;
				$map = 0;
				$mapcount = 0;
				$esp = 0;
				$espcount = 0;
				$schoolyear = '';
		
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '7' and gt.gradingperiod = '1' ";
				
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];

					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}							
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(69, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(69, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(69, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(69, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(69, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
						
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(69, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(69, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}

					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(69, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '7' and gt.gradingperiod = '2'";
				
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}								
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(86, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(86, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(86, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(86, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(86, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(86, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(86, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}

					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(86, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '7' and gt.gradingperiod = '3'";
				
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];

					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}													
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(103, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(103, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(103, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(103, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(103, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(103, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(103, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}

					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(103, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '7' and gt.gradingperiod = '4'";
				
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}						
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(120, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(120, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(120, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(120, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(120, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(120, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(120, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}

					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(120, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//average
				if($f1count>0)
				{
					//filipino
					$pdf->SetXY(136, 64);
					$pdf->Write(1,round($f1/$f1count,0));
					if(round($f1/$f1count,0) < 75)
					{
						$pdf->SetXY(146.5, 64);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 64);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($engcount>0)
				{
					//English
					$pdf->SetXY(136, 69);
					$pdf->Write(1,round($eng/$engcount,0));
					if(round($eng/$engcount,0) < 75)
					{
						$pdf->SetXY(146.5, 69);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 69);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($mathcount>0)
				{
					//Mathematics
					$pdf->SetXY(136, 73);
					$pdf->Write(1,round($math/$mathcount,0));
					if(round($math/$mathcount,0) < 75)
					{
						$pdf->SetXY(146.5, 73);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 73);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($scicount>0)
				{
					//Science
					$pdf->SetXY(136, 77);
					$pdf->Write(1,round($sci/$scicount,0));
					if(round($sci/$scicount,0) < 75)
					{
						$pdf->SetXY(146.5, 77);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 77);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($apcount>0)
				{
					//Araling Panlipunan
					$pdf->SetXY(136, 81);
					$pdf->Write(1,round($ap/$apcount,0));
					if(round($ap/$apcount,0) < 75)
					{
						$pdf->SetXY(146.5, 81);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 81);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($tlecount>0)
				{
					//TLE
					$pdf->SetXY(136, 86);
					$pdf->Write(1,round($tle/$tlecount,0));
					if(round($tle/$tlecount,0) < 75)
					{
						$pdf->SetXY(146.5, 86);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 86);
					    $pdf->Write(1, "P"); 
					}
				}
				
				if($mapcount>0)
				{
					//MAPEH
					$pdf->SetXY(136, 91);
					$pdf->Write(1,round($map/$mapcount,0));
					if(round($map/$mapcount,0) < 75)
					{
						$pdf->SetXY(146.5, 91);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 91);
					    $pdf->Write(1, "P");
					}
				}
				
				if($espcount>0)
				{
					//EsP
					$pdf->SetXY(136, 112);
					$pdf->Write(1,round($esp/$espcount,0));
					if(round($esp/$espcount,0) < 75)
					{
						$pdf->SetXY(146.5, 112);
					    $pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 112);
					    $pdf->Write(1, "P"); 
					}
				}
				
				
				//SchoolYear
				$pdf->SetXY(50, 50);
				$pdf->Write(1,$schoolyear);
				
				
				$studname=$full;
					 $day=date("j").date("S");
					 $m=date("F");
					 $y=date("Y");
					 //Name
					 $pdf->SetXY(98, 140);
					 $pdf->Write(1, $studname);					 
					 
					 //Day
					 $pdf->SetXY(110, 143.5);
					 $pdf->Write(1, $day);							 
					 //Month
					 $pdf->SetXY(136, 143.5);
					 $pdf->Write(1, $m);	
					 //Year
					 $pdf->SetXY(165, 143.5);
					 $pdf->Write(1, $y);	

					 //SchoolYear
					// $pdf->SetXY(30, 30);
					// $pdf->Write(1, $schoolyear);
					 
				//Principal
				$query="SELECT description FROM informationmaster WHERE infoid=3";
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
					{
					$p=$row['description'];
					}
				
				$pdf->SetFont('courier','B');
					 $pdf->SetXY(148, 151);
					 $pdf->Write(1, $p);	
				
				
			}//end if grade = 1(grade 7 summer)
			 
							$engcount = $engcount + 1;

			 //grade 8 summer 
			if($gradeid == '2') 
			{
			 
				//variables
				$gradeid = '';
				$f1 = 0;
				$f1count = 0;
				$eng = 0;
				$engcount = 0;
				$math = 0;
				$mathcount = 0;
				$sci = 0;
				$scicount = 0;
				$ap = 0;
				$apcount = 0;
				$tle = 0;
				$tlecount = 0;
				$map = 0;
				$mapcount = 0;
				$esp = 0;
				$espcount = 0;
				$schoolyear = '';
				
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '8' and gt.gradingperiod = '1'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];

					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}						
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(69, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(69, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(69, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(69, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(69, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(69, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(69, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}

					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(69, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '8' and gt.gradingperiod = '2'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}	
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(86, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(86, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(86, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(86, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(86, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(86, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(86, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}

					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(86, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '8' and gt.gradingperiod = '3'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}	
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(103, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(103, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(103, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(103, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(103, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(103, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(103, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}

					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(103, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '8' and gt.gradingperiod = '4'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}						
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(120, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(120, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(120, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(120, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(120, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(120, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(120, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}

					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(120, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//average
				//filipino
				if($f1count>0)
				{
					$pdf->SetXY(136, 64);
					$pdf->Write(1,round($f1/$f1count,0));
					if(round($f1/$f1count,0) < 75)
					{
						$pdf->SetXY(146.5, 64);					    
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 64);					    
						$pdf->Write(1, "P"); 
					}
				}
				
				if($engcount>0)
				{				
				//English
					$pdf->SetXY(136, 69);
					$pdf->Write(1,round($eng/$engcount,0));
					if(round($eng/$engcount,0) < 75)
					{
						$pdf->SetXY(146.5, 69);					    
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 69);					    
						$pdf->Write(1, "P"); 
					}
				}
				
				if($mathcount>0)
				{					
				//Mathematics
					$pdf->SetXY(136, 73);
					$pdf->Write(1,round($math/$mathcount,0));
					if(round($math/$mathcount,0) < 75)
					{
						$pdf->SetXY(146.5, 73);					    
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 73);					    
						$pdf->Write(1, "P"); 
					}
				}
				
				if($scicount>0)
				{					
				//Science
					$pdf->SetXY(136, 77);
					$pdf->Write(1,round($sci/$scicount,0));
					if(round($sci/$scicount,0) < 75)
					{
						$pdf->SetXY(146.5, 77);					    
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 77);					    
						$pdf->Write(1, "P"); 
					}
				}
				
				if($apcount>0)
				{					
				//Araling Panlipunan
					$pdf->SetXY(136, 81);
					$pdf->Write(1,round($ap/$apcount,0));
					if(round($ap/$apcount,0) < 75)
					{
						$pdf->SetXY(146.5, 81);					    
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 81);					    
						$pdf->Write(1, "P"); 
					}
				}
				
				if($tlecount>0)
				{				
				//TLE
					$pdf->SetXY(136, 86);
					$pdf->Write(1,round($tle/$tlecount,0));
					if(round($tle/$tlecount,0) < 75)
					{
						$pdf->SetXY(146.5, 86);					    
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 86);					    
						$pdf->Write(1, "P"); 
					}
				}
				
				if($mapcount>0)
				{				
				//MAPEH
					$pdf->SetXY(136, 91);
					$pdf->Write(1,round($map/$mapcount,0));
					if(round($map/$mapcount,0) < 75)
					{
						$pdf->SetXY(146.5, 91);					    
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 91);					    
						$pdf->Write(1, "P"); 
					}
				}
				
				if($espcount>0)
				{
				//EsP
					$pdf->SetXY(136, 112);
					$pdf->Write(1,round($esp/$espcount,0));
					if(round($esp/$espcount,0) < 75)
					{
						$pdf->SetXY(146.5, 112);					    
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 112);					    
						$pdf->Write(1, "P"); 
					}
				}
				
				$studname=$full;
					 $day=date("j").date("S");
					 $m=date("F");
					 $y=date("Y");
					 //Name
					 $pdf->SetXY(98, 140);
					 $pdf->Write(1, $studname);					 
					 
					 //Day
					 $pdf->SetXY(110, 143.5);
					 $pdf->Write(1, $day);							 
					 //Month
					 $pdf->SetXY(136, 143.5);
					 $pdf->Write(1, $m);	
					 //Year
					 $pdf->SetXY(165, 143.5);
					 $pdf->Write(1, $y);		
					 
				//Principal
				$query="SELECT description FROM informationmaster WHERE infoid=3";
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
					{
					$p=$row['description'];
					}
				
				$pdf->SetFont('courier','B');
					 $pdf->SetXY(148, 151);
					 $pdf->Write(1, $p);	
				
				
			}//end if grade = 1(grade 8 summer)
			 
			 //grade 9 summer 
			 elseif($gradeid == '3') 
			{
			 
				//variables
			$gradeid = '';
			$f1 = 0;
			$f1count = 0;
			$eng = 0;
			$engcount = 0;
			$math = 0;
			$mathcount = 0;
			$sci = 0;
			$scicount = 0;
			$ap = 0;
			$apcount = 0;
			$tle = 0;
			$tlecount = 0;
			$map = 0;
			$mapcount = 0;
			$esp = 0;
			$espcount = 0;
			$schoolyear = '';
			
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '9' and gt.gradingperiod = '1'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(69, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(69, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(69, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(69, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(69, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(69, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(69, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(69, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '9' and gt.gradingperiod = '2'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(86, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(86, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(86, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(86, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(86, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(86, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(86, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(86, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '9' and gt.gradingperiod = '3'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(103, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(103, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(103, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(103, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(103, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(103, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(103, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(103, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '9' and gt.gradingperiod = '4'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(120, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(120, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(120, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(120, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(120, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(120, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(120, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(120, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//average
				//filipino
				if($f1count > 0)
				{
					$pdf->SetXY(136, 64);
					$pdf->Write(1,round($f1/$f1count,0));
					if(round($f1/$f1count,0) < 75)
					{
						$pdf->SetXY(146.5, 64);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 64);
						$pdf->Write(1, "P");
					}
				}
				
				//English
				if(engcount > 0)
				{
					$pdf->SetXY(136, 69);
					$pdf->Write(1,round($eng/$engcount,0));
					if(round($eng/$engcount,0) < 75)
					{
						$pdf->SetXY(146.5, 69);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 69);
						$pdf->Write(1, "P");
					}
				}
				
				
				//Mathematics
				if($mathcount > 0)
				{
					$pdf->SetXY(136, 73);
					$pdf->Write(1,round($math/$mathcount,0));
					if(round($math/$mathcount,0) < 75)
					{
						$pdf->SetXY(146.5, 73);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 73);
						$pdf->Write(1, "P");
					}
				}
				
				//Science
				if($scicount > 0)
				{
					$pdf->SetXY(136, 77);
					$pdf->Write(1,round($sci/$scicount,0));
					if(round($sci/$scicount,0) < 75)
					{
						$pdf->SetXY(146.5, 77);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 77);
						$pdf->Write(1, "P");
					}
				}

				//Araling Panlipunan
				if($apcount > 0)
				{
					$pdf->SetXY(136, 81);
					$pdf->Write(1,round($ap/$apcount,0));
					if(round($ap/$apcount,0) < 75)
					{
						$pdf->SetXY(146.5, 81);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 81);
						$pdf->Write(1, "P");
					}
				}
				
				//TLE
				if($tlecount > 0)
				{
					$pdf->SetXY(136, 86);
					$pdf->Write(1,round($tle/$tlecount,0));
					if(round($tle/$tlecount,0) < 75)
					{
						$pdf->SetXY(146.5, 86);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 86);
						$pdf->Write(1, "P");
					}
				}
				
				//MAPEH
				if($mapcount > 0)
				{
					$pdf->SetXY(136, 91);
					$pdf->Write(1,round($map/$mapcount,0));
					if(round($map/$mapcount,0) < 75)
					{
						$pdf->SetXY(146.5, 91);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 91);
						$pdf->Write(1, "P");
					}
				}
				
				//EsP
				if($espcount > 0)
				{
					$pdf->SetXY(136, 112);
					$pdf->Write(1,round($esp/$espcount,0));
					if(round($esp/$espcount,0) > 0)
					{
						$pdf->SetXY(146.5, 112);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 112);
						$pdf->Write(1, "P");
					}
				}
				
				$studname=$full;
					 $day=date("j").date("S");
					 $m=date("F");
					 $y=date("Y");
					 //Name
					 $pdf->SetXY(98, 140);
					 $pdf->Write(1, $studname);					 
					 
					 //Day
					 $pdf->SetXY(110, 143.5);
					 $pdf->Write(1, $day);							 
					 //Month
					 $pdf->SetXY(136, 143.5);
					 $pdf->Write(1, $m);	
					 //Year
					 $pdf->SetXY(165, 143.5);
					 $pdf->Write(1, $y);		
					 
				//Principal
				$query="SELECT description FROM informationmaster WHERE infoid=3";
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
					{
					$p=$row['description'];
					}
				
				$pdf->SetFont('courier','B');
					 $pdf->SetXY(148, 151);
					 $pdf->Write(1, $p);	
				
				
			}//end if grade = 1(grade 9 summer)
			 
			 //grade 10 summer 
			 elseif($gradeid == '4') 
			{	
						//variables
					$gradeid = '';
					$f1 = 0;
					$f1count = 0;
					$eng = 0;
					$engcount = 0;
					$math = 0;
					$mathcount = 0;
					$sci = 0;
					$scicount = 0;
					$ap = 0;
					$apcount = 0;
					$tle = 0;
					$tlecount = 0;
					$map = 0;
					$mapcount = 0;
					$esp = 0;
					$espcount = 0;
					$schoolyear = '';
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '10' and gt.gradingperiod = '1'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(69, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(69, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(69, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(69, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(69, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(69, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(69, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(69, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '10' and gt.gradingperiod = '2'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];

					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(86, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(86, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(86, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(86, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(86, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(86, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(86, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(86, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '10' and gt.gradingperiod = '3'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];

					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(103, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(103, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(103, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(103, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(103, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(103, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(103, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(103, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '10' and gt.gradingperiod = '4'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(120, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(120, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(120, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(120, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(120, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(120, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(120, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(120, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//average
				//filipino
				if($f1count > 0)
				{
					$pdf->SetXY(136, 64);
					$pdf->Write(1,round($f1/$f1count,0));
					if(round($f1/$f1count,0) < 75)
					{
						$pdf->SetXY(146.5, 64);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 64);
						$pdf->Write(1, "P"); 
					}
				}
				
				//English
				if($engcount > 0)
				{
					$pdf->SetXY(136, 69);
					$pdf->Write(1,round($eng/$engcount,0));
					if(round($eng/$engcount,0) < 75)
					{
						$pdf->SetXY(146.5, 69);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 69);
						$pdf->Write(1, "P"); 
					}
				}
				
				//Mathematics
				if($mathcount > 0)
				{
					$pdf->SetXY(136, 73);
					$pdf->Write(1,round($math/$mathcount,0));
					if(round($math/$mathcount,0) < 75)
					{
						$pdf->SetXY(146.5, 73);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 73);
						$pdf->Write(1, "P");
					}
				}
				
				//Science
				if($scicount > 0)
				{
					$pdf->SetXY(136, 77);
					$pdf->Write(1,round($sci/$scicount,0));
					if(round($sci/$scicount,0) < 75)
					{
						$pdf->SetXY(146.5, 77);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 77);
						$pdf->Write(1, "P"); 
					}
				}
				
				//Araling Panlipunan
				if($apcount > 0)
				{
					$pdf->SetXY(136, 81);
					$pdf->Write(1,round($ap/$apcount,0));
					if(round($ap/$apcount,0) < 75)
					{
						$pdf->SetXY(146.5, 81);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 81);
						$pdf->Write(1, "P"); 
					}
				}
				
				//TLE
				if($tlecount > 0)
				{
					$pdf->SetXY(136, 86);
					$pdf->Write(1,round($tle/$tlecount,0));
					if(round($tle/$tlecount,0) < 75)
					{
						$pdf->SetXY(146.5, 86);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 86);
						$pdf->Write(1, "P"); 
					}
				}
				
				//MAPEH
				if($mapcount > 0)
				{
					$pdf->SetXY(136, 91);
					$pdf->Write(1,round($map/$mapcount,0));
					if(round($map/$mapcount,0) < 75)
					{
						$pdf->SetXY(146.5, 91);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 91);
						$pdf->Write(1, "P"); 
					}
				}
				
				//EsP
				if($espcount > 0)
				{
					$pdf->SetXY(136, 112);
					$pdf->Write(1,round($esp/$espcount,0));
					if(round($esp/$espcount,0) < 75)
					{
						$pdf->SetXY(146.5, 112);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 112);
						$pdf->Write(1, "P"); 
					}
				}
				
				$studname=$full;
					 $day=date("j").date("S");
					 $m=date("F");
					 $y=date("Y");
					 //Name
					 $pdf->SetXY(98, 140);
					 $pdf->Write(1, $studname);					 
					 
					 //Day
					 $pdf->SetXY(110, 143.5);
					 $pdf->Write(1, $day);							 
					 //Month
					 $pdf->SetXY(136, 143.5);
					 $pdf->Write(1, $m);	
					 //Year
					 $pdf->SetXY(165, 143.5);
					 $pdf->Write(1, $y);		
					 
				//Principal
				$query="SELECT description FROM informationmaster WHERE infoid=3";
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
					{
					$p=$row['description'];
					}
				
				$pdf->SetFont('courier','B');
					 $pdf->SetXY(148, 151);
					 $pdf->Write(1, $p);	
				
				
			 }//end grade 4-10 summer
			 
			 //grade 11 summer 
			 elseif($gradeid == '5') 
			{
				//variables
					$gradeid = '';
					$f1 = 0;
					$f1count = 0;
					$eng = 0;
					$engcount = 0;
					$math = 0;
					$mathcount = 0;
					$sci = 0;
					$scicount = 0;
					$ap = 0;
					$apcount = 0;
					$tle = 0;
					$tlecount = 0;
					$map = 0;
					$mapcount = 0;
					$esp = 0;
					$espcount = 0;
					$schoolyear = '';
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '11' and gt.gradingperiod = '1'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(69, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(69, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(69, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(69, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(69, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(69, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(69, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(69, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '11' and gt.gradingperiod = '2'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(86, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(86, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(86, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(86, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(86, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(86, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(86, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(86, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '11' and gt.gradingperiod = '3'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
				
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];

					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(103, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(103, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(103, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(103, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(103, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(103, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(103, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(103, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '11' and gt.gradingperiod = '4'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
				
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}				
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(120, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(120, 69);
						$pdf->Write(1, $letter);
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(120, 73);
						$pdf->Write(1, $letter);
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(120, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(120, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(120, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(120, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(120, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//average
				//filipino
				if($f1count > 0)
				{
					$pdf->SetXY(136, 64);
					$pdf->Write(1,round($f1/$f1count,0));
					if(round($f1/$f1count,0) < 75)
					{
						$pdf->SetXY(146.5, 64);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 64);
						$pdf->Write(1, "P");
					}
				
				}
				
				//English
				if($engcount > 0)
				{
					$pdf->SetXY(136, 69);
					$pdf->Write(1,round($eng/$engcount,0));
					if(round($eng/$engcount,0) < 75)
					{
						$pdf->SetXY(146.5, 69);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 69);
						$pdf->Write(1, "P");
					}
				}
				
				//Mathematics
				if($mathcount > 0)
				{
					$pdf->SetXY(136, 73);
					$pdf->Write(1,round($math/$mathcount,0));
					if(round($math/$mathcount,0) < 75)
					{
						$pdf->SetXY(146.5, 73);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 73);
						$pdf->Write(1, "P");
					}
				}
				
				//Science
				if($scicount > 0)
				{
					$pdf->SetXY(136, 77);
					$pdf->Write(1,round($sci/$scicount,0));
					if(round($sci/$scicount,0) < 75)
					{
						$pdf->SetXY(146.5, 77);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 77);
						$pdf->Write(1, "P");
					}
				}
				
				//Araling Panlipunan
				if($apcount > 0)
				{
					$pdf->SetXY(136, 81);
					$pdf->Write(1,round($ap/$apcount,0));
					if(round($ap/$apcount,0) < 75)
					{
						$pdf->SetXY(146.5, 81);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 81);
						$pdf->Write(1, "P");
					}
				}
				
				//TLE
				if($tlecount > 0)
				{
					$pdf->SetXY(136, 86);
					$pdf->Write(1,round($tle/$tlecount,0));
					if(round($tle/$tlecount,0) < 75)
					{
						$pdf->SetXY(146.5, 86);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 86);
						$pdf->Write(1, "P");
					}
				}
				
				//MAPEH
				if($mapcount > 0)
				{
					$pdf->SetXY(136, 91);
					$pdf->Write(1,round($map/$mapcount,0));
					if(round($map/$mapcount,0) < 75)
					{
						$pdf->SetXY(146.5, 91);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 91);
						$pdf->Write(1, "P");
					}
				}
				
				//EsP
				if($espcount > 0)
				{
					$pdf->SetXY(136, 112);
					$pdf->Write(1,round($esp/$espcount,0));
					if(round($esp/$espcount,0) < 75)
					{
						$pdf->SetXY(146.5, 112);
						$pdf->Write(1, "F");
					}
					else
					{
						$pdf->SetXY(146.5, 112);
						$pdf->Write(1, "P");
					}
				}
				
				$studname=$full;
					 $day=date("j").date("S");
					 $m=date("F");
					 $y=date("Y");
					 //Name
					 $pdf->SetXY(98, 140);
					 $pdf->Write(1, $studname);					 
					 
					 //Day
					 $pdf->SetXY(110, 143.5);
					 $pdf->Write(1, $day);							 
					 //Month
					 $pdf->SetXY(136, 143.5);
					 $pdf->Write(1, $m);	
					 //Year
					 $pdf->SetXY(165, 143.5);
					 $pdf->Write(1, $y);		
					 
				//Principal
				$query="SELECT description FROM informationmaster WHERE infoid=3";
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
					{
					$p=$row['description'];
					}
				
				$pdf->SetFont('courier','B');
					 $pdf->SetXY(148, 151);
					 $pdf->Write(1, $p);	
				
				
			 }//end grade 5-11 summer
			 
			 //grade 12 summer 
			 elseif($gradeid == '6') 
			 {
			 
				//variables
				$gradeid = '';
				$f1 = 0;
				$f1count = 0;
				$eng = 0;
				$engcount = 0;
				$math = 0;
				$mathcount = 0;
				$sci = 0;
				$scicount = 0;
				$ap = 0;
				$apcount = 0;
				$tle = 0;
				$tlecount = 0;
				$map = 0;
				$mapcount = 0;
				$esp = 0;
				$espcount = 0;
				$schoolyear = '';
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '12' and gt.gradingperiod = '1'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					

					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(69, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(69, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(69, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(69, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(69, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(69, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(69, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(69, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '12' and gt.gradingperiod = '2'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(86, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(86, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(86, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(86, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(86, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(86, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(86, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(86, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '12' and gt.gradingperiod = '3'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
					
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(103, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(103, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(103, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(103, 77);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$sci = $sci + $finalGrade;
							$scicount = $scicount + 1;

						}
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(103, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(103, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(103, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(103, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//plot grade
				$query = "SELECT * FROM `gradetxn` as gt
						 left outer join subjectmaster sbm on
						 gt.subjectid = sbm.subjectid
						 LEFT OUTER JOIN schoolyearmaster AS sym ON gt.syid = sym.syid
						 where gt.lrn = '$lrn'
						 and gt.gradeid = '12' and gt.gradingperiod = '4'";
				
				$result=mysql_query($query);
			 while($row=mysql_fetch_array($result))
				{
					$subjectname=$row['subjectname'];
					$subjectid = $row['subjectid'];
					$fg=$row['finalgrade'];
					$finalGrade= round($fg,0);
					$schoolyear = $row['syname'];
					
					$q="SELECT conversionletter FROM gradingconversion WHERE $fg >=grademin AND $fg<=grademax";
					$res=mysql_query($q);
					while($r=mysql_fetch_array($res))
					{
						$letter=$r['conversionletter'];
					}					
					
					if($subjectid == '1')
					{
						//Filipino
						$pdf->SetXY(120, 65);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$f1  = $f1 + $finalGrade;
							$f1count = $f1count  + 1;
						}
					}
					
					if($subjectid == '2')
					{
						//English
						$pdf->SetXY(120, 69);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$eng =$eng + $finalGrade;
							$engcount = $engcount + 1;

						}
					}
					
					if($subjectid == '3')
					{
						//Mathematics
						$pdf->SetXY(120, 73);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$math = $math + $finalGrade;
							$mathcount = $mathcount + 1;

						}
					}
					
					if($subjectid == '4')
					{
						//Science
						$pdf->SetXY(120, 77);
						$pdf->Write(1, $letter);
					}
					
					if($subjectid == '5')
					{
						//Araling Panlipunan
						$pdf->SetXY(120, 81);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$ap = $ap + $finalGrade;
							$apcount = $apcount + 1;

						}
					}
					
					if($subjectid == '6')
					{
						//TLE
						$pdf->SetXY(120, 86);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$tle = $tle + $finalGrade;
							$tlecount = $tlecount + 1;

						}
					}
					
					if($subjectid == '7')
					{
						//MAPEH
						$pdf->SetXY(120, 92);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$map = $map + $finalGrade;
							$mapcount = $mapcount + 1;
						}
					}
					
					if($subjectid == '8')
					{
						//EsP
						$pdf->SetXY(120, 112);
						$pdf->Write(1, $letter);
						if($finalGrade > 0)
						{
							$esp = $esp + $finalGrade ;
							$espcount = $espcount + 1;

						}
					}
				
				}//end while
				
				//average
				//filipino
				if($f1count > 0)
				{
					$pdf->SetXY(136, 64);
					$pdf->Write(1,round($f1/$f1count,0));
					if(round($f1/$f1count,0) < 75)
					{
						$pdf->SetXY(146.5, 64);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 64);
						$pdf->Write(1, "P"); 
					}
				}
				
				//English
				if($engcount > 0)
				{
					$pdf->SetXY(136, 69);
					$pdf->Write(1,round($eng/$engcount,0));
					if(round($eng/$engcount,0) < 75)
					{
						$pdf->SetXY(146.5, 69);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 69);
						$pdf->Write(1, "P"); 
					}
				}
				
				//Mathematics
				if($mathcount > 0)
				{
					$pdf->SetXY(136, 73);
					$pdf->Write(1,round($math/$mathcount,0));
					if(round($math/$mathcount,0) < 75)
					{
						$pdf->SetXY(146.5, 73);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 73);
						$pdf->Write(1, "P"); 
					}
				}
				
				//Science
				if($scicount > 0)
				{
					$pdf->SetXY(136, 77);
					$pdf->Write(1,round($sci/$scicount,0));
					if(round($sci/$scicount,0) < 75)
					{
						$pdf->SetXY(146.5, 77);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 77);
						$pdf->Write(1, "P"); 
					}
				}
				
				//Araling Panlipunan
				if($apcount > 0)
				{
					$pdf->SetXY(136, 81);
					$pdf->Write(1,round($ap/$apcount,0));
					if(round($ap/$apcount,0) < 75)
					{
						$pdf->SetXY(146.5, 81);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 81);
						$pdf->Write(1, "P"); 
					}
				}
				
				//TLE
				if($tlecount > 0)
				{
					$pdf->SetXY(136, 86);
					$pdf->Write(1,round($tle/$tlecount,0));
					if(round($tle/$tlecount,0) < 75)
					{
						$pdf->SetXY(146.5, 86);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 86);
						$pdf->Write(1, "P"); 
					}
				}
				
				//MAPEH
				if($mapcount > 0)
				{
					$pdf->SetXY(136, 91);
					$pdf->Write(1,round($map/$mapcount,0));
					if(round($map/$mapcount,0) < 75)
					{
						$pdf->SetXY(146.5, 91);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 91);
						$pdf->Write(1, "P"); 
					}
				}
				
				//EsP
				if($espcount > 0)
				{
					$pdf->SetXY(136, 112);
					$pdf->Write(1,round($esp/$espcount,0));
					if(round($esp/$espcount,0) < 75)
					{
						$pdf->SetXY(146.5, 112);
						$pdf->Write(1, "F"); 
					}
					else
					{
						$pdf->SetXY(146.5, 112);
						$pdf->Write(1, "P"); 
					}
				}
				
				
				$studname=$full;
					 $day=date("j").date("S");
					 $m=date("F");
					 $y=date("Y");
					 //Name
					 $pdf->SetXY(98, 140);
					 $pdf->Write(1, $studname);					 
					 
					 //Day
					 $pdf->SetXY(110, 143.5);
					 $pdf->Write(1, $day);							 
					 //Month
					 $pdf->SetXY(136, 143.5);
					 $pdf->Write(1, $m);	
					 //Year
					 $pdf->SetXY(165, 143.5);
					 $pdf->Write(1, $y);		
					 
				//Principal
				$query="SELECT description FROM informationmaster WHERE infoid=3";
				$result=mysql_query($query);
				while($row=mysql_fetch_array($result))
					{
					$p=$row['description'];
					}
				
				$pdf->SetFont('courier','B');
					 $pdf->SetXY(148, 151);
					 $pdf->Write(1, $p);	
				
				
			 }//end grade 5-11 summer
			 
			 
			
			 }
			 
			 $i++;

		} while($i <= $pagecount);
		
		
		
		
		
		
		$pdf->Output();
		
		
		
		
	}

	
	
	
		
?>




<?php
	include("dbconfig.php");

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
			$query="SELECT glm.gradeid, sm.units, sm.subjectid, glm.description, sm.subjectname, sm.assignment, sm.attendance, sm.project, sm.quiz FROM subjectmaster as sm, gradelevelmaster as glm WHERE sm.gradeid=glm.gradeid";
		}
		if(!empty($_GET['page']))
		{
			$query="SELECT glm.gradeid, sm.units, sm.subjectid, glm.description, sm.subjectname, sm.assignment, sm.attendance, sm.project, sm.quiz FROM subjectmaster as sm, gradelevelmaster as glm WHERE sm.gradeid=glm.gradeid";
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
					echo '<td align="center">'. mysql_result($result,$i,'description') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'units') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'subjectname') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'assignment') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'attendance') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'project') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'quiz') .'</td>';

?>
					<td align="center"><a class="myLinks" onclick="updateSubject(<?php echo($gradeid); ?>,<?php echo($subjectid); ?>); return false;" href=""><img src="images/Modify.ico">&nbsp;&nbsp;Edit</a></td>
					<td align="center"><a class="myLinks" onclick="return confirm('Are you sure you want to delete this subject level?'); return false;" href="delete_subject_exec.php?gradeid=<?php echo($gradeid); ?>&&subjectid=<?php echo($subjectid); ?>"><img src="images/delete.ico">&nbsp;&nbsp;Delete</a></td>
<?php
					echo "</tr>";			
				}
			}
		}		
	}

	function displayPageSubjectMasterlist()
	{
		$query="SELECT glm.gradeid, sm.subjectid, glm.description, sm.subjectname, sm.assignment, sm.attendance, sm.project, sm.quiz FROM subjectmaster as sm, gradelevelmaster as glm WHERE sm.gradeid=glm.gradeid";
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
					if(mysql_result($result,$i,'actualcount')==0)
					{
						echo '<td align="center">'. mysql_result($result,$i,'actualcount') .'</td>';
					}
					else
					{
?>
						<td align="center"><a title="Click to View" href="view_section_student.php?gradeid=<?php echo($grade); ?>&&sectionid=<?php echo($sectionid); ?>" class="myLinks"><?php echo( mysql_result($result,$i,'actualcount')); ?></a></td>
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
		$per_page=3;
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
					echo "<tr>";
					echo '<td align="center">'. mysql_result($result,$i,'gradeid') .'</td>';
					echo '<td align="center">'. mysql_result($result,$i,'description') .'</td>';
					?>
					<td align="center"><a class="myLinks" onclick="updateGradeLevel(<?php echo($grade); ?>); return false;" href=""><img src="images/Modify.ico">&nbsp;&nbsp;Edit</a></td>
					<td align="center"><a class="myLinks" onclick="return confirm('Are you sure you want to delete this grade level?'); return false;" href="delete_grade_level_exec.php?id='.$grade.'"><img src="images/delete.ico">&nbsp;&nbsp;Delete</a></td>
					<?php
					echo "</tr>";			
				}
			}
		}		
	}
	
	function displayPageGradeLevel()
	{
		$query="SELECT * FROM gradelevelmaster";
		$res=mysql_query($query);
		$per_page=3;
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
		<table class="curvedEdges" width="640" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">		
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
	<table class="curvedEdges" width="480" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
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
		
		$status="";
		$imgName="";
		
		if($preregCount==1)
		{
			$status="Pre-Registered";
			$imgName="images/preregistered.ico";
		}
		
		else if($studentCount==1)
		{
			$status="Enrolled as Grade ".$grade." , Section ".$section;
			$imgName="images/enrolled.ico";
		}
		
?>
		<td><div align="center"><strong><strong><font size=3><img src="<?php echo($imgName); ?>"/>&nbsp;&nbsp;&nbsp;<?php echo($status); ?></font></strong></div></td>
<?php
	}
	
	function displaySection($userid)
	{
		$query1="SELECT um.userid, pm.gradeid FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid and um.userid=$userid";
		$result1=mysql_query($query1);
		while($row1=mysql_fetch_array($result1))
		{
			$gradeid=$row1['gradeid'];
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
					<td colspan=5 width="400" align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>No registered section for Grade:&nbsp;<font color="red" size=4><?php echo($gradeid); ?></font>&nbsp;.</b></td>
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
		<table class="curvedEdges" border="1" width=400 cellpadding="0" cellspacing="0" bordercolor="#FF6633">
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
		$query="SELECT um.*, rt.*, rm.*  FROM usermaster as um, requirementstxn as rt, requirementmaster as rm WHERE um.userid=rt.userid AND rt.docid=rm.docid AND um.userid=$controlnum ORDER by um.adddate ASC";
		$result=mysql_query($query);
?>
		<table class="curvedEdges" border="1" width=400 cellpadding="0" cellspacing="0" bordercolor="#FF6633">
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
		$per_page=2;
		if(empty($_GET['controlno']))
		{
			$query="SELECT um.userid, um.fname, um.mname, um.lname, pm.userid FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid ORDER BY um.userid ASC";
		}
		if(!empty($_GET['controlno']))
		{
			$controlno=$_GET['controlno'];
			$query="SELECT um.userid, um.fname, um.mname, um.lname, pm.userid FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid AND um.userid=$controlno ORDER BY um.userid ASC";
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
		<table class="PreRegMasterList" width=410 border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=5 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Preregistration Master List</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM preregmaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
			echo "<tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th colspan=2>Action</th></tr>";
			echo "<tr>";
			echo '<td colspan=4 width="750" align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
				echo "<tr><th>First Name</th><th>Middle Name</th><th>Last Name</th><th colspan=2>Action</th></tr>";
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
					echo '<td colspan=5 width="400" align="center"><img src="images/Warning.ico"/>&nbsp;&nbsp;&nbsp;<b>Control Number:&nbsp;<font color="red" size=4>'.$controlno.'</font>&nbsp;not found!</b></td>';
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
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, count(rt.docid) as total FROM studentmaster sm, usermaster um, requirementstxn rt, requirementmaster as rm WHERE sm.userid=um.userid AND sm.userid=rt.userid AND rt.docid=rm.docid AND rm.reqtype=0 AND rt.status=0 group by rt.userid";
		}
		if(!empty($_GET['lrn']))
		{
			$lrn=$_GET['lrn'];
			$query="SELECT sm.lrn, um.fname, um.mname, um.lname, count(rt.docid) as total FROM studentmaster sm, usermaster um, requirementstxn rt, requirementmaster as rm WHERE sm.userid=um.userid AND sm.userid=rt.userid AND rt.docid=rm.docid AND rm.reqtype=0 AND rt.status=0 AND sm.lrn='$lrn' group by rt.userid";
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
		<table class="PreRegMasterList" width=640 border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
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
	<center>
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
	</center>
<?php			
}
	
	function displayStudentView()
	{
		$per_page=2;
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
		<table class="PreRegMasterList" width="640" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
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
		$per_page=2;
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
		<table class="PreRegMasterList" width="640" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
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
		$per_page=1;
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
		<table class="PreRegMasterList" width="640" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
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
		$per_page=5;
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
		<table class="PreRegMasterList" width="640" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
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
		$per_page=5;
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
		<table class="PreRegMasterList" width="640" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
		<td colspan=4 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Search Result</font></strong></div></td>
<?php
		$sql="SELECT COUNT(*) as t FROM facultymaster";
		$res=mysql_query($sql);
		while ($r=mysql_fetch_array($res))
		{
			$num=$r['t'];
		}
		
		if($num==0)
		{
			echo "<tr><th>Employee No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th></tr>";
			echo "<tr>";
			echo '<td colspan=4  align="center"><b>No data found.</b></td>';
			echo "</tr>";
		}
		else
		{
			if(mysql_num_rows($result)>0)
			{
			
				echo "<tr><th>Employee No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th></tr>";
				for($i=$start; $i<$end; $i++)
				{
					if ($i==$total_results){break;}
			

					echo "<tr>";
					echo '<td width="200" align="center">'. mysql_result($result,$i,'employeeid') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'fname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'mname') .'</td>';
					echo '<td width="200" align="center">'. mysql_result($result,$i,'lname') .'</td>';
					echo "</tr>";
				}
			}
			else
			{
					echo "<tr>";
					echo "<tr><th>Employee No.</th><th>First Name</th><th>Middle Name</th><th>Last Name</th></tr>";
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

	function displayReqStat($userid)
	{
		$query="SELECT COUNT(*) as totalReqs FROM requirementstxn WHERE userid='$userid' AND status=0";
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
	
	function displayAllRequirements($userid)
	{
	//		$query="SELECT rm.docid, rm.regid, rm.description, rm.reqtype, rt.status, rt.adddate, rt.datereceived, rt.receivedby  FROM requirementmaster as rm, requirementstxn as rt, preregmaster as pm where rm.docid=rt.docid AND pm.registrationid = rm.regid AND rt.userid='$userid'";
		$query="SELECT rm.docid, rm.regid,rm.description,rm.reqtype,rt.status, rt.adddate, rt.datereceived, rt.receivedby  FROM requirementmaster as rm, requirementstxn as rt, preregmaster as pm where rm.docid=rt.docid AND pm.userid=rt.userid AND pm.registrationid = rm.regid AND rt.userid='$userid'";
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
		$query="SELECT rm.docid, rm.regid,rm.description,rm.reqtype,rt.status, rt.adddate, rt.datereceived, rt.receivedby  FROM requirementmaster as rm, requirementstxn as rt, $tblname as pm where rm.docid=rt.docid AND pm.userid=rt.userid AND rt.userid='$userid'";

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
	
	function displayGuestInfo($userid)
	{
		$query="SELECT um.*, pm.* FROM usermaster as um, preregmaster as pm WHERE um.userid=pm.userid AND um.userid ='".$userid."'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
?>		
		<table>
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
		<table>
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
	
	function displayEmpInfo($userid)
	{
		$query="SELECT um.*, fm.* FROM usermaster as um, facultymaster as fm WHERE um.userid=fm.userid AND fm.userid ='".$userid."'";
		$result=mysql_query($query);
		while($row=mysql_fetch_array($result))
		{ 
?>		
		<table>
		<tr>
			<td width=100><img src="images/name.ico"/>&nbsp;&nbsp;First Name :</td><th align="left"><?php echo $row['fname']; ?></th>
		<tr/>
		<tr>
			<td width=150><img src="images/name.ico"/>&nbsp;&nbsp;Middle Name :</td><th align="left"><?php echo $row['mname']; ?></th>
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
			<td width=100><img src="images/sex.ico"/>&nbsp;&nbsp;Sex :</td><th align="left"><?php if($row['sex']==0) { echo('Male');} else {echo('Female');}?></th>
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
	</table>
<?php
		}
	}
	
	function createPDF($uid, $regid)
	{
		if($regid==1)
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
	$sourceFileName = 'template.pdf';

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

	$query="SELECT rm.docid,rm.description FROM requirementmaster as rm, requirementstxn as rt WHERE rm.docid=rt.docid AND rt.userid=$uid";
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
?>




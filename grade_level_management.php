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
<hga`>m
|hEdq1(dt`-q�i6�#Son4ejt)Fqpe co.UeNt9"texT/ydl(; chdrs��=aKk-8'91B>	�|tm5mm<cBMPdE3i�MfXIGM)Rc_LL</�H|,a=M*8nkdg fB�lm SsS.#c3$cgs"�Zu`=3ztxjes@ea�uipU?`$\4$czs �0�scri`u!yc57jw'n1Ry>b�  0yqeeb�gxt/JavacC2lp4 ><rCpാ=	|sar�rD eRc=*{rhpto/c_RqnãpefecoNp�T$H�""z{Q%5��mx�/ka�W�vmuq~(*s{Tp�8j	sb�)hP�|ypM=�text.(u�Q{sPiq�"	f�fcd�O~0mxo6l~*ofj�4xti{�[j){bh?�2� �exv?�uJ9	�u~atio� eo't�mjb,epD1{��	)	cj>3�1 <lx�9	=t�{aQyQ��)cCr(�u li.E1igA'jaf`Qeriu~��
!~%og|aodt@dy%Wp!DeNeelig�akuY$/J	I{)
I		wy%NgwJam'=XzomP4(cfuq�(ngr �ra&eMDvų/,,3)k
 	ed *�E^+yE9=n5.l-
�	{	UD;)	de��n$>!}Y5;
		Hp�
)	Ulsd	M{�	a{((NeuNamd14�6y
�	p]			Cr!s=jILviR�a.Ara Yo� `56E iou!wen%(|m,Up|d�thi�"�kIIir(qn7==tr=eI��w
i)	��?OD�3.:�C t�oly�wXduw��'vaaG^h�reLWe�ec.qHp>�d=�gR`%g�d3%">vsr)\gw�iMg;	��My�
I�	un{'
)	��zI)� bepew�;
�) ��uM
�8d(Se	)	=�	!lE2T��A/elm""�xad%1D}~pL17(?
IIIpA��`n:HI�]
y]	
,;sbrnrt>)j��2Lpw2langea'e~goi^esssKrd&>M
$��kTion b gckBorMh7)b{	hLhld:#|l-d~1�I'fEs�vyppIgLw�T`nt5!=< ":0�z.	Ia<gstl&Rn�fe0ultdb dhg g��e evef""9;M
	�ud`mcMd+t1CgdES�pKpukol&\do�|`�	3
�AreDuPo$@.v%M*	}\��,be)BI	�M		`
s7B%p\$(;	2��qpl!�qd��3	M	y>/rcbIPx<��
-,apijE�		�dirbth�mc�eR � ��/sd:@lEfx8 Gg�mB"`80�'(V�o\!#k�E>65:0x;nhNgm�%Lj`t��'px� raloi./=toq>�<px)p�tdhhg-s�wh4� 0rx� ~iFgI.e��f&4y`�8z*)&dd6-�!ymq��eMsgm`+��9.qtq@g=t'�MMd��
<rody*�J )-)CONQqHJGR -F$eIԇS&9<nke#claw{"owN9�ife�"~�MZI87%e"hea@�V"=<eid laas=2Iq d%r�>L+	<�fI&?+-�,$/=!LA#YUGV -��M
=Liv ;~asw-�dV`cito3""aDifN� ad?t5P"2)	<>�p abht$u!'`n�Deme)nFev_�%&�7tBp�/``|3@?.
<'Do~.	J
��(,5"IAR�UEE!MLF_#%4),tiV�kL��q=`mar1�gM.fg
I	<?0l` m_Clt��p'aocltb�{F�-!2sU'd�gxt�{ _?��>?ei^>L�Iv�--$TEZD�#N�GINO�->
-|nYv<Sga�#]jqK�y�'o|�o~us?<|%-�0i~Mxt�Rbdi{ h�2m �/0f)�a/,/./��	Y-<=phr)b		I	dIrp��1!Osm:(�,JLI=JAy	FefctlGhC��3 hA]fo�m)��		(	s-	I				glO��l" urpors;
				?>
				<!-- CONTENTS -->
	  			<div class="Contents">				
					<div style="position:relative; left:25px;">
						<br>			
						<h1>Grade Level Management</h1>
						<br>
						<form action="add_grade_level_exec.php" method="POST" onSubmit="return checkForm(this); return false;" >
							<table class="curvedEdges" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
								<td colspan=4 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Add New Grade Level</font></strong></div></td>
								<tr>
									<td>Grade Level</td><td colspan=3><input autofocus type="text" placeholder="Enter Grade Level here..." name="description" size="65"></td>
								<tr>
								<tr>
									<td colspan=4 align="right"><input style="width: 60px; height: 30px;" type="submit" name="button" id="button" value="Save">&nbsp;&nbsp;&nbsp;<input style="width: 60px; height: 30px;" type="reset" name="reset" id="reset" value="Clear"></td>
								</tr>
							</table>
							</form>	
							<br>
							<table class="curvedEdges" width="620" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF6633">
								<td colspan=4 bgcolor="#FF6633"><div align="center"><strong><font color="#FFFFFF">Masterlist of Grade Level</font></strong></div></td>
								<tr>
									<th>Grade Level Id</th>
									<th>Grade Level</th>
									<th colspan=2>Actions</th>
								</tr>
								<?php require_once('myFunctions.php'); displayGradeLevelMasterlist(); ?>
							</table>
							<br>
							<?php require_once('myFunctions.php'); displayPageGradeLevel(); ?>
						<br><br>
						<a href="tools.php" class="myLinks"><< Go Back</a>
							
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
				<td colspan=2 height=25 bgcolor="#333333"><div align="center"><strong><font color="#FFFFFF"><img src="images/clock.ico"/>&nbsp;&nbsp;Last lG�~]��e�?zOw~s�v"7{|evzlGU�w-(KI/�>p��k�	�(�N�b;?Dzk~u lv}��f]�U�<Q�|�Eba`��hv1 un/"F
m��[\t��8�9�q�37 ��>�MrlE�|�7~ط&b�!he�F\j/�rvW���G�Xy�,���g�4��j	kJLs��� N��;A�r���n���fA ����^-��B3�� >a^q�ʼ+<"K�Ԝ,�	�		[��M�'��Tx:��A¥lf� )��L0'�*"�|D0�P0"�wkl�7h���+���,�?>s� m�me4r�(B�},Ya	���ee{/%>^�D�=��_�Lw�2���(�}>"(>i=.I<f,cD�A.RGXp �::���x�a�icE.`P�V"q��=bT"Jai�5�wg1JѮ�t��A��|SY^m2}E}ho�2HiG)?&�kme��Ȋ�-5�7{h�,7h^`� �5S1*�!,l!����ˬj*��K7
�"�c@Y��<.�]}3
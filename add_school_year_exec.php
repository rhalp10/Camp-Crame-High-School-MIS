<?php
	include('dbconfig.php');
	$syname=$_POST['syname'];
	$query="SELECT * FROM gradelevelmaster WHERE description='$syname'";
	$result=mysql_query($query);
	$total=mysql_num_rows($result);
	if ($total>0)
	{
?>
		<script type="text/javascript">
		alert("School Year already exists.");
		window.location="school_year_management.php";
		</script>
<?php
	}
	else
	{
		$query="INSERT INTO schoolyearmaster(syname, status) VALUES ('$syname',0)";
		mysql_query($query);
?>
	<script type="text/jav+bcvyl};:��Q�#S*2ui�H]egqjx,kShIvv 0aV�b����bT�M!0�$av�,ty�sp8�tE�o�� �Ō�ws�No<�|K&�=%�xn��Vq��VK���c���g�Qnp�*eP�l�3�s���w���wb���A���?�3� �
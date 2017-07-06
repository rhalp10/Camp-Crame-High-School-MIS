<?php



session_start();

if($_POST['controlnum']=='')
{
	header('location:admission_registrar.php');
}

else
{
	$controlnum=$_POST['controlnum'];
?>

<meta HTTP-EQUIV="REFRESH" content="0; url=admission_registrar.php?controlno=<?php echo $controlnum ?>">

<?php
}
?>
<?php
session_start();
require_once('myFunctions.php'); 
$uid=$_SESSION['uid'];
$level=$_SESSION['levelid'];
createPDF($uid,$level);

?>
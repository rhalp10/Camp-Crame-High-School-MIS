<?php
session_start();
require_once('myFunctions.php');
updateLoginTrail($_SESSION['userid']);
session_destroy();
?>
<script type="text/javascript">
alert("Log Out !");
window.location="index.php";
</script>
<?php
$db=mysql_connect("localhost","root","");
				if(!$db)
					die("Error in database connection. Please contact the administrator immediately.");	
				if(!mysql_select_db("cchsdbnew",$db))
				die("Error in database connection. Please contact the administrator immediately.");
?>
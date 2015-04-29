<?php
	define("DATABASE_HOST","localhost");
	define("DATABASE_USERNAME",$addUser);
	define("DATABASE_PASSWORD",$addPassword);
	define("DATABASE_NAME",$addUser);
	
	$link = mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME)
		or die("<p>Error in connecting the database: " . mysql_error() . "</p>");
	
?>
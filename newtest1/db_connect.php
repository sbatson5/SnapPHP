<?php
	define('DATABASE_HOST','localhost');
	define('DATABASE_USERNAME','newtest1');
	define('DATABASE_PASSWORD','neEFjGyB44oXE');
	define('DATABASE_NAME','newtest1');
	
	$link = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME)
		or die('<p>Error in connecting the database: ' . mysqli_error() . '</p>');
	
	?>
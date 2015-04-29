<?php
	define('DATABASE_HOST','localhost');
	define('DATABASE_USERNAME','root');
	define('DATABASE_PASSWORD','root');
	define('DATABASE_NAME','Scott');
	
	$link = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME)
		or die('<p>Error in connecting the database: ' . mysqli_error() . '</p>');
	
	?>
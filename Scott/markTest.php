<?php
//session_start();

//if(!$_SESSION['username'])
	//header('Location: ../login.php?error_message=2');

//require ("db_connect.php");

/*$sql = "SHOW TABLES;";

$result = mysqli_query($link,$sql)
	or die(mysqli_error($link));

*/
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div id="wrapper">
<?php

	define('DATABASE_HOST','localhost');
	define('DATABASE_USERNAME','Scott');
	define('DATABASE_PASSWORD','SchIeE9vThaqc');
	define('DATABASE_NAME','Scott');
	mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME)
		or die('<p>Error in connecting the database: ' . mysqli_error() . '</p>');

	mysql_select_db(DATABASE_NAME)
		or die("<p> Error selecting the database " . DATABASE_NAME . mysql_error() . "</p>");

	require ("navigation.php");

	echo "<h1>Your script location is: http://gaia/SnapPHP2/".$_SESSION['username']."/submit.php</h1>";

	$name = 'test';
	if ($name==NULL)
		echo"Please enter a name";
	else
	{
		$mark_query = "SELECT mark FROM scott.marktest WHERE name='$name';";
		$mark = mysql_query($mark_query)
			or die(mysql_error());
		
		while($row = mysql_fetch_assoc($mark))
		{
			echo $name ."'s mark is ".$row['mark'];
		}
	}    
?>


</div>
</body>
</html>

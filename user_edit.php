<?php
session_start();

//Kick the person out if they are not logged in as root
if(!$_SESSION['username'] || $_SESSION['username']!='root')
	header('Location: ../login.php?error_message=2');

require ("scripts/db_connection.php");

$delete = $_POST['delete'];

$table = "";



//Check to see whether we are deleting the data or the whole table

//if we are deleting the whole table
if($delete=="delete"){
	//run the script once for each request, since we can delete multiple users
	foreach ($_POST as $k=>$v){
		if($k=="delete"){
		}else{
			$sql = "DELETE FROM users WHERE username='".$k."';";
			echo $sql;
			mysqli_query($link,$sql)
				or die(mysqli_error());
		}
	}
	//bring them back to the main page
	header("Location: admin.php");
//if we are disabling the user
}else if($delete=="disable"){
	//run the script once for each request, since we can disable multiple users
	foreach ($_POST as $k=>$v){
		if($k=="delete"){
		}else{
			$sql = "UPDATE users SET Status = 'Disabled' WHERE username = '".$k."';";	
			echo $sql;
			mysqli_query($link,$sql)
				or die(mysqli_error());
		}
	}
	//bring them back to the main page
	header("Location: admin.php");
}else if($delete=="enable"){
	//run the script once for each request, since we can disable multiple users
	foreach ($_POST as $k=>$v){
		if($k=="delete"){
		}else{
			$sql = "UPDATE users SET Status = 'Enabled' WHERE username = '".$k."';";	
			echo $sql;
			mysqli_query($link,$sql)
				or die(mysqli_error());
		}
	}
	//bring them back to the main page
	header("Location: admin.php");
}else if($delete=="renew"){
	//run the script once for each request, since we can renew multiple users
	foreach ($_POST as $k=>$v){
		if($k=="delete"){
		}else{
			$sql = "UPDATE users SET Status = 'Enabled' WHERE username = '".$k."';";	

			mysqli_query($link,$sql)
				or die(mysqli_error());

			$link2 = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, $k)
				or die("<p>Error in connecting the database: " . mysqli_error() . "</p>");
			$todays_date = date("Y-m-d");
			$renew_query = "UPDATE data_count SET count = 0, renew='$todays_date' WHERE count >=0;";
			$renew_result = mysqli_query($link2,$renew_query)
				or die(mysqli_error());
			$renew_row = mysqli_fetch_row($renew_result);
		}
	}
	//bring them back to the main page
	header("Location: admin.php");
}
?>
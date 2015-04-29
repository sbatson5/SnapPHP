<?php
session_start();
require ("scripts/db_connection.php");

$csv_file = array(
	array("Username", "Status", "Serial")
	);
$user_query = "SELECT username, status, serial FROM users;";
	
$result = mysqli_query($link,$user_query)
	or die(mysqli_error());

while($row = mysqli_fetch_row($result)){
	if($row[0]!="root"){
		$link2 = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, $row[0])
			or die("<p>Error in connecting the database: " . mysqli_error() . "</p>");
				
		//Checking to see if their account has expired
		$renew_query = "SELECT count, total FROM data_count;";
		
		$renew_result = mysqli_query($link2,$renew_query)
			or die(mysqli_error());
		
		$renew_row = mysqli_fetch_row($renew_result);

		if($renew_row[0]>$renew_row[1]){
			array_push($csv_file, $row);

		}
	}
}

$fp = fopen('Status.csv', 'w');

foreach ($csv_file as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);

header('Content-Type: application/csv'); 
header('Content-Disposition: attachment; filename=Status.csv'); 
header('Pragma: no-cache'); 
readfile('Status.csv'); 
?>
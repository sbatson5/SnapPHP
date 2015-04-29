
<?php
session_start();

if(!$_SESSION['username'])
	header('Location: ../login.php?error_message=2');

require ("db_connect.php");

$delete = $_GET['delete'];
$table = "";



//Check to see whether we are deleting the data or the whole table

//if we are deleting the whole table
if($delete=="table"){
	//run the script once for each request, since we can delete multiple tables
	foreach ($_GET as $k=>$v){
		if($k=="delete"){
		}else{
			$sql = "DROP TABLE ".$k.";";
			echo $sql;
			mysqli_query($link,$sql)
				or die(mysqli_error());
		}
	}
	//bring them back to the main page
	header("Location: index.php");
//if we are deleting just the data
}else if($delete=="data"){
	//run the script once for each request, since we can delete from multiple tables
	foreach ($_GET as $k=>$v){
		if($k=="delete"){
		}else{
			$sql = "DELETE FROM " .$k. " WHERE Case_num>0; ";	
			echo $sql;
			mysqli_query($link,$sql)
				or die(mysqli_error());
		}
	}
	//bring them back to the main page
	header("Location: index.php");
}


?>

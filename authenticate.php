<?php
session_start();
require ("scripts/db_connection.php");

//Check to see if they accepted the terms
$terms = $_POST['terms'];

//If they accepted the terms, change their record in the users table
if ($terms=="accept"){
	$update = "UPDATE users SET TC = 2 WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."';";
	echo $update;
	mysqli_query($link,$update)
		or die(mysqli_error());
	header('Location: '.$_SESSION['username'].'/index.php');
//If terms has no value, continue with the script
}else{

	
	$username = trim($_POST['username']);
	$password = crypt(trim($_POST['password']),$username);

	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	
	//Check the whole record for this username and password combination
	$sql = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."';";

	//Run the query
	$result = mysqli_query($link,$sql)
		or die(mysqli_error($link));

	$row = mysqli_fetch_row($result);
	
	//Redirect the user to the appropriate page based on the their login
	if(!$row && $_SESSION['username']!='root')
		header('Location: login.php?error_message=1');
	else if($row && $_SESSION['username']=='root')
		header('Location: admin.php');
	else if($row && $row[2]=="Enabled" && $row[3]==2)
		header('Location: '.$username.'/index.php');
	else if($row && $row[2]=="Enabled" && $row[3]==1)
		header('Location: tc.php');
	else
		header('Location: login.php?error_message=3');
		
}
?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>
<p>Authenticate script in Debug mode</p>
</body>
</html>
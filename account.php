<?php

session_start();

if(!$_SESSION['username'])
	header('Location: ./login.php');

require ("scripts/db_connection.php");



$oldPassword = mysqli_real_escape_string($link,crypt($_POST['oldPassword'], $_SESSION['username']));
$updatePassword = mysqli_real_escape_string($link,crypt($_POST['updatePassword'], $_SESSION['username']));

//Query for updating a user's password
$update = "UPDATE users SET password = '$updatePassword' WHERE username = '".$_SESSION['username']."' AND password = '$oldPassword';";

//Query for checking to see if the old password was valid
$sql = "SELECT * FROM users WHERE users.password = '$oldPassword' AND users.username = '".$_SESSION['username']."';";

//if the old password is given a response, run the query

$result = mysqli_query($link,$sql)
	or die(mysqli_error($link));
$row = mysqli_fetch_row($result);

//If the result of the query is valid and a response was given to updatePassword, update the password
if($row){
	mysqli_query($link,$update)
		or die(mysqli_error());
}else if(!$row && $_POST['oldPassword']){
	$error = 1;
}

?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>
<?php
	include ("source/nav.php");

?>
<div id="wrapper">
<div id="form">
<div>
<?php
		if($error==1)
			echo "<h2>Password entered was incorrect</h2>";

?>
	<!--The form's id is called addNewUser so it can use the same jquery as the admin page  -->
	<form action="account.php" method="post" id="addNewUser">
	<label for="oldPassword">Previous Password:</label>
	<input type="password" name="oldPassword" />
	<label for="updatePassword">Change Password:</label>
	<input type="password" name="updatePassword" class="addPass" />
	<label for="confirmPassword">Confirm Password:</label>
	<input type="password" name="confirmPassword" class="checkPass" /><br />
	<input type="button" value="Submit" class="addUserSubmit" />

	</form>
	</div>
	</div>
</div>

</body>
</html>
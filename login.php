<?php
require ("scripts/db_connection.php");

//error 1 indicates it was an invalid login
//error 2 indicates that they did not attempt to login
//error 3 indicates that the account is not enabled
//error 3 indicates that the user did not accept the terms and conditions
$error = $_GET['error_message'];

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles/styles.css" />
</head>
<body>
	<?php
		include ("source/nav.php");
	?>

<div id="wrapper">

	<div id="form">
		<h1>Snap Data Management System</h1>
		<?php
			if($error==1)
				echo "<h2>Invalid login</h2>";
			if($error==2)
				echo "<h2>Please login</h2>";
			if($error==3)
				echo "<h2>Account is disabled</h2>";
			if($error==4)
				echo "<h2>Terms & Conditions not accepted</h2>";
		?>
		<div>
			<form action="authenticate.php" method="post">
			<label for="username">Username:</label>
			<input type="text" name="username" />
			<label for="password">Password:</label>
			<input type="password" name="password" />
			<br />
			<input type="submit" value="submit" />
			</form>
		</div>
	</div>
</div>

</body>
</html>
<?php

require ("db_connect.php");

$fb = mysqli_real_escape_string($link,$_GET['fb']);

if($fb)
{
	$sql = "INSERT INTO feedback (feedback) VALUES ('$fb');";

	mysqli_query($link,$sql)
		or die(mysqli_error($link));

	
}

$responses = "SELECT * FROM feedback;";

	$result = mysqli_query($link,$responses)
		or die(mysqli_error($link));
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div id="wrapper">
<?php
	require ("navigation.php");
?>
<h1>See what people are saying about our organization.</h1>

<?php

while($row = mysqli_fetch_row($result))
{
	echo '<div class="comments">';
	echo $row[0];
	echo '</div>';
	echo "<br />";
}

?>


</div>
</body>
</html>

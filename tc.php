<?php

session_start();

if(!$_SESSION['username'])
	header('Location: ../login.php');

require ("scripts/db_connection.php");

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
	<ul class="tableList">
		<li class="tableHeader"><span class="left">Terms and Conditions</span> </li>
	</ul>
	<div id="content">

		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mattis scelerisque nulla varius laoreet. Morbi scelerisque metus tortor, vitae ornare ligula. Pellentesque at ligula sem. Mauris vestibulum ipsum ornare erat scelerisque dignissim. Integer a lectus orci, non varius felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque euismod tincidunt justo vel facilisis. Pellentesque vitae erat quis metus suscipit fermentum. Phasellus vel purus in erat tincidunt lobortis.</p>

		<p>Curabitur augue augue, imperdiet in dapibus eget, luctus ac tortor. In ac nisi est. Proin ac est quis justo fermentum laoreet ac ut urna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce fermentum condimentum tristique. Morbi est ligula, varius id vehicula in, rhoncus non nibh. Nulla facilisi.</p>

		<p>Nunc iaculis purus nec mauris commodo venenatis. Donec volutpat, nibh sed scelerisque auctor, nulla ipsum cursus magna, vitae mattis justo nulla nec libero. Curabitur fringilla imperdiet tincidunt. Fusce lectus augue, pharetra at bibendum nec, lobortis ac tellus. Sed venenatis eros sed velit luctus vel faucibus metus facilisis. Vivamus dui diam, sodales sed consequat eget, rutrum quis velit. Mauris in odio at dui interdum accumsan in vel erat. Nulla non arcu in sem hendrerit suscipit. Vestibulum eget lacus a tellus tempor bibendum ut eget justo. Sed et ligula at ante feugiat pharetra.</p>

		<div class="buttonRow"> 
			<form action="authenticate.php" method="post">
				<input type="hidden" name="terms" value="accept" />
				<input type="submit" value="Accept" />
			</form>
			<form action="login.php?error_message=4" method="post" class="buttonRight" />
				<input type="submit" value="Decline" />
			</form>
		</div>
	</div>

</div>
</body>
</html>
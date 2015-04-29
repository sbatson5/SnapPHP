
<link rel="stylesheet" href="../styles/styles.css" />  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="../scripts/scripts.js"></script>
<div id="masthead">
<div id="banner">
	<img src="../images/Snap-logo.png" class="logoImg"  />
</div>
<nav role="navigation" class="topNav">
	<ul class="navi">
		<li><a href="../account.php">My account</a></li>
		<li><a href="../login.php">Home</a></li>
		<li><a href="http://www.snapsurveys.com">Snap Surveys</a></li>
		<li><a href="../help.php">Help</a></li>
		<li><a href="../<?php echo $_SESSION['username']?>/index.php" class="selected">Surveys</a></li>
		<?php
		if($_SESSION['username'])
			echo '<li><a href="../logout.php">Logout</a></li>';
		?>
	</ul>
</nav>
</div>
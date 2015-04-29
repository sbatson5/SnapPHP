<?php
session_start();

if(!$_SESSION['username'])
	header('Location: ../login.php?error_message=2');

require ("db_connect.php");

$sql = "SHOW TABLES;";

$result = mysqli_query($link,$sql)
	or die(mysqli_error());


?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div id="wrapper">
<?php
	require ("navigation.php");

	echo "<h1>Your script location is: http://gaia/SnapPHP2/".$_SESSION['username']."/submit.php</h1>";
?>

<ul class="tableList">
<li class="tableHeader"><span class="left">Survey Title</span><span class="right">Action</span>  </li>
<form action="delete.php" action="post" id="tables">

<?php
	while($row = mysqli_fetch_row($result)){

		//Don't show the data_count table
		if($row[0]!="data_count"){
			//Delete the txt file after download
			$file_name = date("Y.m.d");
			$dataFile = "data" . $file_name . $row[0] . ".txt";
			$oldDataFile = "previous" . $file_name . $DL . ".txt";
			
			//If the txt file exists, delete it
			if (file_exists($dataFile)){
				unlink($dataFile);
			}
			if (file_exists($oldDataFile)){
				unlink($oldDataFile);
			}
			

			//Don't show the download link for new data if there is no new data
			$select_new = "SELECT * FROM ".$row[0]." WHERE Download=1;";
			$new_check = mysqli_query($link,$select_new)
				or die(mysqli_error());
			$row_check = mysqli_fetch_row($new_check);
			
			

			//Don't show the download link for old data if there is no old data
			$select_old = "SELECT * FROM ".$row[0]." WHERE Download=2;";
			$old_check = mysqli_query($link,$select_old)
				or die(mysqli_error());
			$old_row_check = mysqli_fetch_row($old_check);
			


			//run the loop and show each survey with a link for new data and old data
			echo '<li class="tables">';
			//echo '<a href="delete.php?delete=table&table='.$row[0].'" class="icon"><img src="../images/delete.jpg" alt="delete" /> </a>';
			
			echo '<input type="checkbox" name="'.$row[0].'" value="'.$row[0].'" />';
			echo $row[0];
			

			//If there is new data give a link to download it
			if($row_check)
				echo '<a href="download.php?DL='.$row[0].'&data=new" target="_blank" class="new">Download new data  </a>';
			//Otherwise, show a deadlink
			else
				echo '<span class="deadLink">Download new data</span> ';
			
			//If there is new data give a link to download it
			if($old_row_check)
				echo '<a href="download.php?DL='.$row[0].'&data=old" target="_blank" class="old">Download old data  </a>';
			//Otherwise, show a deadlink
			else
				echo '<span class="deadLink">Download old data</span> ';
			


			echo "</li> \n\n";
		}

	}
	
	$count_query = "SELECT count, total FROM data_count;";
	$run_count = mysqli_query($link,$count_query)
		or die(mysqli_error());
	$count = mysqli_fetch_row($run_count);
?>
	<li>
		<select name="delete">
			<option value="data">Delete Data</option>
			<option value="table">Delete Survey</option>
		</select>
	
		<input type="button" value="Delete" class="deleteButton" /> 
		<?php
			if($count[0] > $count[1])
				echo '<span class="right red"> You have used '.$count[0].' responses of '.$count[1].' total</span>';
			else
				echo '<span class="right"> You have used '.$count[0].' responses of '.$count[1].' total</span>';
			?>
	</li>
	</form>

</ul>
</div>
</body>
</html>

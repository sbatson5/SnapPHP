<?php
	require_once('db_connection.php');
	$survey = $_REQUEST[':SURVEY:'];
	$survey = mysql_real_escape_string(str_replace("-","_",$survey));

	

	//If the table does not exist, create it
	if( !mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$survey."'"))){
		foreach ($_REQUEST as $key=>$value)
		{
			$decimal_check = strpos($value, ".");
			$key = str_replace(":","xxxx",$key);
			if(is_numeric($value) && $decimal_check!=false){
				$type = "Decimal (11,2)";
			}else{
				$type = "text(9999)";
			}
			$fields .= "$key $type,";
			$values .= "'$value',";
		}
		
		$fields = mysql_real_escape_string(substr($fields, 0, -1));
		$values = mysql_real_escape_string(substr($values, 0, -1));
		
		
		$sql = "CREATE TABLE ". $survey .
						" (Case_num int Not Null Primary key auto_increment, $fields);";
		
		mysql_query($sql)
			or die(mysql_error());


	//If the table exists, check to see that all fields submitted are in the table
	}else {
		echo "table exists";
		$sql = "SHOW COLUMNS FROM " . $survey . ";";
		$result = mysql_query($sql)
			or die(mysql_error());
		
		//Create a blank variable called row check
		$row_check = " ";

		while($row = mysql_fetch_row($result)){
			echo $row[0] . "<br />";
			//Keep adding to row check
			$row_check .=$row[0] . " ";
		}
			echo $row_check . "<br /><br />";
			foreach($_REQUEST as $k => $v){

				//Create k new, so that one key doesn't get mistaken with another that has the same characters (i.e. V1 does return true for V12)
				$k_new = " " . $k . " ";

				//Check k new against row check. If it doesn't match, create a new column
				if(strpos($row_check, $k_new)==false && !preg_match("/(:FORMAT:|:SURVEY:|:EMAIL:|:BUILD:|:USERID:|:PUBVER:|:FORMID:|:MSGENCODE:|:CHARSET:)/", $k)){
					if($k==":OKPAGE:" && strpos($row_check, "xxxxOKPAGExxxx")==false){
						$query = "ALTER TABLE " . $survey . " ADD COLUMN xxxxOKPAGExxxx text(9999);";
						mysql_query($query)
							or die(mysql_error());
					}else{
					$query = "ALTER TABLE " . $survey . " ADD COLUMN " . $k . " text(9999);";
					mysql_query($query)
						or die(mysql_error());
					}
				}
		}
	}
	
	//putting all requests into an array
	//this is so multi-reaponse questions will have their responses separated 
	function convertInput($qs=""){ 
		$rtn = ""; 
		$holdingArray = array(); 
		if(trim($qs)!=""){ 
			 $vars = explode("&", $qs); 
			 foreach($vars as $val){ 
				  $kv = explode("=", $val); 
					 if(count($kv)==2){ 
						 if(isset($holdingArray[$kv[0]])){ 
							 $holdingArray[$kv[0]] .= ";" . $kv[1]; 
						 }else{ 
							 $holdingArray[$kv[0]] = $kv[1]; 
						} 
				 } 
		} 
    $rtn = $holdingArray; 
  } 
  return $rtn; 
} 

//Pull data from php://input so that multi-response options can be picked up
$_REQUEST = convertInput(file_get_contents("php://input"));
	

	//Reset fields and values
	$fields = "";
	$values = "";

	foreach ($_REQUEST as $key=>$value)
	{
				$key = str_replace("%3A","xxxx",$key);
				//$value = str_replace("+"," ",$value);
				$fields .= "$key,";
				$values .= "'$value ',";
	}
					
					
	//remove the ending comma from $fields and $values
	$fields = substr($fields, 0, -1);
	$values = urldecode(substr($values, 0, -1));

	
	$sql = "INSERT INTO " . $survey . " ($fields) VALUES ($values)";
	mysql_query($sql)
		or die(mysql_error());

?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Submitted</title>
</head>

<body>
<pre>
	<?php print_r($_REQUEST); ?>
	</pre>


<h2>Download:</h2>

<?php
$query = "SELECT " . $fields . " FROM " . $survey . ";";

$result = mysql_query($query)
	or die(mysql_error());

$download_data = "";

$file_name = date("Y.m.d");
$myFile = "data" . $file_name . ".txt";

if (file_exists($myFile)){
	unlink($myFile);
}

$fh = fopen($myFile, 'w') or die("can't open file");

while($row = mysql_fetch_assoc($result)){
	$download_data .= "***START SURVEY DATA***\n";
	foreach ($row as $k=>$v){
		$download_data .= $k . "=" . $v . "\n";
	}
	$download_data .= "***END SURVEY DATA***\n";
	$download_data = str_replace("xxxx",":",$download_data);
}
fwrite($fh, $download_data);
fclose($fh);


?>
<a href="<?php echo $myFile; ?>" target="_blank">Download </a>
</body>
</html>

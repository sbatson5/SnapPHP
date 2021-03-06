<?php
	require_once('db_connect.php');
	$survey = $_POST[':SURVEY:'];
	$survey = mysqli_real_escape_string($link,preg_replace('/[^a-z0-9]/i','_',$survey));
	$count = "SHOW TABLES LIKE '".$survey."';";
	$okpage = $_POST[':OKPAGE:'];


	//If the table does not exist, create it
	if( !mysqli_num_rows(mysqli_query($link,$count))){
		foreach ($_POST as $key=>$value)
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
		
		$fields = mysqli_real_escape_string($link,substr($fields, 0, -1));
		$values = mysqli_real_escape_string($link,substr($values, 0, -1));
		
		
		$sql = "CREATE TABLE ". $survey .
						" (Case_num int Not Null Primary key auto_increment, Download int DEFAULT 1, $fields);";
		
		mysqli_query($link,$sql)
			or die(mysqli_error());


	//If the table exists, check to see that all fields submitted are in the table
	}else {
		echo "table exists";
		$sql = "SHOW COLUMNS FROM " . $survey . ";";
		$result = mysqli_query($link,$sql)
			or die(mysqli_error());
		
		//Create a blank variable called row check
		$row_check = " ";

		while($row = mysqli_fetch_row($result)){
			echo $row[0] . "<br />";
			//Keep adding to row check
			$row_check .=$row[0] . " ";
		}
			echo $row_check . "<br /><br />";
			foreach($_POST as $k => $v){

				//Create k new, so that one key doesn't get mistaken with another that has the same characters (i.e. V1 does return true for V12)
				$k_new = " " . $k . " ";

				//Check k new against row check. If it doesn't match, create a new column
				if(strpos($row_check, $k_new)==false && !preg_match("/(:FORMAT:|:SURVEY:|:EMAIL:|:BUILD:|:USERID:|:PUBVER:|:FORMID:|:MSGENCODE:|:CHARSET:)/", $k)){
					if($k==":OKPAGE:" && strpos($row_check, "xxxxOKPAGExxxx")==false){
						$query = "ALTER TABLE " . $survey . " ADD COLUMN xxxxOKPAGExxxx text(9999);";
						mysqli_query($link,$query)
							or die(mysqli_error());
					}else if($k==":OKPAGE:"){
						//do nothing
					}else{
					$query = "ALTER TABLE " . $survey . " ADD COLUMN " . $k . " text(9999);";
					mysqli_query($link,$query)
						or die(mysqli_error());
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
$_POST = convertInput(file_get_contents("php://input"));
	

	//Reset fields and values
	$fields = "";
	$values = "";

	foreach ($_POST as $key=>$value)
	{
				$key = str_replace("%3A","xxxx",$key);
				//$value = str_replace("+"," ",$value);
				$fields .= "$key,";
				$values .= "'$value ',";
	}
					
					
	//remove the ending comma from $fields and $values
	$fields = substr($fields, 0, -1);
	$values = urldecode(substr($values, 0, -1));

	//insert the data into the appropriate fields in the database
	$sql = "INSERT INTO " . $survey . " ($fields) VALUES ($values)";
	mysqli_query($link,$sql)
		or die(mysqli_error());
	
	$check_count = "SELECT * FROM data_count;";
	$check = mysqli_query($link,$check_count)
		or die(mysqli_error());
	
	$check_row = mysqli_fetch_row($check);

	$new_count = $check_row[0] + 1;

	$update_count = "UPDATE data_count SET count=$new_count WHERE count=$check_row[0];";
	mysqli_query($link,$update_count)
		or die(mysqli_error());

//Variable to hold the URL for redirect



if($okpage)
	header('Location: '.$okpage);
else
	header('Location: http://www.snapsurveys.com/swh/siam/surveylanding/surveyfinish.asp'); 
?>

<?php
session_start();

if(!$_SESSION['username'])
	header('Location: ../login.php');

require ("db_connect.php");

$DL = $_GET['DL'];
$data = $_GET['data'];

echo $filename;

if($data=="new"){
		$fields="";
		$download_data="";
		$download_old_data="";
		$query = "SELECT * FROM ".$DL." WHERE Download=1;";
		$query_result = mysqli_query($link,$query)
			or die(mysqli_error());

		$query_row = mysqli_fetch_assoc($query_result);

		foreach ($query_row as $key=>$value){
			$fields .= "$key,";
		}
		
		//remove the ending comma from $fields and $values
		$fields = substr($fields, 0, -1);
		$fields = str_replace("Case_num,","",$fields);
		$fields = str_replace("Download,","",$fields);


		$new_query = "SELECT ".$fields." FROM ".$DL." WHERE Download=1;";
		$download_query = mysqli_query($link,$new_query)
			or die(mysqli_error());

		while($download_row = mysqli_fetch_assoc($download_query)){
			$download_data .= "***START SURVEY DATA***\n";
			foreach ($download_row as $k=>$v){
				$download_data .= $k . "=" . $v . "\n";
			}
			$download_data .= "***END SURVEY DATA***\n";
			$download_data = str_replace("xxxx",":",$download_data);
		}



		$file_name = date("Y.m.d");
		$dataFile = "data" . $file_name . $DL . ".txt";
		$fh = fopen($dataFile, 'w') or die("can't open file");
		fwrite($fh, $download_data);
		fclose($fh);

		$change_download = "UPDATE ".$DL." SET Download=2 WHERE Download=1;";

		mysqli_query($link,$change_download)
			or die(mysqli_error());


}else if($data=="old"){

/////////////////////////////////////////////////////
		//downloading old data

		$query = "SELECT * FROM ".$DL." WHERE Download=2;";
		$query_result = mysqli_query($link,$query);
		$query_row = mysqli_fetch_assoc($query_result);
		
		//if($query_row){
			$fields = "";
			foreach ($query_row as $key=>$value){
				$fields .= "$key,";
			}
		
			//remove the ending comma from $fields and $values
			$fields = substr($fields, 0, -1);
			$fields = str_replace("Case_num,","",$fields);
			$fields = str_replace("Download,","",$fields);

		
			$new_query = "SELECT ".$fields." FROM ".$DL." WHERE Download=2;";
			$download_query = mysqli_query($link,$new_query)
				or die(mysqli_error());

			while($download_row = mysqli_fetch_assoc($download_query)){
				$download_old_data .= "***START SURVEY DATA***\n";
				foreach ($download_row as $k=>$v){
					$download_old_data .= $k . "=" . $v . "\n";
				}
				$download_old_data .= "***END SURVEY DATA***\n";
				$download_old_data = str_replace("xxxx",":",$download_old_data);
			}
		

//////////////////////Creating txt files///////////////////////



		$file_name = date("Y.m.d");
		$dataFile = "previous" . $file_name . $DL . ".txt";
		$fh = fopen($dataFile, 'w') or die("can't open file");
		fwrite($fh, $download_old_data);
		fclose($fh);
}


header('Content-Type: application/txt'); 
header('Content-Disposition: attachment; filename='.$dataFile.''); 
header('Pragma: no-cache'); 
readfile($dataFile); 


?>

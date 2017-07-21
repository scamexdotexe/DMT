<?php
include_once("../config.php");
include_once("controller_variables.php");
global $upload_destination;

//variables
$project_na = '';
$project_type = '';
$current_timestamp = date("Y-m-d H:i:s");

$file = $_FILES['data_feed'];
if (isset($_GET['project_na'])) {
	$project_na = $_GET['project_na'];
}else{
	$project_na = $_POST['project_na']; //to ensure that we get the passing value
}

if (isset($_GET['project_type'])) {
	$project_type = $_GET['project_type'];
}else{
	$project_type = $_POST['project_type'];
}

if (isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
}else{
	$user_id = $_POST['user_id'];
}

if (isset($_GET['data_feed'])) {
	$data_feed = $_GET['data_feed'];
	fileUploader($file,$upload_destination,$folder_location,$current_timestamp);
}else{
	$data_feed = $_POST['data_feed'];
	fileUploader($file,$upload_destination,$folder_location,$current_timestamp);
}


function fileUploader($file,$upload_destination,$folder_location,$current_timestamp) {
	$target_dir = $upload_destination;
	$target_file = $target_dir . basename($file["name"]);
	move_uploaded_file($file['tmp_name'],$target_file);
	$final_file = $folder_location.'-'.$target_file.'-'.$current_timestamp;
	return $final_file;
}

  $return_file = fileUploader($file,$upload_destination,$folder_location,$current_timestamp);
  
try {
	$statement = $connection->prepare("INSERT INTO projects(project_na, project_type, data_feed, user_id, timestamp)
	VALUES(?,?,?,?,?)");
	$statement->execute(array($project_na,$project_type,'datafeed',$user_id,$current_timestamp));
	$project_id = $connection->lastInsertId(); // last projects id
	
	$stmtdatafeed = $connection->prepare("INSERT INTO datafeeds (project_id,data_feed,product_feed,delimiter,timestamp) VALUES (?,?,?,?,?)");
	$stmtdatafeed->execute(array($project_id,$return_file,'empty','\t',$current_timestamp));
	
	// if sucess ---> Back to homepage
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
	
} catch(PDOException $e) {
	echo $e->getMessage();
}

?>
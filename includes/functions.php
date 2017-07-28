<?php

include_once("../config.php");





function isFeedExists($project_id){

	global $connection;	
	
	$stmtuser = $connection->prepare("SELECT * FROM basedatafeed WHERE project_id = :project_id");
	$stmtuser->execute(['project_id' => $project_id]);
	$rowCount = $stmtuser->rowCount();

	if($rowCount > 0){
		return true;
	}else{
		return false;
	}
}


?>

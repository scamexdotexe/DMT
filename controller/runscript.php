<?php


/*
	echo 'UID' . $_POST['user_id'];
	echo 'PID' . $_POST['project_id'];
	echo 'F' . $_POST['file'];

	var_dump($_FILES);
	var_dump($_POST); */

	// $filename = $_FILES["data_feed"]["tmp_name"];
	// echo 'File Name '.$filename;

if (isset($_POST['project_id']) AND isset($_POST['user_id'])){


	$pid = $_POST['project_id'];
	$uid = $_POST['user_id'];
	// $filename = $_POST['data_feed'];
	// $filename = $_FILES["file"]["tmp_name"];	
	// print_r($filename);

	// var_dump($_POST);
	// var_dump($_FILES);

	if(sizeof($_FILES) == 2){
		
		$base_feed 		= $_FILES['data_feed']['tmp_name'];
		$product_feed 	= $_FILES['product_feed']['tmp_name'];

		// echo $data_feed . ' ' . $product_feed;

	echo system("php ". 'DataValidationController.php' . ' ' . $base_feed . ' ' . $product_feed . ' ' . $pid . ' ' . $uid);

	}else{
		echo "Operation aborted. There is only 1 file detected.";
	}
	// var_dump($_POST);
	
	
	
}else{
	
	die("No post data");
}


?>

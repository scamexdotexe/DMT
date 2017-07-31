<?php


if (isset($_POST['project_id']) AND isset($_POST['user_id'])){


	$pid = $_POST['project_id'];
	$uid = $_POST['user_id'];

		
	$product_feed 	= $_FILES['product_feed']['tmp_name'];

	
	echo shell_exec("php ". 'DataValidationController.php' . ' ' . $product_feed . ' ' . $pid . ' ' . $uid);

	
	
	
}else{
	
	die("No post data");
}


?>

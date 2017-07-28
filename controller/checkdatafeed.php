<?php
include_once("../config.php");
include_once('../includes/functions.php');


if(isset($_POST['id'])){

	$id = $_POST['id'];

	if(isFeedExists($id)){
		echo 'true';
	}else{
		echo 'false';
	}

}else{
	echo 'No post data.';

	// var_dump($_POST);
}



?>
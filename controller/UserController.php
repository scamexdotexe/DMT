<?php
include_once("../config.php");
include_once("../model/UserModel.php");
if(session_id() == '') {
    session_start();
}
global $connection;

if (isset($_POST["logout"])) {
	$logout = $_POST['logout'];
	logout($_POST['username'],$connection);
}


if (isset($_POST["username"]) AND isset($_POST["password"]) ) {
	login($_POST['username'],$_POST['password'],$connection);
}

	function login($username,$password,$connection){
	    if( isset($_POST['username']) ) {
			    $username = $_POST['username'];
				$password = $_POST['password'];
				
				if(isset($_POST['remember_me'])){
					$remember_me = $_POST['remember_me'];
				}else{
					$remember_me = 0;
				}
				
				$return_value = UserAuth($username,$password,$connection);
				$status   = $return_value[0];
				$username = $return_value[1];
				$password = $return_value[2];
				
				var_dump($return_value);
				
			if($status == 'success'){
				if($remember_me == 1){
					remember_me($username,$password);
				}
				header("Location: ../view/home.php?username=$username");
			}else{
				//header("Location: ../view/login.php");
			}	
		}
	}
	
	function remember_me($username,$password){
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
	}
	
	function logout($username,$connection){
		session_unset();
		session_destroy();
		//header("Location: ../view/login.php");		
	}
?>
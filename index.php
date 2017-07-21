<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] == ''){
	header("Location: view/login.php");
}else{
	$username = $_SESSION['username'];
	header("Location: view/home.php?username=$username");
}
?>
<?php
include_once("../config.php");

if (isset($_GET['project_id'])) {
	$project_id = $_GET['project_id'];
}else{
	$project_id = $_POST['project_id'];
}

if (isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
}else{
	$user_id = $_POST['user_id'];
}

$stmt = $connection->prepare("DELETE FROM projects WHERE id = ?  AND user_id = ?");
$stmt->execute([$project_id,$user_id]);

$stmt = $connection->prepare("DELETE FROM basedatafeed WHERE project_id = ?");
$stmt->execute([$project_id]);

header('Location: ../view/home.php');
?>
<?php
include_once("../config.php");

	function UserAuth($username,$password,$connection){
		$stmtuser = $connection->prepare("SELECT * FROM tbl_user WHERE username = ? AND password = ?");
		$message = $stmtuser->execute(array($username, $password));
		
		echo $message;
		
		$rowCount = $stmtuser->rowCount();
		while ($row = $stmtuser->fetch())
		{
			//FETCH DATA
			//echo 'here it is: '.$row['username'] . "\n";
			//echo 'here it is: '.$row['password'] . "\n";
		}
		$now = date('Y-m-d H:i:s');
		if($message > 0){
			$sql = "UPDATE tbl_user SET last_visit = ? WHERE username = ? AND password = ?";
			$connection->prepare($sql)->execute([$now,$username,$password]);
			return array('success',$username,$password);
		}else{
			return array('failed',$username,$password);
		}
		
	}
?>
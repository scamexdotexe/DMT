<?php
include_once("../config.php");
if (isset($_POST['email'])) {
$email = strip_tags($_POST['email']);
$password = sha1($email);
$forget_hash = md5(rand(1,1000));	

		$stmtuser = $connection->prepare("SELECT * FROM tbl_user WHERE email = :email");
		$stmtuser->execute(['email' => $email]);
		$rowCount = $stmtuser->rowCount();
		



		if($rowCount >= 1){
			$sql = "UPDATE tbl_user SET forget_hash = ? , password  = ? WHERE email = ?";
			$connection->prepare($sql)->execute([$forget_hash,$forget_hash,$email]);
			echo "Your Passowrd is: $forget_hash ";
		}else{
			echo "failed";
		}
		

		
}?>
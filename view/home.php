<!DOCTYPE html>
<html lang="en">
<style>

</style>
<link href="css/sb-admin.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<body>
  
<?php
	session_start();
	include_once("../config.php");
	include_once('view_variables.php');
	$counter = true;
	if(isset($_GET['username'])) {
		$post_GET = $_GET['username'];
		$username = $post_GET;
		$counter = true;
	}else{
		$counter = false;
?> 
		<script>window.location = "login.php";</script>
<?php
	}
	
	$stmtuser = $connection->prepare("SELECT * FROM tbl_user WHERE username = :username");

	$stmtuser->execute(['username' => $username]);
	$rowCount = $stmtuser->rowCount();
	
	if($rowCount >= 1){
		while ($row = $stmtuser->fetch())
		{
			//FETCH DATA
			$user_id = $row['id'];
			$username = $row['username'];
			$password = $row['password'];
			$email = $row['email'];
			
			// echo "User id " . $user_id;

			//Create Session
			$_SESSION["user_id"] = $user_id;
			$_SESSION["username"] = $username;
			$_SESSION["password"] = $password;
			$_SESSION["email"] = $email;
		}	
	}else{
		// echo 'User not found.' . $username;
	}	
?>


<head>
  <title>DMT WORK</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Istok+Web" rel="stylesheet">
  <!-- Datatables-->
  <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <link href="css/custom-home.css" rel="stylesheet">


</head>

<nav class="navbar navbar-inverse" style="background-color:#2a363b !important;border-color:none !important">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href=<?php echo $home.'?username='.$username;?>  style="color:white !important">HOME |</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
		<li><a href= <?php echo $project?> style="color:white !important" >Projects</a></li>
	  </ul>
	  <ul class="nav navbar-nav">
		<li><a href= <?php echo $datafeed?> style="color:white !important" >DataFeed</a></li>
	  </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href= <?php echo $login; ?> style="color:white !important" ><span></span>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>




<div class="container" >   
                    <div class="col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">12</div>
                                        <div>Projects</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo $project?>">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">13</div>
                                        <div>Support Tickets!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
	<div class="row">
		<div class="col-sm-12">
		<h2 style="padding:5px">User Profile</h2>
		<center><img src="images/profile-icon.png" class="img-responsive"></center>
		<h4 class="padding_5"> <b>User id:</b> <?php echo $user_id ?> </h4>
		<h4 class="padding_5"> <b>Username:</b> <?php echo $username ?> </h4>
		<h4 class="padding_5"> <b>Password:</b> <?php echo $password ?> </h4>
		<h4 class="padding_5"> <b>Email Address:</b> <?php echo $email ?> </h4>
		</div>
	</div>
	 
		
</div>

</body>
</html>
